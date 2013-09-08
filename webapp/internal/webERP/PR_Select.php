<?php

/* $Revision: 1.7 $ */

$PageSecurity = 11;

include('includes/session.inc');
$title = _('Search Production Runs');
include('includes/header.inc');

if (isset($_GET['SelectedStockItem'])){
	$SelectedStockItem=$_GET['SelectedStockItem'];
} elseif (isset($_POST['SelectedStockItem'])){
	$SelectedStockItem=$_POST['SelectedStockItem'];
}

if (isset($_GET['PRRef'])){
	$PRRef=$_GET['PRRef'];
} elseif (isset($_POST['PRRef'])){
	$PRRef=$_POST['PRRef'];
}

if (isset($_GET['SelectedSupplier'])){
	$SelectedSupplier=$_GET['SelectedSupplier'];
} elseif (isset($_POST['SelectedSupplier'])){
	$SelectedSupplier=$_POST['SelectedSupplier'];
}

echo '<FORM ACTION="' . $_SERVER['PHP_SELF'] . '?' . SID . '" METHOD=POST>';


If ($_POST['ResetPart']){
     unset($SelectedStockItem);
}

If (isset($PRRef) && $PRRef!="") {
	if (!is_numeric($PRRef)){
		  echo '<BR>';
		  prnMsg( _('The Production Run Number entered MUST be numeric') );
		  unset ($PRRef);
	} else {
		echo _('Production Run Number'). ' - '. $PRRef;
	}
} else {
	If ($SelectedSupplier) {
		echo _('For supplier'). ': '. $SelectedSupplier . ' ' . _('and'). ' ';
		echo '<input type=hidden name="SelectedSupplier" value="'. $SelectedSupplier. '">';
	}
	If ($SelectedStockItem) {
		 echo _('for the part'). ': ' . $SelectedStockItem . '.';
		echo '<input type=hidden name="SelectedStockItem" value="'. $SelectedStockItem. '">';
	}
}

if ($_POST['SearchParts']){

	If ($_POST['Keywords'] AND $_POST['StockCode']) {
		echo '<BR>';
		prnMsg( _('Stock description keywords have been used in preference to the Stock code extract entered'),'info');
	}
	$SQL = "SELECT stockmaster.stockid,
			description,
			SUM(locstock.quantity) AS qoh,
			units,
			SUM(productionrundetails.quantityord-productionrundetails.quantityrecd) AS qord
		FROM stockmaster INNER JOIN locstock
			ON stockmaster.stockid = locstock.stockid
		INNER JOIN productionrundetails
			ON stockmaster.stockid=productionrundetails.itemcode";

	If ($_POST['Keywords']) {
		//insert wildcard characters in spaces
		$i=0;
		$SearchString = '%';
		while (strpos($_POST['Keywords'], ' ', $i)) {
			$wrdlen=strpos($_POST['Keywords'],' ',$i) - $i;
			$SearchString=$SearchString . substr($_POST['Keywords'],$i,$wrdlen) . '%';
			$i=strpos($_POST['Keywords'],' ',$i) +1;
		}
		$SearchString = $SearchString. substr($_POST['Keywords'],$i).'%';

		$SQL .= " WHERE productionrundetails.prref<>''
			AND productionrundetails.prref<>0
			AND stockmaster.description " . LIKE . " '$SearchString'
			AND categoryid='" . $_POST['StockCat'] . "'";

	 } elseif ($_POST['StockCode']){

		$SQL .= " WHERE productionrundetails.prref<>''
			AND productionrundetails.prref<>0
			AND stockmaster.stockid " . LIKE . " '%" . $_POST['StockCode'] . "%'
			AND categoryid='" . $_POST['StockCat'];

	 } elseif (!$_POST['StockCode'] AND !$_POST['Keywords']) {
		$SQL .= " WHERE productionrundetails.prref<>''
			AND productionrundetails.prref<>0
			AND stockmaster.categoryid='" . $_POST['StockCat'] . "'";

	 }
	$SQL .= "  GROUP BY stockmaster.stockid,
				stockmaster.description,
				stockmaster.units
		 	ORDER BY stockmaster.stockid";

	$ErrMsg = _('No Stock Items were returned from the database because'). ' - '. DB_error_msg($db);
	$StockItemsResult = DB_query($SQL,$db, $ErrMsg);

}


