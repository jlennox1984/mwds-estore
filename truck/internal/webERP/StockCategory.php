<?php
/* $Revision: 1.8 $ */

$PageSecurity = 11;

include('includes/session.inc');
include('estore.conf.php');
$title = _('Stock Category Maintenance');

include('includes/header.inc');
/* OLD EDITOR Jmoncrieff
/*echo '<script language="JavaScript" type="text/javascript" src="editors/openwysiwg/wysiwyg.js"></script>';
/*If this form is called with the StockID then it is assumed that the stock item is to be modified */
/* New Editor*/
echo ' <script language="javascript" type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>';
echo ' <script language="javascript" type="text/javascript"> ';
echo '	tinyMCE.init({  ';
	echo '	mode : "textareas", ';
	echo '	theme : "advanced", ';
	echo '	plugins :  "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",
		theme_advanced_buttons1_add_before : "save,newdocument,separator",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "emotions,iespell,media,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
		theme_advanced_toolbar_location : "top",
 		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		content_css : "example_word.css",
	    plugi2n_insertdate_dateFormat : "%Y-%m-%d",
	    plugi2n_insertdate_timeFormat : "%H:%M:%S",
		external_link_list_url : "example_link_list.js",
		external_image_list_url : "example_image_list.js",
		media_external_list_url : "example_media_list.js",
		file_browser_callback : "fileBrowserCallBack",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		paste_auto_cleanup_on_paste : true,
		paste_convert_headers_to_strong : false,
		paste_strip_class_attributes : "all",
		paste_remove_spans : false,
		paste_remove_styles : false		
	});

	function fileBrowserCallBack(field_name, url, type, win) {
		// This is where you insert your custom filebrowser logic
		alert("Filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

		// Insert new URL, this would normaly be done in a popup
		win.document.forms[0].elements[field_name].value = "someurl.htm";
	}

</script> ';

if (isset($_GET['SelectedCategory'])){
	$SelectedCategory = strtoupper($_GET['SelectedCategory']);
} else if (isset($_POST['SelectedCategory'])){
	$SelectedCategory = strtoupper($_POST['SelectedCategory']);
}

if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test
	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible
//Mod by J. Moncrieff
$Catid= $_POST['CategoryID'];
if (isset($_FILES['ItemPicture']) AND $_FILES['ItemPicture']['name'] !='') {
 require('estore.conf.php');
require('tumb.php');
        $result    = $_FILES['ItemPicture']['error'];
	$Catid_up = strtoupper($Catid);
        $UploadTheFile = 'Yes'; //Assume all is well to start off with
        $filename = $catpictdir . '/'  . $Catid_up .  '.jpg';
        //testing save routine
        //$filename= . $absolpathestore_cat_pics . '/' . $Catid. '.jpg';
        $filename1 = '/' . $Catid . '.jpg';
        $savefilename = 'test/product/' . $Catid. '.jpg';
        $filename2 = '../vtiger_crm/test/product/' . $Catid. '.jpg';
        // $filename3 = '../../components/com_virtuemart/shop_image/product/' . $Catid.'.jpg;';
        //$filename2 = $_SESSION['part_pics_dir'] . '/' . $Catid. 'a.jpg';
         // $filename4 =  '$absolpathestore_pics'  . $Catid.   '.jpg';
         $filename3 = '../../cat-pict/' . $Catid.'.jpg';
        //But check for the worst
        if (strtoupper(substr(trim($_FILES['ItemPicture']['name']),strlen($_FILES['ItemPicture']['name'])-3))!='JPG'){
                prnMsg(_('Only jpg files are supported - a file extension of .jpg is expected'),'warn');
                $UploadTheFile ='No';
        } elseif ( $_FILES['ItemPicture']['size'] > ($_SESSION['MaxImageSize']*1024)) { //File Size Check
                prnMsg(_('The file size is over the maximum allowed. The maximum size allowed in KB is') . ' ' . $_SESSION['MaxImageSize'],'warn');
                $UploadTheFile ='No';
        } elseif ( $_FILES['ItemPicture']['type'] == "text/plain" ) {  //File Type Check
                prnMsg( _('Only graphics files can be uploaded'),'warn');
                $UploadTheFile ='No';
        } elseif (file_exists($filename)){
                prnMsg(_('Attempting to overwrite an existing item image'),'warn');
                $result = unlink($filename);
                if (!$result){
                        prnMsg(_('The existing image could not be removed'),'error');
                        $UploadTheFile ='No';
                }
        }

        if ($UploadTheFile=='Yes'){
                $result  =  move_uploaded_file($_FILES['ItemPicture']['tmp_name'], $filename);
                        $result  =  move_uploaded_file($filename, $filename3);
        //$result =   move_uploaded_file($_FILES['ItemPicture']['tmp_name'], $filename4);
                        $result=tn($catpictdir,$filename,$Catid);
                        copy($filename,$filename3);
                $result = move_uploaded_file($_FILES['ItemPicture']['tmp_name'], $filename2);

        $result  =  move_uploaded_file($filename, $filename3);
        //$result =   move_uploaded_file($_FILES['ItemPicture']['tmp_name'], $filename4);

                        copy($filename,$filename3);
                $result = move_uploaded_file($_FILES['ItemPicture']['tmp_name'], $filename2);
                $message = ($result)?_('File url') ."<a href='". $filename ."'>" .  $filename . '</a>' : _('Something is wrong with uploading a file');
                $message = ($result2)?_('File url') ."<a href='". $filename2 ."'>" .  $filename2 . '</a>' : _('Something is wrong with uploading a file');



                prnMsg( _('estore product thumbnal have been saved in ' .$filename3));

                                                                                                     

//End Mod
}
}
	$_POST['CategoryID'] = strtoupper($_POST['CategoryID']);

	if (strlen($_POST['CategoryID']) > 6) {
		$InputError = 1;
		prnMsg(_('The Inventory Category code must be six characters or less long'),'error');
	} elseif (strlen($_POST['CategoryID'])==0) {
		$InputError = 1;
		prnMsg(_('The Inventory category code must be at least 1 character but less than six characters long'),'error');
	} elseif (strlen($_POST['CategoryDescription']) >20) {
		$InputError = 1;
		prnMsg(_('The Sales category description must be twenty characters or less long'),'error');
	} elseif ($_POST['StockType'] !='D' AND $_POST['StockType'] !='L' AND $_POST['StockType'] !='F' AND $_POST['StockType'] !='M') {
		$InputError = 1;
		prnMsg(_('The stock type selected must be one of') . ' "D" - ' . _('Dummy item') . ', "L" - ' . _('Labour stock item') . ', "F" - ' . _('Finished product') . ' ' . _('or') . ' "M" - ' . _('Raw Materials'),'error');
	}

	if ($SelectedCategory AND $InputError !=1) {

		/*SelectedCategory could also exist if submit had not been clicked this code
		would not run in this case cos submit is false of course  see the
		delete code below*/
              $timestamp=time();
		$Catid= $_POST['CategoryID'];    
		$thumb=$catpicurl . '/' . $Catid . '-thumb.jpg';
 	       $picportal = $catpicurl . '/' . $Catid . '.jpg';
		$sql = "UPDATE stockcategory SET stocktype = '" . $_POST['StockType'] . "',
                                     categorydescription = '" . DB_escape_string($_POST['CategoryDescription']) . "',
                                     stockact = " . $_POST['StockAct'] . ",
                                     adjglact = " . $_POST['AdjGLAct'] . ",
                                     purchpricevaract = " . $_POST['PurchPriceVarAct'] . ",
                                     materialuseagevarac = " . $_POST['MaterialUseageVarAc'] . ",
                                     wipact = " . $_POST['WIPAct'] . "
                                     WHERE
                                     categoryid = '$SelectedCategory'";
                                  
					 $sql1=  "UPDATE jos_vm_category 
					SET category_description = '" . DB_escape_string($_POST['CategoryDescriptionLong']) . "',
  					category_name='". $_POST['CategoryName'] ."',    
					category_publish='". $_POST['CategoryOnline']  . "',
					list_order='".$_POST['catorder'] ."',
                                          category_thumb_image='$thumb',
                			  category_full_image='$picportal',
             				   mdate='$timestamp' 	WHERE ptcode='$SelectedCategory'";
					 //Only run viture mart updates
					$result = DB_query($sql1,$db);

		$msg = _('The stock category record has been updated only CMS Module ');
	} elseif ($InputError !=1) {

	/*Selected category is null cos no item selected on first time round so must be adding a	record must be submitting new entries in the new stock category form */
unset($Catid);         
     $Catid= $_POST['CategoryID'];
               $picportal = $catpicurl . '/' . $Catid . '.jpg';
		$thumb=$catpicurl . '/' . $Catid . '-thumb.jpg';
		$sql = "INSERT INTO stockcategory (categoryid,
                                       stocktype,
                                       categorydescription,
                                       stockact,
                                       adjglact,
                                       purchpricevaract,
                                       materialuseagevarac,
                                       wipact)
                                       VALUES (
                                       '" . DB_escape_string($_POST['CategoryID']) . "',
                                       '" . $_POST['StockType'] . "',
                                       '" . DB_escape_string($_POST['CategoryDescription']) . "',
                                       " . $_POST['StockAct'] . ",
                                       " . $_POST['AdjGLAct'] . ",
                                       " . $_POST['PurchPriceVarAct'] . ",
                                       " . $_POST['MaterialUseageVarAc'] . ",
                                       " . $_POST['WIPAct'] . ")";
		$msg = _('A new stock category record has been added');
	}
	 
	//run the SQL from either of the above possibilites
	$result = DB_query($sql,$db);
