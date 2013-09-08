<?php

/* $Revision: 1.9 $ */

$PageSecurity = 11;
include('includes/DefineProductionRunCostingClass.php');
include('includes/session.inc');
$title = _('Production Run Costing');
include('includes/header.inc');

include('includes/SQL_CommonFunctions.inc');

if ($_GET['NewProductionRunCosting']=='Yes'){
	
	
	unset($_SESSION['ProductionRunCosting']->LineItems);
	unset($_SESSION['ProductionRunCosting']);
}

if (isset($_GET['SelectedProductionRunCosting'])){

	 if (isset($_SESSION['ProductionRunCosting'])){
              unset ($_SESSION['ProductionRunCosting']->LineItems);
              unset ($_SESSION['ProductionRunCosting']);
       }

       $_SESSION['ProductionRunCosting'] = new ProductionRunCosting;

       $_SESSION['ProductionRunCosting']->GLLink = $_SESSION['CompanyRecord']['gllink_stock'];

/*read in all the guff from the selected shipment into the ProductionRunCosting Class variable - the class code is included in the main script before this script is included  */

       $ShipmentHeaderSQL = "SELECT productionruncosting.supplierid,
       				workcentres.description,
				productionruncosting.eta,
				productionruncosting.other,
				productionruncosting.otherref,
				productionruncosting.closed
				FROM productionruncosting INNER JOIN workcentres
					ON productionruncosting.supplierid = workcentres.code
				WHERE productionruncosting.prref = " . $_GET['SelectedProductionRunCosting'];

       $ErrMsg = _('Production Run Costing ').' '. $_GET['SelectedProductionRunCosting'] . ' ' . _('cannot be retrieved because a database error occurred');
       $GetShiptHdrResult = DB_query($ShipmentHeaderSQL,$db, $ErrMsg);

       if (DB_num_rows($GetShiptHdrResult)==0) {
		prnMsg ( _('Unable to locate Production Run') . ' '. $_GET['SelectedProductionRunCosting'] . ' ' . _('in the database'), 'error');
	        include('includes/footer.inc');
        	exit();
	}

       if (DB_num_rows($GetShiptHdrResult)==1) {

              $myrow = DB_fetch_array($GetShiptHdrResult);

	      if ($myrow['closed']==1){
			echo '<BR>';
			prnMsg( _('Production Run No.') .' '. $_GET['SelectedProductionRunCosting'] .': '.
				_('The selected Production Run is already closed and no further modifications to the Production Run are possible'), 'error');
			include('includes/footer.inc');
			exit;
	      }
              $_SESSION['ProductionRunCosting']->PRRef = $_GET['SelectedProductionRunCosting'];
              $_SESSION['ProductionRunCosting']->SupplierID = $myrow['supplierid'];
              $_SESSION['ProductionRunCosting']->WorkCentre = $myrow['description'];
              $_SESSION['ProductionRunCosting']->ETA = $myrow['eta'];
              $_SESSION['ProductionRunCosting']->Other = $myrow['other'];
              $_SESSION['ProductionRunCosting']->OtherRef = $myrow['otherref'];



/*now populate the shipment details records 

              $LineItemsSQL = "SELECT productionrundetails.prdetailitem,
	      				productionruns.prno,
					productionrundetails.itemcode,
					productionrundetails.itemdescription,
					productionrundetails.processdate,
					productionrundetails.glcode,
					productionrundetails.qtyprocessed,
					productionrundetails.unitcost,
					stockmaster.units,
					productionrundetails.quantityord,
					productionrundetails.quantityrecd,
					productionrundetails.stdcostunit,
					stockmaster.materialcost+stockmaster.overheadcost as stdcost,
					productionruns.workcentre
				FROM productionrundetails INNER JOIN stockmaster
					ON productionrundetails.itemcode=stockmaster.stockid
				INNER JOIN productionruns
					ON productionrundetails.prno=productionruns.prno
				WHERE productionrundetails.prref=" . $_GET['SelectedProductionRunCosting'];
				
				 */
				 
				 
				 
				             $LineItemsSQL = "SELECT productionruns.prno,
					productionruns.stockno,
					stockmaster.description,
					productionruns.processdate,
					productionruns.prodrunqtyrecd,
					productionruns.bomunitcost,
					stockmaster.units,
					productionruns.prodrunqty,
					stockmaster.materialcost+stockmaster.overheadcost as stdcost,
					productionruns.workcentre
				FROM productionruns INNER JOIN stockmaster
					ON productionruns.stockno=stockmaster.stockid
				WHERE productionruns.prref=" . $_GET['SelectedProductionRunCosting'];
				
	      $ErrMsg = _('The lines on the Production Run cannot be retrieved because'). ' - ' . DB_error_msg($db);
              $LineItemsResult = db_query($LineItemsSQL,$db, $ErrMsg);

        if (DB_num_rows($GetShiptHdrResult)==0) {
                prnMsg ( _('Unable to locate lines for Production Run') . ' '. $_GET['SelectedProductionRunCosting'] . ' ' . _('in the database'), 'error');
                include('includes/footer.inc');
                exit();
        }

        if (db_num_rows($LineItemsResult) > 0) {

			while ($myrow=db_fetch_array($LineItemsResult)) {

				if ($myrow['bomunitcost']==0){
					$StandardCost = $myrow['stdcost'];
				} else {
					$StandardCost =$myrow['bomunitcost'];
				}

				$_SESSION['ProductionRunCosting']->LineItems[$myrow['prno']] = new LineDetails($myrow['prno'],
													 $myrow['prno'],
													 $myrow['itemcode'],
													 $myrow['itemdescription'],
													 $myrow['qtyprocessed'],
													 $myrow['unitcost'],
													 $myrow['units'],
													 $myrow['processdate'],
													 $myrow['quantityord'],
													 $myrow['quantityrecd'],
													 $myrow['workcentre'],
													 $StandardCost);
		   } /* line Shipment from shipment details */

		   DB_data_Seek($LineItemsResult,0);
		   $myrow=DB_fetch_array($LineItemsResult);
//		   $_SESSION['ProductionRunCosting']->WorkCentre = $myrow['workcentre'];

              } //end of checks on returned data set
       }
} // end of reading in the existing shipment