if ($PRRef=="" OR !isset($PRRef)){

	echo _('Production Run Number'). ': <INPUT type=text name="PRRef" MAXLENGTH =10 SIZE=10> '.
		_('At Work Centre').' :<SELECT name="StockLocation"> ';
	$sql = "SELECT code, location, description FROM workcentres";
	$resultStkLocs = DB_query($sql,$db);
	while ($myrow=DB_fetch_array($resultStkLocs)){
		if (isset($_POST['StockLocation'])){
			if ($myrow['code'] == $_POST['StockLocation']){
			echo '<OPTION SELECTED Value="' . $myrow['code'] . '">' . $myrow['description'];
			} else {
			echo '<OPTION Value="' . $myrow['code'] . '">' . $myrow['description'];
			}
		} elseif ($myrow['code']==$_SESSION['UserStockLocation']){
			$_POST['StockLocation'] = $_SESSION['UserStockLocation'];
			echo '<OPTION SELECTED Value="' . $myrow['code'] . '">' . $myrow['description'];
		} else {
			echo '<OPTION Value="' . $myrow['code'] . '">' . $myrow['description'];
		}
	}

	echo '</SELECT>';
	echo ' <SELECT NAME="OpenOrClosed">';
	if ($_POST['OpenOrClosed']==1){
		echo '<OPTION SELECTED VALUE=1>'. _('Closed Production Runs Only');
		echo '<OPTION VALUE=0>'. _('Open Production Runs Only');
	} else {
		$_POST['OpenOrClosed']=0;
		echo '<OPTION VALUE=1>'. _('Closed Production Runs Only');
		echo '<OPTION SELECTED VALUE=0>'. _('Open Production Runs Only');
	}
	echo '</SELECT>';

	echo '<BR><CENTER><INPUT TYPE=SUBMIT NAME="SearchProductionRun" VALUE="'. _('Search Production Runs'). '">';
}

$SQL="SELECT categoryid, 
		categorydescription 
	FROM stockcategory 
	WHERE stocktype<>'D' 
	ORDER BY categorydescription";
$result1 = DB_query($SQL,$db);

?>

<HR>
<FONT SIZE=1><?php echo _('To search for production runs for a specific part use the part selection facilities below');?></FONT>
<INPUT TYPE=SUBMIT NAME="SearchParts" VALUE="<?php echo _('Search Parts Now');?>">
<INPUT TYPE=SUBMIT NAME="ResetPart" VALUE="<?php echo _('Show All');?>">
<TABLE>
<TR>
<TD><FONT SIZE=1><?php echo _('Select a stock category');?>:</FONT>
<SELECT NAME="StockCat">
<?php
while ($myrow1 = DB_fetch_array($result1)) {
	if ($myrow1['categoryid']==$_POST['StockCat']){
		echo '<OPTION SELECTED VALUE="'. $myrow1['categoryid'] . '">' . $myrow1['categorydescription'];
	} else {
		echo '<OPTION VALUE="'. $myrow1['categoryid'] . '">' . $myrow1['categorydescription'];
	}
}
?>
</SELECT>
<TD><FONT SIZE=1><?php echo _('Enter text extracts in the');?> <B><?php echo _('description');?></B>:</FONT></TD>
<TD><INPUT TYPE="Text" NAME="Keywords" SIZE=20 MAXLENGTH=25></TD></TR>
<TR><TD></TD>
<TD><FONT SIZE 3><B><?php echo _('OR');?> </B></FONT><FONT SIZE=1><?php echo _('Enter extract of the');?> <B><?php echo _('Stock Code');?></B>:</FONT></TD>
<TD><INPUT TYPE="Text" NAME="StockCode" SIZE=15 MAXLENGTH=18></TD>
</TR>
</TABLE>

<HR>

<?php