// 	$Catid= $_POST['CategoryID'];
	$timestamp= time();
	//Virture Mart

	$sql = "INSERT INTO jos_vm_category (
		vendor_id,
		category_name,
		category_description,
		category_publish,
		cdate,
		mdate,
		category_browsepage,
		products_per_row,	
		list_order,
		category_thumb_image,
		category_full_image,
                   ptcode) 
			VALUES( 
			'1',
		'" . DB_escape_string($_POST['CategoryName']) . "', 
                '" . DB_escape_string($_POST['CategoryDescriptionLong']) . "',
                 '". $_POST['CategoryOnline'] ."', 
                        '$timestamp',
			'$timestamp',
		        'brower_1',
			'" . $_POST['perrow'] . "',
		       '". $_POST['catorder'] ."',
			'$thumb',
			'$picportal',
			 '" . DB_escape_string($_POST['CategoryID']) . "')";
			$result = DB_query($sql,$db);

                


                  $sql =" select category_id from jos_vm_category where ptcode='$Catid'";
                   $result1= DB_query($sql,$db); 
                  $myrow1=DB_fetch_array($result1);
                  $ptcode=$myrow1['category_id'];

		 $sql2="select count(*) as checkno  from jos_vm_category_xref where  category_child_id='$Catid'";
		$result2=DB_query($sql2,$db);
		$myrow2=DB_fetch_array($result2);
		//SAFETY FUNCTION FOR CATEGORY REFENECE TABEL//
	 $checkno=$myrow2['checkno'];
		prnMsg( _('Refence cross check = ' .$checkno."));
		 
			if ($checkno == 0) {

                     $sql="INSERT INTO jos_vm_category_xref (category_parent_id,category_child_id)Values(
							 '0','.$ptcode.')";
     $result= DB_query($sql,$db);
}
	unset ($SelectedCategory);
	unset($_POST['CategoryID']);
	unset($_POST['StockType']);
	unset($_POST['CategoryDescription']);
  	unset($_POST['StockAct']);
	unset($_POST['AdjGLAct']);
	unset($_POST['PurchPriceVarAct']);
	unset($_POST['MaterialUseageVarAc']);
	unset($_POST['WIPAct']);
	prnMsg($msg,'success');

} elseif (isset($_GET['delete'])) {
//the link to delete a selected record was clicked instead of the submit button

// PREVENT DELETES IF DEPENDENT RECORDS IN 'StockMaster'

	$sql= "SELECT COUNT(*) FROM stockmaster WHERE stockmaster.categoryid='$SelectedCategory'";
	$result = DB_query($sql,$db);
	$myrow = DB_fetch_row($result);
	if ($myrow[0]>0) {
		prnMsg(_('Cannot delete this stock category because stock items have been created using this stock category') .
			'<br> ' . _('There are') . ' ' . $myrow[0] . ' ' . _('items referring to this stock category code'),'warn');
   
	} else {
		$sql = "SELECT COUNT(*) FROM salesglpostings WHERE stkcat='$SelectedCategory'";
		$result = DB_query($sql,$db);
		$myrow = DB_fetch_row($result);
		if ($myrow[0]>0) {
			prnMsg(_('Cannot delete this stock category because it is used by the sales') . ' - ' . _('GL posting interface') . '. ' . _('Delete any records in the Sales GL Interface set up using this stock category first'),'warn');
		} else {
			$sql = "SELECT COUNT(*) FROM cogsglpostings WHERE stkcat='$SelectedCategory'";
			$result = DB_query($sql,$db);
			$myrow = DB_fetch_row($result);
			if ($myrow[0]>0) {
				prnMsg(_('Cannot delete this stock category because it is used by the cost of sales') . ' - ' . _('GL posting interface') . '. ' . _('Delete any records in the Cost of Sales GL Interface set up using this stock category first'),'warn');
			} else {
				$sql="DELETE FROM stockcategory WHERE categoryid='$SelectedCategory'";
				$result = DB_query($sql,$db);
//______________________________________________________________________________________________		
			//Virturemart delete rotines

			$sql="SELECT category_id FROM jos_vm_category where ptcode='$SelectedCategory'";
			$result=DB_query($sql,$db);
			$myrow_ref=DB_fetch_row($result);
			$vmref=$myrow_ref['category_id'];
                        $sql="DELETE FROM jos_vm_category_xref where category_child_id='$vmref'";
			$result=DB_query($sql,$db);
			 $sql1="DELETE FROM jos_vm_category where ptcode='$SelectedCategory'";
                         $result=DB_query($sql1,$db);	

prnMsg(_('The stock category') . ' ' . $SelectedCategory . ' ' . _('has been deleted') . ' !','success');
				unset ($SelectedCategory);
			}
		}
	} //end if stock category used in debtor transactions
}