if (!isset($_SESSION['ProductionRunCosting'])){

	$_SESSION['ProductionRunCosting'] = new ProductionRunCosting;
	
//	$sql = "SELECT description, code FROM workcentres WHERE supplierid='" . $_SESSION['SupplierID'] . "'";
//	$ErrMsg = _('The supplier details for the Production Run could not be retrieved because');
//	$result = DB_query($sql,$db,$ErrMsg);
//	$myrow = DB_fetch_row($result);

//	$_SESSION['ProductionRunCosting']->SupplierID = $_SESSION['SupplierID'];
///	$_SESSION['ProductionRunCosting']->SupplierName = $myrow[0];
//	$_SESSION['ProductionRunCosting']->CurrCode = $myrow[1];
	$_SESSION['ProductionRunCosting']->PRRef = GetNextTransNo (31, $db);
}


if ( isset($_POST['Update'])) { //user hit the update button

	$_SESSION['ProductionRunCosting']->Other = $_POST['Other'];
	$_SESSION['ProductionRunCosting']->OtherRef = $_POST['OtherRef'];
$_SESSION['ProductionRunCosting']->SupplierID = $_POST['WorkCentre'];

	$InputError =0;
	
	if (!Is_Date($_POST['ETA'])){
		$InputError=1;
		prnMsg( _('The date of expected arrival of the Production Run must be entered in the format') . ' ' .$_SESSION['DefaultDateFormat'], 'error');
	} 
	
	//elseif (Date1GreaterThanDate2($_POST['ETA'],Date($_SESSION['DefaultDateFormat']))==0){
	//	$InputError=1;
	//	prnMsg( _('An expected arrival of the Production Run must be a date after today'), 'error');
	//} 
	
	else {
		$_SESSION['ProductionRunCosting']->ETA = FormatDateForSQL($_POST['ETA']);
	}

	if (strlen($_POST['Other'])<2){
		prnMsg( _('A comment on or description of the production run costing of more than 2 characters is expected'), 'error');
	}
	

/*The user hit the update the shipment button and there are some lines on the shipment*/
	if ($InputError ==0 AND count($_SESSION['ProductionRunCosting']->LineItems)>0){
		$sql = "SELECT prref FROM productionruncosting WHERE prref =" . $_SESSION['ProductionRunCosting']->PRRef;
		$result = DB_query($sql,$db);
		if (DB_num_rows($result)==1){

			$sql = "UPDATE productionruncosting SET other='" . DB_escape_string($_SESSION['ProductionRunCosting']->Other) . "',
							otherref='".  $_SESSION['ProductionRunCosting']->OtherRef . "',
							eta='" .  $_SESSION['ProductionRunCosting']->ETA . "',
					supplierid='" .  $_POST['WorkCentre'] . "'
					WHERE prref =" .  $_SESSION['ProductionRunCosting']->PRRef;

		} else {
			
			$sql = "INSERT INTO productionruncosting (prref,
							other,
							otherref,
							eta,
							supplierid)
					VALUES (" . $_SESSION['ProductionRunCosting']->PRRef . ",
						'" . DB_escape_string($_SESSION['ProductionRunCosting']->Other) . "',
						'".  $_SESSION['ProductionRunCosting']->OtherRef . "',
						'" . $_SESSION['ProductionRunCosting']->ETA . "',
						'" . $_POST['WorkCentre'] . "')"  ;

		}
		/*now update or insert as necessary */
		$result = DB_query($sql,$db);

		/*now check that the delivery date of all PODetails are the same as the ETA as the shipment */
		foreach ($_SESSION['ProductionRunCosting']->LineItems as $LnItm) {

			if (DateDiff(ConvertSQLDate($LnItm->DelDate),ConvertSQLDate($_SESSION['ProductionRunCosting']->ETA),'d')!=0){

				$sql = "UPDATE productionrundetails 
						SET processdate ='" . $_SESSION['ProductionRunCosting']->ETA . "' 
					WHERE prno=" . $LnItm->PRDetailItem;

				$result = DB_query($sql,$db);

				$sql1 = "UPDATE productionruns 
						SET reqdate ='" . $_SESSION['ProductionRunCosting']->ETA . "' 
					WHERE prno=" . $LnItm->PRDetailItem;

				$result1 = DB_query($sql1,$db);

				$_SESSION['ProductionRunCosting']->LineItems[$LnItm->PRDetailItem]->DelDate = $_SESSION['ProductionRunCosting']->ETA;
				
				$yyy = $sql;

			}
		}
	//	echo '<BR>';
	//	echo $yyy;
	//	echo '<BR>';
		prnMsg( _('Updated the Production Run record and delivery dates of order lines as necessary'), 'success');
	} //error traps all passed ok
	
} //user hit Update