If (isset($StockItemsResult)) {

	echo "<TABLE CELLPADDING=2 COLSPAN=7 BORDER=2>";
	$TableHeader = '<TR>
			<TD class="tableheader">'. _('Code').'</TD>
			<TD class="tableheader">'. _('Description').'</TD>
			<TD class="tableheader">'. _('On Hand').'</TD>
			<TD class="tableheader">'. _('Orders') . '<BR>' . _('Outstanding').'</TD>
			<TD class="tableheader">'. _('Units').'</TD>
			</TR>';

	echo $TableHeader;

	$j = 1;
	$k=0; //row colour counter

	while ($myrow=DB_fetch_array($StockItemsResult)) {

		if ($k==1){
			echo '<tr bgcolor="#CCCCCC">';
			$k=0;
		} else {
			echo '<tr bgcolor="#EEEEEE">';
			$k=1;
		}
/*
Code	 Description	On Hand		 Orders Ostdg     Units		 Code	Description 	 On Hand     Orders Ostdg	Units	 */
		printf('<td><INPUT TYPE=SUBMIT NAME="SelectedStockItem" VALUE="%s"</td>
			<td>%s</td>
			<td ALIGN=RIGHT>%s</td>
			<td ALIGN=RIGHT>%s</td>
			<td>%s</td></tr>',
			$myrow['stockid'], $myrow['description'], $myrow['qoh'], $myrow['qord'],$myrow['units']);

		$j++;
		If ($j == 15){
			$j=1;
			echo $TableHeader;
		}
//end of page full new headings if
	}
//end of while loop

	echo '</TABLE>';

}
//end if stock search results to show
  else {

	//figure out the SQL required from the inputs available

	if (isset($PRRef) && $PRRef !="") {
		$SQL = "SELECT productionruncosting.prref, 
				other, 
				otherref,
				supplierid, 
				workcentres.description, 
				productionruncosting.eta, 
				productionruncosting.closed
			FROM productionruncosting INNER JOIN workcentres
				ON productionruncosting.supplierid = workcentres.code
			WHERE productionruncosting.prref=". $PRRef;
	} else {
		$SQL = "SELECT DISTINCT productionruncosting.prref, other, otherref, supplierid, workcentres.description, productionruncosting.eta, productionruncosting.closed
			FROM productionruncosting INNER JOIN workcentres
				ON productionruncosting.supplierid = workcentres.code
			INNER JOIN productionrundetails
				ON productionrundetails.prref=productionruncosting.prref
			INNER JOIN productionruns
				ON productionrundetails.prno=productionruns.prno
			";

		if (isset($SelectedSupplier)) {

			if (isset($SelectedStockItem)) {
					$SQL .= " WHERE productionrundetails.itemcode='". $SelectedStockItem ."'
						AND productionruncosting.supplierid='" . $_POST['StockLocation'] ."'
						AND productionruns.workcentre = '". $_POST['StockLocation'] . "'
						AND productionruncosting.closed=" . $_POST['OpenOrClosed'];
			} else {
				$SQL .= "WHERE productionruncosting.supplierid='" . $_POST['StockLocation'] ."'
					AND productionruns.workcentre = '". $_POST['StockLocation'] . "'
					AND productionruncosting.closed=" . $_POST['OpenOrClosed'];
			}
		} else { //no supplier selected
			if (isset($SelectedStockItem)) {
				$SQL .= "WHERE productionrundetails.itemcode='". $SelectedStockItem ."'
					AND productionruns.workcentre = '". $_POST['StockLocation'] . "'
					AND productionruncosting.closed=" . $_POST['OpenOrClosed'];
			} else {
				$SQL .= "WHERE productionruns.workcentre = '". $_POST['StockLocation'] . "'
					AND productionruncosting.closed=" . $_POST['OpenOrClosed'];
			}

		} //end selected supplier
	} //end not order number selected

	$ErrMsg = _('No production runs were returned by the SQL because');
	$ProductionRunsResult = DB_query($SQL,$db,$ErrMsg);


	if (DB_num_rows($ProductionRunsResult)>0){
		/*show a table of the production runs returned by the SQL */

		echo '<TABLE CELLPADDING=2 COLSPAN=7 WIDTH=100%>';
		$TableHeader = '<TR>
				<TD class="tableheader">'. _('Production Run'). '</TD>
				<TD class="tableheader">'. _('Work Centre'). '</TD>
				<TD class="tableheader">'. _('Other'). '</TD>
				<TD class="tableheader">'. _('Other Ref.'). '</TD>
				<TD class="tableheader">'. _('Expected Completion'). '</TD>
				</TR>';

		echo $TableHeader;

		$j = 1;
		$k=0; //row colour counter
		while ($myrow=DB_fetch_array($ProductionRunsResult)) {


			if ($k==1){ /*alternate bgcolour of row for highlighting */
				echo '<tr bgcolor="#CCCCCC">';
				$k=0;
			} else {
				echo '<tr bgcolor="#EEEEEE">';
				$k++;
			}

			$URL_Modify_ProductionRun = $rootpath . '/ProductionRunCosting.php?' . SID . 'SelectedProductionRunCosting=' . $myrow['prref'];
			$URL_View_ProductionRun = $rootpath . '/PRCosting.php?' . SID . 'SelectedProductionRunCosting=' . $myrow['prref'];

			$FormatedETA = ConvertSQLDate($myrow['eta']);
			/* PRRef   Supplier  Vessel  Voyage  ETA */

			if ($myrow['closed']==0){

				$URL_Close_ProductionRun = $URL_View_ProductionRun . '&Close=Yes';

				printf('<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td><A HREF="%s">'._('Costing').'</A></td>
					<td><A HREF="%s">'._('Modify').'</A></td>
					<td><A HREF="%s"><B>'._('Close').'</B></A></td>
					</tr>', 
					$myrow['prref'], 
					$myrow['description'], 
					$myrow['other'], 
					$myrow['otherref'],
					$FormatedETA, 
					$URL_View_ProductionRun, 
					$URL_Modify_ProductionRun,
					$URL_Close_ProductionRun);

			} else {
				printf('<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td><A HREF="%s">'._('Costing').'</A></td>
					</tr>', 
					$myrow['prref'], 
					$myrow['description'], 
					$myrow['vessel'], 
					$myrow['voyage'],
					$FormatedETA, 
					$URL_View_ProductionRun);
			}
			$j++;
			If ($j == 15){
				$j=1;
				echo $TableHeader;
			}
		//end of page full new headings if
		}
		//end of while loop

		echo '</TABLE>';
	} // end if production runs to show
}

echo '</FORM>';
include('includes/footer.inc');
?>
