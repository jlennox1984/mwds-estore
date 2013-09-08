<?php
/* $Revision: 1.4 $ */
$PageSecurity=15;

include('includes/session.inc');

$title = _('Tax Groups');
include('includes/header.inc');

if (isset($_GET['SelectedGroup'])){
	$SelectedGroup = $_GET['SelectedGroup'];
} elseif (isset($_POST['SelectedGroup'])){
	$SelectedGroup = $_POST['SelectedGroup'];
}

if (isset($_POST['submit']) OR isset($_GET['remove']) OR isset($_GET['add']) ) {

	//initialise no input errors assumed initially before we test
	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */
	//first off validate inputs sensible
	if (isset($_POST['GroupName']) && strlen($_POST['GroupName'])<4){
		$InputError = 1;
		prnMsg(_('The Group description entered must be at least 4 characters long'),'error');
	}
	
	// if $_POST['GroupName'] then it is a modification of a tax group name
	// else it is either an add or remove of taxgroup 
	unset($sql);
	if (isset($_POST['GroupName']) ){ // Update or Add a tax group
		if(isset($SelectedGroup)) { // Update a tax group
			$sql = "UPDATE taxgroups SET taxgroupdescription = '". DB_escape_string($_POST['GroupName']) ."' 
					WHERE taxgroupid = ".$SelectedGroup;
			$ErrMsg = _('The update of the tax group description failed because');
			$SuccessMsg = _('The tax group description was updated to') . ' ' . $_POST['GroupName'];
		} else { // Add new tax group
		
			$result = DB_query("SELECT taxgroupid FROM taxgroups WHERE taxgroupdescription='" . $_POST['GroupName'] . "'",$db);
			if (DB_num_rows($result)==1){
				prnMsg( _('A new tax group could not be added because a tax group already exists for') . ' ' . $_POST['GroupName'],'warn');
				unset($sql);
			} else {
				$sql = "INSERT INTO taxgroups (taxgroupdescription) VALUES ('". DB_escape_string($_POST['GroupName']) . "')";
				$ErrMsg = _('The addition of the group failed because');
				$SuccessMsg = _('Added the new tax group') . ' ' . $_POST['GroupName'];
			}
		}
		unset($_POST['GroupName']);
		unset($SelectedGroup);
	} elseif (isset($SelectedGroup) ) {
		$TaxAuthority = $_GET['TaxAuthority'];
		if( isset($_GET['add']) ) { // adding a tax authority to a tax group
			$sql = "INSERT INTO taxgrouptaxes ( taxgroupid, 
								taxauthid,
								calculationorder) 
					VALUES (" . $SelectedGroup . ", 
						" . $TaxAuthority . ",
						0)";
					/*
  * VITUREMART TAX SETUP JD MONCRIEFF
  *
  */
	
			//get info form authtable 

			 require('estore.conf.php');
				$sqllocation="SELECT  state_abr ,country_abr FROM  taxauthorities where taxid='$TaxAuthority'";
					$result=DB_query($sqllocation,$db);
					$myinfo=mysql_fetch_array($result);
					//date Infomation//
					$mdate=time();
					//Get tax rate infomation draw from estore taxcatid 10 Tax Catorgory//
					
					$sql_taxrate= "select taxrate from   taxauthrates
					  where taxauthority='$TaxAuthority' 
					  and taxcatid='10' and  dispatchtaxprovince='$tax_dispatch'";
					  $result=DB_query($sql_taxrate,$db);
					$mytaxrate=mysql_fetch_array($result);
					  $taxrate_raw=$mytaxrate['taxrate'];
					  $taxrate=number_format($taxrate_raw,4);
					  $state=$myinfo['state_abr'];
					$country=$myinfo['country_abr'];
					global $state;
					global $country;
					
					//date Infomation//
					//loop control
					$sqlcount = "select count(*) as control FROM jos_vm_tax_rate where tax_state='$state' and tax_country='$country'";//TODO:add vendor where clause when vendor is completed tax
					  $result=DB_query($sqlcount,$db);
					$mycontrol=mysql_fetch_array($result);
					  $control=$mycontrol['control'];
					$mdate=time();
					$jom_sql="INSERT INTO  jos_vm_tax_rate (vendor_id,
					tax_state,
					tax_country,
					mdate,
					tax_rate)VALUES ('1','$state','$country', '$mdate','$taxrate')";
			$ErrMsg = _('The addition of the tax failed because');
	if($esdebug =='1'){ 
			prnMsg( _('taxrate for shoping has be set to ' .$taxrate));
			 prnMsg( _('tax rate query:' .$sql_taxrate));
	} 
			$SuccessMsg = _('The tax  was added.');
		} elseif ( isset($_GET['remove']) ) { // remove a taxauthority from a tax group
			$sql = "DELETE FROM taxgrouptaxes 
					WHERE taxgroupid = ".$SelectedGroup."
					AND taxauthid = ".$TaxAuthority;
			$sqllocation="SELECT  state_abr ,country_abr FROM  taxauthorities where taxid='$TaxAuthority'";
					$result=DB_query($sqllocation,$db);
					$myinfo=mysql_fetch_array($result);
					 $state=$myinfo['state_abr'];
					$country=$myinfo['country_abr'];
					
  					$jom_del_sql="DELETE FROM  jos_vm_tax_rate 
		     where tax_state='$state' AND tax_country='$country'";
		    
			$ErrMsg = _('The removal of this tax failed because');
			$SuccessMsg = _('This tax was removed.');
		

		unset($_GET['add']);
		//unset($_GET['remove']);
		unset($_GET['TaxAuthority']);
	}
	}
 $delmod=$_GET['remove'];
	// Need to exec the query
	if (isset($sql) && $InputError != 1 ) {
		$result = DB_query($sql,$db,$ErrMsg);
		if (isset($jom_del_sql) && $InputError != 1 ) {
		$result = DB_query($jom_del_sql,$db,$ErrMsg);
		}
		if (isset($jom_sql)&&($control == '0')){
		$result = DB_query($jom_sql,$db);
		/*if ($delmod == '1') { 
			$result=DB_query($jom_del_sql,$db);
*/
				
	unset($_GET['remove']);
	//	}
	}
		if( $result ) {
			prnMsg( $SuccessMsg,'success');
			if($esdebug =='1'){ 
			prnMsg( _('control:' .$control));
			  prnMsg( _('control delete:' .$_GET['remove']));
			 prnMsg( _(' vm delete statment:' .$jom_sql));
		}
		}
	}
} elseif (isset($_POST['UpdateOrder'])) {
	//A calculation order update
	$sql = 'SELECT taxauthid FROM taxgrouptaxes WHERE taxgroupid=' . $SelectedGroup;
	$Result = DB_query($sql,$db,_('Could not get tax authorities in the selected tax group'));
	
	while ($myrow=DB_fetch_row($Result)){
		
		if (is_numeric($_POST['CalcOrder_' . $myrow[0]]) AND $_POST['CalcOrder_' . $myrow[0]] <5){
		
			$sql = 'UPDATE taxgrouptaxes 
				SET calculationorder=' . $_POST['CalcOrder_' . $myrow[0]] . ',
					taxontax=' . $_POST['TaxOnTax_' . $myrow[0]] . '
				WHERE taxgroupid=' . $SelectedGroup . '
				AND taxauthid=' . $myrow[0];
						
			$result = DB_query($sql,$db);
		}
	}
	
	//need to do a reality check to ensure that taxontax is relevant only for taxes after the first tax
	$sql = 'SELECT taxauthid, 
			taxontax 
		FROM taxgrouptaxes 
		WHERE taxgroupid=' . $SelectedGroup . '
		ORDER BY calculationorder';
		
	$Result = DB_query($sql,$db,_('Could not get tax authorities in the selected tax group'));
	
	if (DB_num_rows($Result)>0){
		$myrow=DB_fetch_array($Result);
		if ($myrow['taxontax']==1){
			prnMsg(_('It is inappropriate to set tax on tax where the tax is the first in the calculation order. The system has changed it back to no tax on tax for this tax authority'),'warning');
			$Result = DB_query('UPDATE taxgrouptaxes SET taxontax=0 WHERE taxgroupid=' . $SelectedGroup . ' AND taxauthid=' . $myrow['taxauthid'],$db);
		}
	}
} elseif (isset($_GET['Delete'])) { 
	
	/* PREVENT DELETES IF DEPENDENT RECORDS IN 'custbranch, suppliers */
	
	$sql= "SELECT COUNT(*) FROM custbranch WHERE taxgroupid=" . $_GET['SelectedGroup'];
	$result = DB_query($sql,$db);
	$myrow = DB_fetch_row($result);
	if ($myrow[0]>0) {
		prnMsg( _('Cannot delete this tax group because some customer branches are setup using it'),'warn');
		echo '<BR>' . _('There are') . ' ' . $myrow[0] . ' ' . _('customer branches referring to this tax group');
	} else {
		$sql= "SELECT COUNT(*) FROM suppliers WHERE taxgroupid=" . $_GET['SelectedGroup'];
		$result = DB_query($sql,$db);
		$myrow = DB_fetch_row($result);
		if ($myrow[0]>0) {
			prnMsg( _('Cannot delete this tax group because some suppliers are setup using it'),'warn');
			echo '<BR>' . _('There are') . ' ' . $myrow[0] . ' ' . _('suppliers referring to this tax group');
		} else {
	
			$sql="DELETE FROM taxgrouptaxes WHERE taxgroupid=" . $_GET['SelectedGroup'];
			$result = DB_query($sql,$db);
			$sql="DELETE FROM taxgroups WHERE taxgroupid=" . $_GET['SelectedGroup'];
			$result = DB_query($sql,$db);
			prnMsg( $_GET['GroupName'] . ' ' . _('tax group has been deleted') . '!','success');
		}
	} //end if taxgroup used in other tables
	unset($SelectedGroup);
	unset($_GET['GroupName']);
}