if (!isset($SelectedCategory)) {

/* It could still be the second time the page has been run and a record has been selected for modification - SelectedCategory will exist because it was sent with the new call. If its the first time the page has been displayed with no parameters
then none of the above are true and the list of stock categorys will be displayed with
links to delete or edit each. These will call the same page again and allow update/input
or deletion of the records*/

	$sql = "SELECT * FROM stockcategory";
	$result = DB_query($sql,$db);
        sql;
	echo "<CENTER><table border=1>\n";
	echo '<tr><td class="tableheader">' . _('Cat Code') . '</td>
            <td class="tableheader">' . _('Description') . '</td>
            <td class="tableheader">' . _('Type') . '</td>
            <td class="tableheader">' . _('Stock GL') . '</td>
            <td class="tableheader">' . _('Adjts GL') . '</td>
            <td class="tableheader">' . _('Price Var GL') . '</td>
            <td class="tableheader">' . _('Usage Var GL') . '</td>
            <td class="tableheader">' . _('WIP GL') . "</td></tr>\n";
	    
	$k=0; //row colour counter

	while ($myrow = DB_fetch_row($result)) {
		if ($k==1){
			echo '<tr bgcolor="#CCCCCC">';
			$k=0;
		} else {
			echo '<tr bgcolor="#EEEEEE">';
			$k=1;
		}
		printf("<td>%s</td>
            		<td>%s</td>
            		<td>%s</td>
            		<td ALIGN=RIGHT>%s</td>
            		<td ALIGN=RIGHT>%s</td>
            		<td ALIGN=RIGHT>%s</td>
            		<td ALIGN=RIGHT>%s</td>
            		<td ALIGN=RIGHT>%s</td>
            		<td><a href=\"%sSelectedCategory=%s\">" . _('Edit') . "</td>
            		<td><a href=\"%sSelectedCategory=%s&delete=yes\">" . _('Delete') . "</td>
            		</tr>",
            		$myrow[0],
            		$myrow[1],
            		$myrow[2],
            		$myrow[3],
            		$myrow[4],
            		$myrow[5],
            		$myrow[6],
            		$myrow[7],
            		$_SERVER['PHP_SELF'] . '?' . SID,
            		$myrow[0],
            		$_SERVER['PHP_SELF'] . '?' . SID,
            		$myrow[0]);
	}
	//END WHILE LIST LOOP
	echo '</table></CENTER>';
}