if (isset($_GET['Delete']) AND $_SESSION['ProductionRunCosting']->Closed==0){ //shipment is open and user hit delete on a line
	$_SESSION['ProductionRunCosting']->remove_from_shipment($_GET['Delete'],$db);
}

if (isset($_GET['Add']) AND $_SESSION['ProductionRunCosting']->Closed==0){

	$sql = "SELECT productionruns.prno,
			productionruns.stockno,
					stockmaster.description,
					productionruns.processdate,
					productionruns.prodrunqtyrecd,
					productionruns.bomunitcost,
					stockmaster.units,
					productionruns.prodrunqty,
					stockmaster.materialcost+stockmaster.overheadcost as stdcost,
					productionruns.workcentre,
				
			stockmaster.units
			
		FROM productionruns, productionrundetails INNER JOIN stockmaster
			ON productionruns.stockno=stockmaster.stockid
			  
		WHERE productionrundetails.prno=productionruns.prno AND 
		productionruns.prno=" . $_GET['Add'] . "
		GROUP BY productionruns.prno";
//  prnMsg(_('SQL ') . ' - ' . _(' ' . ' 1 ' .  $sql),'info');
	$result = DB_query($sql,$db);
	$myrow = DB_fetch_array($result);

/*The variable StdCostUnit gets set when the item is first received and stored for all future transactions with this purchase order line - subsequent changes to the standard cost will not therefore stuff up variances resulting from the line which may have several entries in GL for each delivery drop if it has already been set from a delivery then use it otherwise use the current system standard */

	if ($myrow['bomunitcost']==0){
					$StandardCost = $myrow['stdcost'];
				} else {
					$StandardCost =$myrow['bomunitcost'];
				}

	$_SESSION['ProductionRunCosting']->add_to_shipment($_GET['Add'],
								$myrow['prno'],
								$myrow['stockno'],
								$myrow['description'],
								$myrow['prodrunqtyrecd'],
								$myrow['materialcost'],
								$myrow['units'],
								$myrow['processdate'],
								$myrow['prodrunqty'],
								$myrow['prodrunqtyrecd'],
								$myrow['workcentre'],
								$StandardCost,
								$db);
}
//echo $LineItemsSQL;
//echo '<BR>';
//echo $_SESSION['ProductionRunCosting']->WorkCentre;
//echo '<BR>';
//echo $myrow['workcentre'];