if (!isset($SelectedGroup)) {

/* If its the first time the page has been displayed with no parameters then none of the above are true and the list of tax groups will be displayed with links to delete or edit each. These will call the same page again and allow update/input or deletion of tax group taxes*/

	$sql = "SELECT taxgroupid,
			taxgroupdescription
		FROM taxgroups";
	$result = DB_query($sql,$db);

	if( DB_num_rows($result) == 0 ) {
		echo '<CENTER>';
		prnMsg(_('There are no tax groups configured.'),'info');
		echo '</CENTER>';
	} else {
		echo '<CENTER><table border=1>';
		echo "<TR><TD class='tableheader'>" . _('Group No') . "</TD>
			<TD class='tableheader'>" . _('Tax Group') . "</TD></TR>";
	
		$k=0; //row colour counter
		while ($myrow = DB_fetch_array($result)) {
			if ($k==1){
				echo "<tr bgcolor='#CCCCCC'>";
				$k=0;
			} else {
				echo "<tr bgcolor='#EEEEEE'>";
				$k=1;
			}
	
			printf("<td>%s</td>
				<td>%s</td>
				<td><a href=\"%s&SelectedGroup=%s\">" . _('Edit') . "</A></TD>
				<TD><A HREF=\"%s&SelectedGroup=%s&Delete=1&GroupID=%s\">" . _('Delete') . "</A></TD>
				</tr>",
				$myrow['taxgroupid'],
				$myrow['taxgroupdescription'],
				$_SERVER['PHP_SELF']  . "?" . SID,
				$myrow['taxgroupid'],
				$_SERVER['PHP_SELF'] . "?" . SID,
				$myrow['taxgroupid'],
				urlencode($myrow['taxgroupdescription']));
	
		} //END WHILE LIST LOOP
		echo '</TABLE></CENTER>';
	}
} //end of ifs and buts!