//end of ifs and buts!

?>

<p>
<?php
if ($SelectedCategory) {  ?>
	<Center><a href="<?php echo $_SERVER['PHP_SELF'] . '?' . SID;?>"><?php echo _('Show All Stock Categories'); ?></a></Center>
<?php } ?>

<P>

<?php

if (! isset($_GET['delete'])) {

	echo '<FORM ENCTYPE="MULTIPART/FORM-DATA" METHOD="post" action="' . $_SERVER['PHP_SELF'] . '?' . SID . '">';

	if (isset($SelectedCategory)) {
		//editing an existing stock category

		$sql = "SELECT categoryid,
                   	stocktype,
                   	categorydescription,
                   	stockact,
                   	adjglact,
                   	purchpricevaract,
                   	materialuseagevarac,
                   	wipact
                   FROM stockcategory
                   WHERE categoryid='" . DB_escape_string($SelectedCategory) . "'";
			
		$result = DB_query($sql, $db);
		$myrow = DB_fetch_array($result);
                $sql= "select category_description,category_name FROM jos_vm_category WHERE ptcode='" . DB_escape_string($SelectedCategory) . "'";
		$result1 = DB_query($sql, $db);
		$myrow1 = DB_fetch_array($result1);
		$_POST['CategoryName'] = $myrow1['category_name'];
                $_POST['CategoryDescriptionLong'] = $myrow1['category_description'];
		$_POST['CategoryID'] = $myrow['categoryid'];
		$_POST['StockType']  = $myrow['stocktype'];
		$_POST['CategoryDescription']  = $myrow['categorydescription'];
		$_POST['StockAct']  = $myrow['stockact'];
		$_POST['AdjGLAct']  = $myrow['adjglact'];
		$_POST['PurchPriceVarAct']  = $myrow['purchpricevaract'];
		$_POST['MaterialUseageVarAc']  = $myrow['materialuseagevarac'];
		$_POST['WIPAct']  = $myrow['wipact'];

		echo '<INPUT TYPE=HIDDEN NAME="SelectedCategory" VALUE="' . $SelectedCategory . '">';
		echo '<INPUT TYPE=HIDDEN NAME="CategoryID" VALUE="' . $_POST['CategoryID'] . '">';
		echo '<CENTER><TABLE><TR><TD>' . _('Category Code') . ':</TD><TD>' . $_POST['CategoryID'] . '</TD></TR>';

	} else { //end of if $SelectedCategory only do the else when a new record is being entered

		echo '<CENTER><TABLE><TR><TD>' . _('Category Code') . ':</TD>
                             <TD><input type="Text" name="CategoryID" SIZE=7 MAXLENGTH=6 value="' . $_POST['CategoryID'] . '"></TD></TR>';
	}

	//SQL to poulate account selection boxes
	$sql = "SELECT accountcode,
                 accountname
                 FROM chartmaster,
                      accountgroups
                 WHERE chartmaster.group_=accountgroups.groupname and
                       accountgroups.pandl=0
                 ORDER BY accountcode";

	$result = DB_query($sql,$db);
			echo '<TR><TD>' . _('Category Name') . ':</TD>
            <TD><input type="Text" name="CategoryName" SIZE=22 MAXLENGTH=20 value="' . $_POST['CategoryName'] . '"></TD></TR>';
echo '<TR><TD>' . _('Category Description') . '(' . _('Short') . '):</TD>
            <TD><input type="Text" name="CategoryDescription" SIZE=22 MAXLENGTH=20 value="' . $_POST['CategoryDescription'] . '"></TD></TR>';
           echo '<TR><TD>' . _('Category  Description') . ' (' . _('long') . '):</TD><TD><textarea  ID="longdesc" name="CategoryDescriptionLong"style="height: 270px; width: 500px;">' . $_POST['CategoryDescriptionLong'] . ' </textarea>';
                 

echo '<TR><TD>' . _('Online ') . ':</TD>
            <TD><SELECT name="CategoryOnline">';
		if ($_POST['CategoryOnline']=='Y') {
			echo '<OPTION SELECTED VALUE="Y">' . _('Yes');
		} else {  
			echo '<OPTION VALUE="Y">' . _('Yes');
		}
		if ($_POST['CategoryOnline']=='N') {
			echo '<OPTION SELECTED VALUE="N">' . _('No');
		} else {
			echo '<OPTION VALUE="N">' . _('No');
		}
	

	
	echo '</SELECT></TD></TR>';

		//Item Per Row for web Portal J Moncrieff
               
			
	echo '</SELECT></TD></TR>';

	
		echo '<TR><TD>' . _('Item Per Row (Portal) ') . ':</TD>
            <TD><SELECT name="perrow">';
		if ($_POST['perrow']=='1') {
			echo '<OPTION SELECTED VALUE="1">' . _('1');
		} else {
			echo '<OPTION VALUE="1">' . _('1');
		}
		if ($_POST['perrow']=='2') {
			echo '<OPTION SELECTED VALUE="M">' . _('2');
		} else {
			echo '<OPTION VALUE="2">' . _('2');
		}
		if ($_POST['perrow']=='3') {
			echo '<OPTION SELECTED VALUE="3">' . _('3');
		} else {
			echo '<OPTION VALUE="3">' . _('3');
		}
		if ($_POST['perrow']=='4') {
			echo '<OPTION SELECTED VALUE="4">' . _('4');
		} else {
			echo '<OPTION VALUE="4">' . _('4');
		}

	echo '</SELECT></TD></TR>';


	//end
		echo '<TR><TD>' . _('Stock Type') . ':</TD>
            <TD><SELECT name="StockType">';
		if ($_POST['StockType']=='F') {
			echo '<OPTION SELECTED VALUE="F">' . _('Finished Goods');
		} else {
			echo '<OPTION VALUE="F">' . _('Finished Goods');
		}
		if ($_POST['StockType']=='M') {
			echo '<OPTION SELECTED VALUE="M">' . _('Raw Materials');
		} else {
			echo '<OPTION VALUE="M">' . _('Raw Materials');
		}
		if ($_POST['StockType']=='D') {
			echo '<OPTION SELECTED VALUE="D">' . _('Dummy Item - (No Movements)');
		} else {
			echo '<OPTION VALUE="D">' . _('Dummy Item - (No Movements)');
		}
		if ($_POST['StockType']=='L') {
			echo '<OPTION SELECTED VALUE="L">' . _('Labour');
		} else {
			echo '<OPTION VALUE="L">' . _('Labour');
		}

	echo '</SELECT></TD></TR>';


	echo '<TR><TD>' . _('Stock GL Code') . ':</TD><TD><SELECT name="StockAct">';

	while ($myrow = DB_fetch_array($result)) {
		if ($myrow['accountcode']==$_POST['StockAct']) {
			echo '<OPTION SELECTED VALUE=';
		} else {
			echo '<OPTION VALUE=';
		}
		echo $myrow['accountcode'] . '>' . $myrow['accountname'] . ' ('.$myrow['accountcode'].')';
	} //end while loop
	DB_data_seek($result,0);
	echo '</SELECT></TD></TR>';

	echo '<TR><TD>' . _('WIP GL Code') . ':</TD><TD><SELECT name="WIPAct">';

	while ($myrow = DB_fetch_array($result)) {
		if ($myrow['accountcode']==$_POST['WIPAct']) {
			echo '<OPTION SELECTED VALUE=';
		} else {
			echo '<OPTION VALUE=';
		}
		echo $myrow['accountcode'] . '>' . $myrow['accountname'] . ' ('.$myrow['accountcode'].')';

	} //end while loop
	DB_data_seek($result,0);
	echo '</SELECT></TD></TR>';

	$sql = "SELECT accountcode,
                 accountname
                 FROM chartmaster,

                      accountgroups
                 WHERE chartmaster.group_=accountgroups.groupname and
                       accountgroups.pandl!=0
                 ORDER BY accountcode";

	$result1 = DB_query($sql,$db);

	echo '<TR><TD>' . _('Stock Adjustments GL Code') . ':</TD>
            <TD><SELECT name="AdjGLAct">';

	while ($myrow = DB_fetch_array($result1)) {
		if ($myrow['accountcode']==$_POST['AdjGLAct']) {
			echo '<OPTION SELECTED VALUE=';
		} else {
			echo '<OPTION VALUE=';
		}
		echo $myrow['accountcode'] . '>' . $myrow['accountname'] . ' ('.$myrow['accountcode'].')';

	} //end while loop
	DB_data_seek($result1,0);
	echo '</SELECT></TD></TR>';

	echo '<TR><TD>' . _('Price Variance GL Code') . ':</TD>
            <TD><SELECT name="PurchPriceVarAct">';

	while ($myrow = DB_fetch_array($result)) {
		if ($myrow['accountcode']==$_POST['PurchPriceVarAct']) {
			echo '<OPTION SELECTED VALUE=';
		} else {
			echo '<OPTION VALUE=';
		}
		echo $myrow['accountcode'] . '>' . $myrow['accountname'] . ' ('.$myrow['accountcode'].')';

	} //end while loop
	
	echo '</SELECT></TD></TR>';

	 echo '<TR><TD>' . _('Category Order') . ':</TD>
                             <TD><input type="Text" name="catorder" SIZE=7 MAXLENGTH=6 value="' . $_POST['catorder'] . '"></TD></TR>';
	
	echo '<TR><TD>' . _('Usage Variance GL Code') . ':</TD><TD><SELECT name="MaterialUseageVarAc">';

	while ($myrow = DB_fetch_array($result1)) {
		if ($myrow['accountcode']==$_POST['MaterialUseageVarAc']) {
			echo '<OPTION SELECTED VALUE=';
		} else {
			echo '<OPTION VALUE=';
		}
		echo $myrow['accountcode'] . '>' . $myrow['accountname'] . ' ('.$myrow['accountcode'].')';

 
       
	} //end while loop
         
	DB_free_result($result1);

       echo '</SELECT></TD></TR>';
     	
  	echo '<CENTER><input type="Submit" name="submit" value="' . _('Enter Information') . '">';
         // Add image upload for New Item  - by Ori
echo '<TR><TD>'. _('Image File (.jpg)') . ':</TD><TD><input type="file" id="ItemPicture" name="ItemPicture"></TD></TR>';
// EOR Add Image upload for New Item  - by Ori
//start

if (function_exists('imagecreatefrompng')){
        $StockImgLink = '<img src="GetStockImage.php?SID&automake=1&textcolor=FFFFFF&bgcolor=CCCCCC'.
                '&StockID='.urlencode($Catid).
                '&text='.
                '&width=64'.
                '&height=64'.
                '" >';
} else {
        if( file_exists($catpictsdir . '/' .$Catid.'.jpg') ) {
                $StockImgLink = '<img src="' . $catpictdir . '/' .$Catid.'.jpg" >';
        } else {
                $StockImgLink = _('No Image');
        }
}


//end


	echo '</FORM>';

}
 //end if record deleted no point displaying form to add record
include('includes/footer.inc');
?>