echo '<FORM ACTION="' . $_SERVER['PHP_SELF'] . '?' . SID . '" METHOD="POST">';


$sql_work = "SELECT code,location FROM workcentres WHERE code='" . $_SESSION['ProductionRunCosting']->SupplierID . "'";
	$resultStkLocs2 = DB_query($sql_work,$db);
	$myrow2=DB_fetch_array($resultStkLocs2);
	
 

echo '<CENTER><TABLE><TR><TD><B>'. _('Production Run Costing').': </TD><TD><B>' . $_SESSION['ProductionRunCosting']->PRRef . '</B></TD>
		<TD><B>'. _('Manufactured at '). ' ' . $myrow2['location'] . '</B></TD></TR>';

echo '<TR><TD>'. _('Comments'). ': </TD>
	<TD COLSPAN=3><INPUT TYPE=Text NAME="Other" MAXLENGTH=50 SIZE=50 VALUE="' . $_SESSION['ProductionRunCosting']->Other . '"></TD>
	<TD>'._('Ref').': </TD>
	<TD><INPUT TYPE=Text NAME="OtherRef" MAXLENGTH=20 SIZE=20 VALUE="' . $_SESSION['ProductionRunCosting']->OtherRef . '"></TD>
</TR>';

if (isset($_SESSION['ProductionRunCosting']->ETA)){
	$ETA = ConvertSQLDate($_SESSION['ProductionRunCosting']->ETA);
} else {
	$ETA ='';
}

echo '<TR><TD>'. _('Expected Production Date '). ': ';
//  echo $LineItemsSQL;
//echo '<BR>';
//echo $_SESSION['ProductionRunCosting']->WorkCentre;
//echo '<BR>';
//echo $myrow['workcentre'];
//echo '<BR>';
/*
echo array_values($_SESSION['ProductionRunCosting']->LineItems);
echo ' --- ';
echo current($_SESSION['ProductionRunCosting']->LineItems);
echo ' --- ';
echo count($_SESSION['ProductionRunCosting']->LineItems);*/
echo '</TD>
	<TD><INPUT TYPE=Text NAME="ETA" MAXLENGTH=10 SIZE=10 VALUE="' . $ETA . '"></TD>
	<TD>'. _('At ').' ';



	

	echo _('Work Centre').': <SELECT name="WorkCentre">';

	$sql = "SELECT code, location FROM workcentres";

	$resultStkLocs = DB_query($sql,$db);

	while ($myrow=DB_fetch_array($resultStkLocs)){

		if (isset($_POST['WorkCentre'])){
			if ($myrow['code'] == $_POST['WorkCentre'] || $myrow['code'] == $myrow2['code'] ){
				echo '<OPTION SELECTED Value="' . $myrow['code'] . '">' . $myrow['location'];
			} else {
				echo '<OPTION Value="' . $myrow['code'] . '">' . $myrow['location'];
			}
		} elseif ($myrow['code']==$_SESSION['UserWorkCentre'] || $myrow['code'] == $myrow2['code'] ){
			echo '<OPTION SELECTED Value="' . $myrow['code'] . '">' . $myrow['location'];
		} else {
			echo '<OPTION Value="' . $myrow['code'] . '">' . $myrow['location'];
		}
	}

	

	echo '</SELECT>';

/*
	$sql = "SELECT location FROM workcentres WHERE code='" . $_SESSION['ProductionRunCosting']->SupplierID . "'";
	$resultStkLocs = DB_query($sql,$db);
	$myrow=DB_fetch_array($resultStkLocs);
 	echo $myrow['location'];
*/

echo '</TD></TR></TABLE>';