if (isset($SelectedGroup)) {
	echo "<CENTER><A HREF='" . $_SERVER['PHP_SELF'] ."?" . SID . "'>" . _('Review Existing Groups') . '</A></CENTER>';
}

if (isset($SelectedGroup)) {
	//editing an existing role

	$sql = "SELECT taxgroupid,
			taxgroupdescription
		FROM taxgroups
		WHERE taxgroupid=" . $SelectedGroup;
	$result = DB_query($sql, $db);
	if ( DB_num_rows($result) == 0 ) {
		prnMsg( _('The selected tax group is no longer available.'),'warn');
	} else {
		$myrow = DB_fetch_array($result);
		$_POST['SelectedGroup'] = $myrow['taxgroupid'];
		$_POST['GroupName'] = $myrow['taxgroupdescription'];
	}
}
echo '<BR>';
echo "<FORM METHOD='post' action=" . $_SERVER['PHP_SELF'] . "?" . SID . ">";
if( isset($_POST['SelectedGroup'])) {
	echo "<INPUT TYPE=HIDDEN NAME='SelectedGroup' VALUE='" . $_POST['SelectedGroup'] . "'>";
}
echo '<CENTER><TABLE>';
echo '<TR><TD>' . _('Tax Group') . ":</TD>
	<TD><INPUT TYPE='text' name='GroupName' SIZE=40 MAXLENGTH=40 VALUE='" . $_POST['GroupName'] . "'></TD></TR>";