if (count($_SESSION['ProductionRunCosting']->LineItems)>0){
	/* Always display all shipment lines */
	
	echo '<B><FONT COLOR=BLUE>'. _('Order Lines On This Production Run'). '</FONT></B>';
	echo '<TABLE CELLPADDING=2 COLSPAN=7 BORDER=0>';
		
	$TableHeader = '<TR>
			<TD class="tableheader">'. _('Order'). '</TD>
			<TD class="tableheader">'. _('Item'). '</TD>
			<TD class="tableheader">'. _('Quantity'). '<BR>'. _('Ordered'). '</TD>
			<TD class="tableheader">'. _('Units'). '</TD>
			<TD class="tableheader">'. _('Quantity').'<BR>'. _('Received'). '</TD>
			<TD class="tableheader">'. _('Quantity').'<BR>'. _('Invoiced'). '</TD>
			<TD class="tableheader">'. $_SESSION['ProductionRunCosting']->CurrCode .' '. _('Price') . '</TD>
			<TD class="tableheader">'. _('Current'). '<BR>'. _('Std Cost'). '</TD></TR>';
		
	echo  $TableHeader;
		
	/*show the line items on the shipment with the quantity being received for modification */
		
	$k=0; //row colour counter
	$RowCounter =0;
		
	foreach ($_SESSION['ProductionRunCosting']->LineItems as $LnItm) {
	
	$sqlnew = "SELECT productionruns.prno,
			productionruns.stockno,
					stockmaster.description,
					productionruns.processdate,
					productionruns.prodrunqtyrecd,
					productionruns.bomunitcost,
					stockmaster.units,
					productionruns.prodrunqty,
					stockmaster.materialcost+stockmaster.overheadcost as stdcost,
					productionruns.workcentre
				
		FROM productionruns, productionrundetails INNER JOIN stockmaster
			ON productionruns.stockno=stockmaster.stockid
			  
		WHERE productionrundetails.prno=productionruns.prno AND 
		productionruns.prno=" . $LnItm->PRNo . "
		GROUP BY productionruns.prno";
//  prnMsg(_('SQL ') . ' - ' . _(' ' . ' 1 ' .  $sqlnew),'info');
	$resultnew = DB_query($sqlnew,$db);
	$myrownew = DB_fetch_array($resultnew);


	
	
	if ($myrownew['bomunitcost']==0){
					$StandardCost = $myrownew['stdcost'];
				} else {
					$StandardCost =$myrownew['bomunitcost'];
				}

	
	
		if ($RowCounter==15){
			echo $TableHeader;
			$RowCounter =0;
		}
		$RowCounter++;
	
		if ($k==1){
			echo '<tr bgcolor="#CCCCCC">';
			$k=0;
		} else {
			echo '<tr bgcolor="#EEEEEE">';
			$k=1;
		}
	
	
		echo '<TD>'.$LnItm->PRNo.'</TD>
			<TD>'. $myrownew['stockno'] .' - '. $myrownew['description']. '</TD><TD ALIGN=RIGHT>' . number_format($myrownew['prodrunqty'],2) . '</TD>
			<TD>'. $LnItm->UOM .'</TD>
			<TD ALIGN=RIGHT>' . number_format($myrownew['prodrunqtyrecd'],2) . '</TD>
			<TD ALIGN=RIGHT>' . number_format($LnItm->QtyInvoiced,2) . '</TD>
			<TD ALIGN=RIGHT>' . number_format($myrownew['stdcost'],2) . '</TD>
			<TD ALIGN=RIGHT>' . number_format($myrownew['bomunitcost'],2) . '</TD>
			<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . 'Delete=' . $LnItm->PRNo . '">'. _('Delete'). '</A></TD>
			</TR>';
	}//for each line on the shipment
echo '</TABLE>';
}//there are lines on the shipment

echo '<BR><INPUT TYPE=SUBMIT NAME="Update" Value="'. _('Update Production Run Details') . '"><P>';

echo '<HR>';
 if (!isset($_POST['WorkCentre']) || $_POST['WorkCentre']=="")
 {$workcentre=$_REQUEST['WorkCentre'];}
 else {$workcentre=$_POST['WorkCentre'];}
 
 if ($workcentre=="")
 {$workcentre=$_REQUEST['WorkCentre'];}

 if ($workcentre=="")
 {$workcentre=$_SESSION['ProductionRunCosting']->SupplierID;}

 if ($workcentre=="")
 {$workcentre="DUR";}

$sql = "SELECT productionruns.prno,
		productionruns.stockno,
		stockmaster.description,
		productionruns.prodrunqty,
		productionruns.prodrunqtyrecd,
		productionruns.initdate,
		productionruns.reqdate,
		stockmaster.units
	FROM productionruns
		INNER JOIN stockmaster
			ON productionruns.stockno=stockmaster.stockid
	WHERE prodrunqtyrecd=0
	AND productionruns.prref=0
	AND productionruns.workcentre='" . $workcentre . "'";
$result = DB_query($sql,$db);

//  prnMsg(_('SQL ') . ' - ' . _(' ' . ' 1 ' .  $sql),'info');
	

/*
$sql = "SELECT productionrundetails.prdetailitem,
		productionruns.prno,
		productionrundetails.itemcode,
		productionrundetails.itemdescription,
		productionrundetails.unitcost,
		productionrundetails.quantityord,
		productionrundetails.quantityrecd,
		productionrundetails.processdate,
		stockmaster.units
	FROM productionrundetails INNER JOIN productionruns
		ON productionrundetails.prno=productionruns.prno
		INNER JOIN stockmaster
			ON productionrundetails.itemcode=stockmaster.stockid
	WHERE qtyprocessed=0
	AND productionruns.supplierno ='" . $_SESSION['ProductionRunCosting']->SupplierID . "'
	AND productionrundetails.prref=0
	AND productionruns.workcentre='" . $_POST['WorkCentre'] . "'";
*/

if (DB_num_rows($result)>0){

	echo '<B><FONT COLOR=BLUE>'. _('Possible Production Run Items To Add To This Costing').'</FONT></B>';
	echo '<TABLE CELLPADDING=2 COLSPAN=7 BORDER=0>';

	$TableHeader = '<TR>
			<TD class="tableheader">'. _('Order').'</TD>
			<TD class="tableheader">'. _('Item').'</TD>
			<TD class="tableheader">'. _('Quantity').'<BR>'. _('Ordered').'</TD>
			<TD class="tableheader">'. _('Units').'</TD>
			<TD class="tableheader">'. _('Quantity').'<BR>'. _('Received').'</TD>
			<TD class="tableheader">'. _('Delivery').'<BR>'. _('Date').'</TD>
			</TR>';

	echo  $TableHeader;

	/*show the PO items that could be added to the shipment */

	$k=0; //row colour counter
	$RowCounter =0;

	while ($myrow=DB_fetch_array($result)){

	if ($myrow['bomunitcost']==0){
					$StandardCost = $myrow['stdcost'];
				} else {
					$StandardCost =$myrow['bomunitcost'];
				}

		if ($RowCounter==15){
			echo $TableHeader;
			$RowCounter =0;
		}
		$RowCounter++;

		if ($k==1){
			echo '<tr bgcolor="#CCCCCC">';
			$k=0;
		} else {
			echo '<tr bgcolor="#EEEEEE">';
			$k=1;
		}

/*		echo '<TD>' . $myrow['prno'] . '</TD>
			<TD>' . $myrow['itemcode'] . ' - ' . $myrow['itemdescription'] . '</TD>
			<TD ALIGN=RIGHT>' . number_format($myrow['quantityord'],2) . '</TD>
			<TD>' . $myrow['units'] . '</TD>
			<TD ALIGN=RIGHT>' . number_format($myrow['quantityrecd'],2) . '</TD>
			<TD ALIGN=RIGHT>' . ConvertSQLDate($myrow['processdate']) . '</TD>
			<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&Add=' . $myrow['prdetailitem'] . '">'. _('Add').'</A></TD>
			</TR>';
*/
		echo '<TD>' . $myrow['prno'] . '</TD>
			<TD>' . $myrow['stockno'] . ' - ' . $myrow['description'] . '</TD>
			<TD ALIGN=RIGHT>' . number_format($myrow['prodrunqty'],2) . '</TD>
			<TD>' . $myrow['units'] . '</TD>
			<TD ALIGN=RIGHT>' . number_format($myrow['prodrunqtyrecd'],2) . '</TD>
			<TD ALIGN=RIGHT>' . ConvertSQLDate($myrow['reqdate']) . '</TD>
			<TD><A HREF="' . $_SERVER['PHP_SELF'] . '?' . SID . '&Add=' . $myrow['prno'] . '">'. _('Add').'</A></TD>
			</TR>';

	}
	echo '</TABLE>';
}

echo '</FORM>';

include('includes/footer.inc');
?>