echo "</TABLE>
	<CENTER><input type='Submit' name='submit' value='" . _('Enter Group') . "'></CENTER></FORM>";

if (isset($SelectedGroup)) {

	$sql = 'SELECT taxid, 
			description as taxname 
			FROM taxauthorities
		ORDER BY taxid';
	
	$sqlUsed = "SELECT taxauthid,
				description AS taxname,
				calculationorder, 
				taxontax 
			FROM taxgrouptaxes INNER JOIN taxauthorities
				ON taxgrouptaxes.taxauthid=taxauthorities.taxid
			WHERE taxgroupid=". $SelectedGroup . ' 
			ORDER BY calculationorder';
	
	$Result = DB_query($sql, $db);
	
	/*Make an array of the used tax authorities in calculation order */
	$UsedResult = DB_query($sqlUsed, $db);
	$TaxAuthsUsed = array(); //this array just holds the taxauthid of all authorities in the group
	$TaxAuthRow = array(); //this array holds all the details of the tax authorities in the group
	$i=1;
	while ($myrow=DB_fetch_array($UsedResult)){
		$TaxAuthsUsed[$i] = $myrow['taxauthid'];
		$TaxAuthRow[$i] = $myrow;
		$i++;
	}
		
	if (DB_num_rows($Result)>0 ) {
		echo '<BR>';
		echo '<CENTER><TABLE><TR>';
		echo "<TD class='tableheader' colspan=4 ALIGN=CENTER>"._('Assigned Taxes')."</TD>";
		echo '<TD></TD>';
		echo "<TD class='tableheader' colspan=2 ALIGN=CENTER>"._('Available Taxes')."</TD>";
		echo '</TR>';
		echo '<TR>';
		
		echo "<TD class='tableheader'>" . _('Tax Auth ID') . '</TD>';
		echo "<TD class='tableheader'>" . _('Tax Authority Name') . '</TD>';
		echo "<TD class='tableheader'>" . _('Calculation Order') . '</TD>';
		echo "<TD class='tableheader'>" . _('Tax on Prior Tax(es)') . '</TD>';
		echo '<TD></TD>';
		echo "<TD class='tableheader'>" . _('Tax Auth ID') . '</TD>';
		echo "<TD class='tableheader'>" . _('Tax Authority Name') . '</TD>';
		echo '</TR>';
		
	} else {
		echo '<BR><CENTER>' . _('There are no tax authorities defined to allocate to this tax group');
	}
	
	$k=0; //row colour counter
	while($AvailRow = DB_fetch_array($Result)) {
				
		if ($k==1){
			echo "<TR bgcolor='#CCCCCC'>";
			$k=0;
		} else {
			echo "<TR bgcolor='#EEEEEE'>";
			$k=1;
		}
		$TaxAuthUsedPointer = array_search($AvailRow['taxid'],$TaxAuthsUsed);
		
		if ($TaxAuthUsedPointer){
			
			if ($TaxAuthRow[$TaxAuthUsedPointer]['taxontax'] ==1){
				$TaxOnTax = _('Yes');
			} else {
				$TaxOnTax = _('No');
			}
			
			printf("<TD>%s</TD>
				<TD>%s</TD>
				<TD>%s</TD>
				<TD>%s</TD>
				<TD><A href=\"%s&SelectedGroup=%s&remove=1&TaxAuthority=%s\">" . _('Remove') . "</A></TD>
				<TD>&nbsp;</TD>
				<TD>&nbsp;</TD>",
				$AvailRow['taxid'],
				$AvailRow['taxname'],
				$TaxAuthRow[$TaxAuthUsedPointer]['calculationorder'],
				$TaxOnTax,
				$_SERVER['PHP_SELF']  . "?" . SID,
				$SelectedGroup,
				$AvailRow['taxid']
				);
			
		} else {
			printf("<TD>&nbsp;</TD>
				<TD>&nbsp;</TD>
				<TD>&nbsp;</TD>
				<TD>&nbsp;</TD>
				<TD>&nbsp;</TD>
				<TD>%s</TD>
				<TD>%s</TD>
				<TD><A href=\"%s&SelectedGroup=%s&add=1&TaxAuthority=%s\">" . _('Add') . "</A></TD>",
				$AvailRow['taxid'],
				$AvailRow['taxname'],
				$_SERVER['PHP_SELF']  . "?" . SID,
				$SelectedGroup,
				$AvailRow['taxid']
				);
		}	
		echo '</TR>';
	}
	echo '</TABLE></CENTER>';
	
	/* the order and tax on tax will only be an issue if more than one tax authority in the group */
	if (count($TaxAuthsUsed)>1) { 
		echo '<BR><CENTER><FONT SIZE=3 COLOR=BLUE>'._('Calculation Order').'</FONT></CENTER>';
		echo '<FORM METHOD="post" action="' . $_SERVER['PHP_SELF'] . '?' . SID .'">';
		echo '<INPUT TYPE=HIDDEN NAME="SelectedGroup" VALUE="' . $SelectedGroup .'">';
		echo '<CENTER><TABLE>';
			
		echo '<TR><TD class="tableheader">'._('Tax Authority').'</TD>
			<TD class="tableheader">'._('Order').'</TD>
			<TD class="tableheader">'._('Tax on Prior Taxes').'</TD></TR>';
		$k=0; //row colour counter
		for ($i=1;$i < count($TaxAuthRow)+1;$i++) {
			if ($k==1){
				echo "<TR BGCOLOR='#CCCCCC'>";
				$k=0;
			} else {
				echo "<TR BGCOLOR='#EEEEEE'>";
				$k=1;
			}
			
			if ($TaxAuthRow[$i]['calculationorder']==0){
				$TaxAuthRow[$i]['calculationorder'] = $i;
			}
			
			echo '<TD>' . $TaxAuthRow[$i]['taxname'] . '</TD><TD>'.
				'<INPUT TYPE="Text" NAME="CalcOrder_' . $TaxAuthRow[$i]['taxauthid'] . '" VALUE="' . $TaxAuthRow[$i]['calculationorder'] . '" size=2 maxlength=2></TD>';
			echo '<TD><SELECT NAME="TaxOnTax_' . $TaxAuthRow[$i]['taxauthid'] . '">';
			if ($TaxAuthRow[$i]['taxontax']==1){
				echo '<OPTION SELECTED VALUE=1>' . _('Yes');
				echo '<OPTION VALUE=0>' . _('No');
			} else {
				echo '<OPTION VALUE=1>' . _('Yes');
				echo '<OPTION SELECTED VALUE=0>' . _('No');
			}
			echo '</SELECT></TD></TR>';       
			
		}
		echo '</TABLE></CENTER>';
		echo '<CENTER><input type="Submit" name="UpdateOrder" value="' . _('Update Order') . '"></CENTER>';
	}
	
	echo '</FORM>';
		
}


include('includes/footer.inc');
?>