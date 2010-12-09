<?php
/* $Revision: 1.23 $ */

$PageSecurity = 11;

/* Session started in header.inc for password checking and authorisation level check */
include('includes/DefinePRClass.php');
include('includes/DefineSerialItems.php');
include('includes/session.inc');
include('includes/SQL_CommonFunctions.inc');

$title = _('Process Item Assembly - BOM Items');
include('includes/header.inc');

echo '<A HREF="'. $rootpath . '/PR_SelectProductionRun.php?' . SID . '">' . _('Back to Item Assemblies'). '</A><BR>';
echo '<P><a href="GoodsProcessed2.php?PRNumber=' . $_GET['PRNumber'] . '">Click here to process Finished Goods</a> (confirm quantities produced)</P>'	;

if ($_GET['PRNumber']<=0 AND !isset($_SESSION['PR'])) {
	/* This page can only be called with a Item Assembly number for invoicing*/
	echo '<CENTER><A HREF="' . $rootpath . '/PR_SelectProductionRun.php?' . SID . '">'.
		_('Select a Item Assembly to receive').'</A></CENTER>';
	echo '<BR>'. _('This page can only be opened if an Item Assembly has been selected') . '. ' . _('Please select an Item Assembly first');
	include ('includes/footer.inc');
	exit;
} elseif (isset($_GET['PRNumber']) AND !isset($_POST['Update'])) {
  /*Update only occurs if the user hits the button to refresh the data and recalc the value of goods recd*/

	  $_GET['ModifyPRNumber'] = $_GET['PRNumber'];
	  include('includes/PR_ReadInPR.inc');
} elseif (isset($_POST['Update']) OR isset($_POST['ProcessGoodsProcessed'])) {

/* if update quantities button is hit page has been called and ${$Line->LineNo} would have be
 set from the post to the quantity to be received in this receival*/

	foreach ($_SESSION['PR']->LineItems as $Line) {
		$RecvQty = $_POST['RecvQty_' . $Line->LineNo];
		if (!is_numeric($RecvQty)){
			$RecvQty = 0;
		}
		$_SESSION['PR']->LineItems[$Line->LineNo]->ReceiveQty = $RecvQty;
	}
}

/* Always display quantities received and recalc balance for all items on the order */


echo '<CENTER><FONT SIZE=4><B><U>'. _('Process Item Assembly - BOM ITEMS'). ' '. $_SESSION['PR']->PRNo .' '. _('from'). ' ' . $_SESSION['PR']->SupplierName . ' for ' . $_SESSION['PR']->StockNo .', qty '  . $_SESSION['PR']->OrdQty .'</U></B></FONT></CENTER><BR>';
echo '<FORM ACTION="' . $_SERVER['PHP_SELF'] . '?' . SID . '" METHOD=POST>';

echo '<CENTER><TABLE CELLPADDING=2 COLSPAN=7 BORDER=0>
<TR><TD class="tableheader">' . _('Item Code') . '</TD>
	<TD class="tableheader">' . _('Description') . '</TD>
	<TD class="tableheader">' . _('Quantity') . '<BR>' . _('Ordered') . '</TD>
	<TD class="tableheader">' . _('Units') . '</TD>
	<TD class="tableheader">' . _('Already Processed') . '</TD>
	<TD class="tableheader">' . _('This Delivery') . '<BR>' . _('Quantity') . '</TD>
	<TD class="tableheader">' . _('Proj. Cost') . '</TD>
	<TD class="tableheader">' . _('Actual Cost') . '</TD>
	<TD class="tableheader">' . _('Total Value') . '<BR>' . _('Processed') . '</TD>';


echo '<TD>&nbsp;</TD>
	</TR>';
/*show the line items on the order with the quantity being received for modification */

$_SESSION['PR']->total = 0;
$k=0; //row colour counter
$BOMC=0;
	$GrandTotal=0;
if (count($_SESSION['PR']->LineItems)>0){
	foreach ($_SESSION['PR']->LineItems as $LnItm) {
		
		if ($k==1){
			echo '<tr bgcolor="#CCCCCC">';
			$k=0;
		} else {
			echo '<tr bgcolor="#EEEEEE">';
			$k=1;
		}

	/*	  if ($LnItm->ReceiveQty==0){   /*If no quantites yet input default the balance to be received
		$LnItm->ReceiveQty = $LnItm->QuantityOrd - $LnItm->QtyReceived;
		}
	*/

	/*Perhaps better to default quantities to 0 BUT.....if you wish to have the receive quantites
	default to the balance on order then just remove the comments around the 3 lines above */

	//Setup & Format values for LineItem display
$sqlperunit="select qtyperunit from productionrundetails where prno=" . $_SESSION['PR']->PRNo . " and itemcode='" . $LnItm->StockID ."'";


				 $sqlperunitResult = DB_query($sqlperunit,$db);
	      if (DB_num_rows($sqlperunitResult)==1){
		  $sqlperunitRow = DB_fetch_row($sqlperunitResult);
		  $QtyPer = $sqlperunitRow[0];
		 }


		$_SESSION['PR']->total = $_SESSION['PR']->total + $LineTotal;
		$DisplayQtyOrd = number_format($LnItm->Quantity,$LnItm->DecimalPlaces);
		$DisplayQtyRec = number_format($LnItm->QtyReceived,$LnItm->DecimalPlaces);
		$DisplayStdCost= number_format($LnItm->BomUnitCost,2);

$BOMC += $DisplayStdCost * $QtyPer;
	//	prnMsg(_('BOMC') . $BOMC . ' SdCost ' . $DisplayStdCost . ' qty per' . $QtyPer,'warn');
		
$sqlstdcost = "SELECT materialcost + overheadcost as stdcost 
						FROM stockmaster 
						WHERE stockid='" . $LnItm->StockID . "'";
				$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The standard cost of the item being processed cannot be retrieved because');
				$DbgMsg = _('The following SQL to retrieve the standard cost was used');
				
				
				 $sqlstdcostResult = DB_query($sqlstdcost,$db);
	      if (DB_num_rows($sqlstdcostResult)==1){
		  $sqlstdcostRow = DB_fetch_row($sqlstdcostResult);
		  $DisplayPrice = $sqlstdcostRow[0];
		  
		  
		  $LineTotal = ($LnItm->ReceiveQty * $DisplayPrice );
		$DisplayLineTotal = number_format($LineTotal,2);
		$GrandTotal += $LineTotal;
		
		 }
				//$sqlstdcostResult = DB_query($sqlstdcost,$db, $ErrMsg, $DbgMsg);
				
				//$DisplayPrice = $sqlstdcostResult['stdcost'];
				
	//			prnMsg(_('sqlstdcost'). ' ' . '(' . $sqlstdcost .')' . $sqlstdcostRow[0],'warn');
	
		//Now Display LineItem
		echo '<TD><FONT size=2>' . $LnItm->StockID . '</FONT></TD>';
		echo '<TD><FONT size=2>' . $LnItm->ItemDescription . '</TD>';
		echo '<TD ALIGN=RIGHT><FONT size=2>' . $DisplayQtyOrd . '</TD>';
		echo '<TD><FONT size=2>' . $LnItm->Units . '</TD>';
		echo '<TD ALIGN=RIGHT><FONT size=2>' . -1*$DisplayQtyRec . '</TD>';
		echo '<TD ALIGN=RIGHT><FONT size=2>';

		if ($LnItm->Controlled == 1) {

			echo '<input type=hidden name="RecvQty_' . $LnItm->LineNo . '" value="' . $LnItm->ReceiveQty . '"><a href="GoodsProcessedControlled.php?' . SID . '&LineNo=' . $LnItm->LineNo . '">' . number_format($LnItm->ReceiveQty,$LnItm->DecimalPlaces) . '</a></TD>';

		} else {

			echo '<input type=text name="RecvQty_' . $LnItm->LineNo . '" maxlength=10 SIZE=10 value="' . $LnItm->ReceiveQty . '"></TD>';

		}

		echo '<TD ALIGN=RIGHT><FONT size=2>' . $DisplayStdCost . '</TD>';
		echo '<TD ALIGN=RIGHT><FONT size=2>' . $DisplayPrice . '</TD>';
		echo '<TD ALIGN=RIGHT><FONT size=2>' . $DisplayLineTotal . '</FONT></TD>';

				$DisplayTotal1 += $DisplayLineTotal;
		if ($LnItm->Controlled == 1) {
			if ($LnItm->Serialised==1){
				echo '<TD><a href="GoodsProcessedControlled.php?' . SID . '&LineNo=' . $LnItm->LineNo . '">'.
					_('Enter Serial Nos'). '</a></TD>';
			} else {
				echo '<TD><a href="GoodsProcessedControlled.php?' . SID . '&LineNo=' . $LnItm->LineNo . '">'.
					_('Enter Batches'). '</a></TD>';
			}
		}

		echo '</TR>';

	}//foreach(LineItem)
}//If count(LineItems) > 0

$DisplayTotal = number_format($DisplayTotal1,2);
echo '<TR><TD COLSPAN=8 ALIGN=RIGHT><B>' . _('Total value of goods processed'). '</B></TD>
	<TD ALIGN=RIGHT><FONT SIZE=2><B>'. $GrandTotal. '</B></FONT></TD>
</TR></TABLE>';

$SomethingReceived = 0;
if (count($_SESSION['PR']->LineItems)>0){
   foreach ($_SESSION['PR']->LineItems as $OrderLine) {
	  if ($OrderLine->ReceiveQty>0){
		$SomethingReceived =1;
	  }
   }
}



/*
$k=0; //row colour counter

			echo '<table><tr bgcolor="#EEEEEE">';
			$k=1;
		
			
		
		$LineTotal = ($LnItm->ReceiveQty * $LnItm->Price );
		$_SESSION['PR']->total = $_SESSION['PR']->total + $LineTotal;
		$DisplayQtyOrd = number_format($LnItm->Quantity,$LnItm->DecimalPlaces);
		$DisplayQtyRec = number_format($LnItm->QtyReceived,$LnItm->DecimalPlaces);
		$DisplayLineTotal = number_format($LineTotal,2);
		$DisplayPrice = number_format($LnItm->Price,2);
		$stockno = $_SESSION['PR']->StockNo;
		
		
//		$sqldesc = "select description, units from stockmaster where stockid='". $stockno . "'";
//		$resultdesc = DB_query($sql,$db);
//		$stockdesc = DB_fetch_row($resultdesc);
		$recdqty = $_SESSION['PR']->RecdQty;
		$ordqty = $_SESSION['PR']->OrdQty;
		$stocknodisplay = $_SESSION['PR']->StockNo;
		  

		//Now Display LineItem
		echo '<TD><FONT size=2>' . $stocknodisplay . '</FONT></TD>';
		echo '<TD><FONT size=2>' . $stockdesc[0] . '</TD>';
		echo '<TD ALIGN=RIGHT><FONT size=2>' . $ordqty . '</TD>';
		echo '<TD><FONT size=2>' . $stockdesc[1] . '</TD>';
		echo '<TD ALIGN=RIGHT><FONT size=2>' . $recdqty . '</TD>';
		echo '<TD ALIGN=RIGHT><FONT size=2>';

		echo '<input type=hidden name="RecvQty_0" value="' . $recdqty . '"><a href="GoodsProcessedControlled.php?' . SID . '&LineNo=0">' . number_format($recdqty,4) . '</a></TD>';

		
		echo '<TD ALIGN=RIGHT><FONT size=2></TD>';
		echo '<TD ALIGN=RIGHT><FONT size=2></FONT></TD>';

				
		echo '<TD><a href="GoodsProcessedControlled.php?' . SID . '&LineNo=' . $LnItm->LineNo . '">'.
					_('Enter Batches'). '</a></TD>';
			

		echo '</TR>';

//$tmp = ;
//$LnItm[]=999999;
//$b=$_SESSION['PR']->LineItems[2];
//$c=$LnItm;
//$d=$_SESSION['PR']->LineItems;
//$e=$LnItm->StockID;
//$f=print_r($LnItm);
//$_SESSION['PR']->LineItems[]=(LineNo => 4, PRDetailRec =>, StockID => 'FBA104', ItemDescription =>'test1', DecimalPlaces => 4, GLCode => 0, GLActName =>, Quantity => 10, UnitCost =>, Units => units, ReqDate => '00/00/0000', QtyInv => 0, QtyReceived => 0, StandardCost => 0, PRRef => 0, JobRef =>, ReceiveQty => 0, Deleted =>, Controlled => 1, Serialised => 0, SerialItems => Array ( ), StkModClass =>, Completed =>, SerialItemsValid =>);
//$LnItm[]=(LineNo => 4, PRDetailRec =>, StockID => 'FBA104', ItemDescription =>'test1', DecimalPlaces => 4, GLCode => 0, GLActName =>, Quantity => 10, UnitCost =>, Units => units, ReqDate => '00/00/0000', QtyInv => 0, QtyReceived => 0, StandardCost => 0, PRRef => 0, JobRef =>, ReceiveQty => 0, Deleted =>, Controlled => 1, Serialised => 0, SerialItems => Array ( ), StkModClass =>, Completed =>, SerialItemsValid =>);
//$_SESSION['PR']->LineItems[]=array (linedetails[]  => array ( LineNo => 4,StockID => "FBA100",Quantity => 10);
//$a=print_r($_SESSION['PR']->LineItems);

echo '<TR><TD COLSPAN=7 ALIGN=RIGHT><B>' . _('Total value of goods processed'). '</B></TD>
	<TD ALIGN=RIGHT><FONT SIZE=2><B>1 '. $a. ' - 2 '. $b. ' - 3 '. $c. ' - 4 '. $d. ' - 5 '. $e. ' - 6 '. $f. '  </B></FONT></TD>
</TR></TABLE>';

$SomethingReceived = 0;
if (count($_SESSION['PR']->LineItems)>0){
   foreach ($_SESSION['PR']->LineItems as $OrderLine) {
	  if ($OrderLine->ReceiveQty>0){
		$SomethingReceived =1;
	  }
   }
}
*/





/************************* LINE ITEM VALIDATION ************************/

/* Check whether trying to deliver more items than are recorded on the purchase order
(+ overreceive allowance) */

$DeliveryQuantityTooLarge = 0;

$InputError = false;

if (count($_SESSION['PR']->LineItems)>0){

   foreach ($_SESSION['PR']->LineItems as $OrderLine) {
/*	
	  if ($OrderLine->ReceiveQty+$OrderLine->QtyReceived > $OrderLine->Quantity * (1+ ($_SESSION['OverReceiveProportion'] / 100))){
		$DeliveryQuantityTooLarge =1;
		$InputError = true;
	  }
	*/ 
   }
}

if ($SomethingReceived==0 AND isset($_POST['ProcessGoodsProcessed'])){ /*Then dont bother proceeding cos nothing to do ! */

	prnMsg(_('There is nothing to process') . '. ' . _('Please enter valid quantities greater than zero'),'warn');

} /* elseif ($DeliveryQuantityTooLarge==1 AND isset($_POST['ProcessGoodsProcessed'])){

	prnMsg(_('Entered quantities cannot be greater than the quantity entered on the purchase invoice including the allowed over-receive percentage'). ' ' . '(' . $_SESSION['OverReceiveProportion'] .'%)','error');
	echo '<BR>';
	prnMsg(_('Modify the ordered items on the purchase invoice if you wish to increase the quantities'),'info');

} */ elseif (isset($_POST['ProcessGoodsProcessed']) AND $SomethingReceived==1 AND $InputError == false){

/* SQL to process the postings for goods received... */
/* Company record set at login for information on GL Links and debtors GL account*/

	
	if ($_SESSION['CompanyRecord']==0){
		/*The company data and preferences could not be retrieved for some reason */
		prnMsg(_('The company infomation and preferences could not be retrieved') . ' - ' . _('see your system administrator') , 'error');
		include('includes/footer.inc');
		exit;
	}

/*Now need to check that the order details are the same as they were when they were read into the Items array. If they've changed then someone else must have altered them */
// Otherwise if you try to fullfill item quantities separately will give error.
	$SQL = 'SELECT itemcode,
			glcode,
			quantityord,
			quantityrecd,
			qtyprocessed,
			prref,
			jobref
		FROM productionrundetails
		WHERE prno=' . (int) $_SESSION['PR']->PRNo . '
		AND completed=0
		ORDER BY prdetailitem';

	$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('Could not check that the details of the Item Assembly had not been changed by another user because'). ':';
	$DbgMsg = _('The following SQL to retrieve the Item Assembly details was used');
	$Result=DB_query($SQL,$db, $ErrMsg, $DbgMsg);

	$Changes=0;
	$LineNo=1;

	while ($myrow = DB_fetch_array($Result)) {

		if ($_SESSION['PR']->LineItems[$LineNo]->GLCode != $myrow['glcode'] OR
			$_SESSION['PR']->LineItems[$LineNo]->PRRef != $myrow['prref'] OR
			$_SESSION['PR']->LineItems[$LineNo]->JobRef != $myrow['jobref'] OR
			$_SESSION['PR']->LineItems[$LineNo]->QtyInv != $myrow['qtyprocessed'] OR
			$_SESSION['PR']->LineItems[$LineNo]->StockID != $myrow['itemcode'] OR
			$_SESSION['PR']->LineItems[$LineNo]->Quantity != $myrow['quantityord'] OR
			$_SESSION['PR']->LineItems[$LineNo]->QtyReceived != $myrow['quantityrecd']) {


			prnMsg(_('This Item Assembly has been changed or invoiced since this delivery was started to be actioned') . '. ' . _('Processing halted') . '. ' . _('To enter a delivery against this Item Assembly') . ', ' . _('it must be re-selected and re-read again to update the changes made by the other user'),'warn');

			if ($debug==1){
				echo '<TABLE BORDER=1>';
				echo '<TR><TD>' . _('GL Code of the Line Item') . ':</TD>
						<TD>' . $_SESSION['PR']->LineItems[$LineNo]->GLCode . '</TD>
						<TD>' . $myrow['glcode'] . '</TD></TR>';
				echo '<TR><TD>' . _('PRRef of the Line Item') . ':</TD>
					<TD>' . $_SESSION['PR']->LineItems[$LineNo]->PRRef . '</TD>
					<TD>' . $myrow['prref'] . '</TD></TR>';
				echo '<TR><TD>' . _('Contract Reference of the Line Item') . ':</TD>
					<TD>' . $_SESSION['PR']->LineItems[$LineNo]->JobRef . '</TD>
					<TD>' . $myrow['jobref'] . '</TD>
					</TR>';
				echo '<TR><TD>' . _('Quantity Invoiced of the Line Item') . ':</TD>
					<TD>' . $_SESSION['PR']->LineItems[$LineNo]->QtyInv . '</TD>
					<TD>' . $myrow['qtyprocessed'] . '</TD></TR>';
				echo '<TR><TD>' . _('Stock Code of the Line Item') . ':</TD>
					<TD>'. $_SESSION['PR']->LineItems[$LineNo]->StockID . '</TD>
					<TD>' . $myrow['itemcode'] . '</TD></TR>';
				echo '<TR><TD>' . _('Order Quantity of the Line Item') . ':</TD>
					<TD>' . $_SESSION['PR']->LineItems[$LineNo]->Quantity . '</TD>
					<TD>' . $myrow['quantityord'] . '</TD></TR>';
				echo '<TR><TD>' . _('Quantity of the Line Item Already Processed') . ':</TD>
					<TD>' . $_SESSION['PR']->LineItems[$LineNo]->QtyReceived . '</TD>
					<TD>' . $myrow['quantityrecd'] . '</TD></TR>';
				echo '</TABLE>';
			}
			echo "<CENTER><A HREF='$rootpath/PR_SelectProductionRun.php?" . SID . "'>".
				_('Select a different Item Assembly for processing').'</A></CENTER>';
			echo "<CENTER><A HREF='$rootpath/GoodsProcessed.php?" . SID . '&PONumber=' .
				$_SESSION['PR']->PRNumber . '">'. _('Re-read the updated Item Assembly for processing goods'). '</A></CENTER>';
			unset($_SESSION['PR']->LineItems);
			unset($_SESSION['PR']);
			unset($_POST['ProcessGoodsProcessed']);
			include ("includes/footer.inc");
			exit;
		}
		$LineNo++;
	} /*loop through all line items of the order to ensure none have been invoiced */

	DB_free_result($Result);


/************************ BEGIN SQL TRANSACTIONS ************************/

	$Result = DB_query('BEGIN',$db);
/*Now Get the next GRN - function in SQL_CommonFunctions*/
	$GRN = GetNextTransNo(25, $db);

	$PeriodNo = GetPeriod($_POST['DefaultReceivedDate'], $db);
	$_POST['DefaultReceivedDate'] = FormatDateForSQL($_POST['DefaultReceivedDate']);
	foreach ($_SESSION['PR']->LineItems as $OrderLine) {

		if ($OrderLine->ReceiveQty !=0 AND $OrderLine->ReceiveQty!='' AND isset($OrderLine->ReceiveQty)) {

			$LocalCurrencyPrice = $OrderLine->BomUnitCost ;
/*Update SalesOrderDetails for the new quantity received and the standard cost used for postings to GL and recorded in the stock movements for FIFO/LIFO stocks valuations*/

			if ($OrderLine->StockID!='') { /*Its a stock item line */
				/*Need to get the current standard cost as it is now so we can process GL jorunals later*/
				$SQL = "SELECT materialcost + overheadcost as stdcost 
						FROM stockmaster 
						WHERE stockid='" . DB_escape_string($OrderLine->StockID) . "'";
				$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The standard cost of the item being processed cannot be retrieved because');
				$DbgMsg = _('The following SQL to retrieve the standard cost was used');
				$Result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

				$myrow = DB_fetch_row($Result);

				if ($OrderLine->QtyReceived==0){ //its the first receipt against this line
					$_SESSION['PR']->LineItems[$OrderLine->LineNo]->StandardCost = $myrow[0];
				}
				$CurrentStandardCost = $myrow[0];

			} elseif ($OrderLine->QtyReceived==0 AND $OrderLine->StockID=="") {
				/*Its a nominal item being received */
				/*Need to record the value of the order per unit in the standard cost field to ensure GRN account entries clear */
				$_SESSION['PR']->LineItems[$OrderLine->LineNo]->StandardCost = $LocalCurrencyPrice;

			}

			if ($OrderLine->StockID=='') { /*Its a NOMINAL item line */
//				$CurrentStandardCost = $_SESSION['PR']->LineItems[$OrderLine->LineNo]->StandardCost;
				$CurrentStandardCost = $myrow[0];

			}

/*Now the SQL to do the update to the PurchOrderDetails */

			if ($OrderLine->ReceiveQty >= ($OrderLine->Quantity + $OrderLine->QtyReceived)){
				$SQL = "UPDATE productionrundetails SET
							quantityrecd = quantityrecd + " . -$OrderLine->ReceiveQty . ",
							actcostunit=" . $CurrentStandardCost . ",
							processdate='" . $_POST['DefaultReceivedDate']  . "',
							completed=1
					WHERE prdetailitem = " . $OrderLine->PRDetailRec;
					
					
			} else {
				$SQL = "UPDATE productionrundetails SET
							quantityrecd = quantityrecd + " . -$OrderLine->ReceiveQty . ",
							actcostunit=" . $CurrentStandardCost . ",
							processdate='" . $_POST['DefaultReceivedDate']  . "',
							completed=0
					WHERE prdetailitem = " . $OrderLine->PRDetailRec;
					
					
			}

			$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The Item Assembly detail record could not be updated with the quantity processed because');
			$DbgMsg = _('The following SQL to update the Item Assembly detail record was used');
			$Result = DB_query($SQL,$db, $ErrMsg, $DbgMsg, true);

// prnMsg(_('sql ') . $SQL . _('see your system administrator') , 'warn');
			if ($OrderLine->StockID !=''){ /*Its a stock item so use the standard cost for the journals */
				$BomUnitCost = $_SESSION['PR']->LineItems[$OrderLine->LineNo]->StandardCost;
			} else {  /*otherwise its a nominal PO item so use the purchase cost converted to local currecny */
				$BomUnitCost = $OrderLine->BomUnitCost / $_SESSION['PR']->ExRate;
			}

/*Need to insert a GRN item */

			$SQL = "INSERT INTO grns (grnbatch,
						podetailitem,
						itemcode,
						itemdescription,
						deliverydate,
						qtyrecd,
						supplierid)
				VALUES (" . $GRN . ",
					" . $OrderLine->PRDetailRec . ",
					'" . DB_escape_string($OrderLine->StockID) . "',
					'" . DB_escape_string($OrderLine->ItemDescription) . "',
					'" . $_POST['DefaultReceivedDate'] . "',
					" . DB_escape_string(-$OrderLine->ReceiveQty) . ",
					'" . DB_escape_string($_SESSION['PR']->SupplierID) . "')";

			$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('A GRN record could not be inserted') . '. ' . _('This receipt of goods has not been processed because');
			$DbgMsg =  _('The following SQL to insert the GRN record was used');
			$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);

			if ($OrderLine->StockID!=''){ /* if the order line is in fact a stock item */

/* Update location stock records - NB  a PO cannot be entered for a dummy/assembly/kit parts */
$sqlloc="SELECT location from workcentres where code='" . $_SESSION['PR']->Workcentre . "'";
$locresult1 = DB_query($sqlloc, $db);
				if (DB_num_rows($locresult1)==1){
					$locresultrow1 = DB_fetch_row($locresult1);
					$loc1 = $locresultrow1[0];
				} else {
					/*There must actually be some error this should never happen */
					$loc1 = 0;
				}

/* Need to get the current location quantity will need it later for the stock movement */
				$SQL="SELECT locstock.quantity
					FROM locstock
					WHERE locstock.stockid='" . DB_escape_string($OrderLine->StockID) . "'
					AND loccode='" . $loc1 . "'";

				$Result = DB_query($SQL, $db);
				if (DB_num_rows($Result)==1){
					$LocQtyRow = DB_fetch_row($Result);
					$QtyOnHandPrior = $LocQtyRow[0];
				} else {
					/*There must actually be some error this should never happen */
					$QtyOnHandPrior = 0;
				}

				$SQL = "UPDATE locstock
					SET quantity = locstock.quantity + " . -$OrderLine->ReceiveQty . "
					WHERE locstock.stockid = '" . DB_escape_string($OrderLine->StockID) . "'
					AND loccode = '" . $loc1 . "'";

				$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The location stock record could not be updated because');
				$DbgMsg =  _('The following SQL to update the location stock record was used');
				$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);


	/* If its a stock item still .... Insert stock movements - with unit cost */

				$SQL = "INSERT INTO stockmoves (stockid,
								type,
								transno,
								loccode,
								trandate,
								price,
								prd,
								reference,
								qty,
								standardcost,
								newqoh)
					VALUES ('" . DB_escape_string($OrderLine->StockID) . "',
						25,
						" . $GRN . ", '" . $loc1 . "',
						'" . $_POST['DefaultReceivedDate'] . "',
						" . $LocalCurrencyPrice . ",
						" . $PeriodNo . ",
						'" . DB_escape_string($_SESSION['PR']->SupplierID) . " - " .$_SESSION['PR']->PRNo . "',
						" . -$OrderLine->ReceiveQty . ",
						" . $_SESSION['PR']->LineItems[$OrderLine->LineNo]->StandardCost . ",
						" . ($QtyOnHandPrior + -$OrderLine->ReceiveQty) . ")";

				$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('stock movement records could not be inserted because');
				$DbgMsg =  _('The following SQL to insert the stock movement records was used');
				$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);

				/*Get the ID of the StockMove... */
				$StkMoveNo = DB_Last_Insert_ID($db,'stockmoves','stkmoveno');
				/* Do the Controlled Item INSERTS HERE */

          			if ($OrderLine->Controlled ==1){
					foreach($OrderLine->SerialItems as $Item){
                                        	/* we know that StockItems return an array of SerialItem (s)
						We need to add the StockSerialItem record and
						The StockSerialMoves as well */
						 //need to test if the controlled item exists first already
							$SQL = "SELECT COUNT(*) FROM stockserialitems 
									WHERE stockid='" . $OrderLine->StockID . "' 
									AND loccode = '" . $loc1 . "' 
									AND serialno = '" . $Item->BundleRef . "'";
							$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('Could not check if a batch or lot stock item already exists because');
							$DbgMsg =  _('The following SQL to test for an already existing controlled but not serialised stock item was used');
	//						prnMsg(_('Stock Serial Moves SQL ') . ' - ' . _(' ' . ' 1 ' .  $SQL ),'info');

							$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);
							$AlreadyExistsRow = DB_fetch_row($Result);
							if (trim($Item->BundleRef) != ""){
								if ($AlreadyExistsRow[0]>0){
									if ($OrderLine->Serialised == 1) {
										$SQL = 'UPDATE stockserialitems SET quantity = ' . -$Item->BundleQty . ' ';
									} else {
										$SQL = 'UPDATE stockserialitems SET quantity = quantity - ' . $Item->BundleQty . ' ';
									}
									$SQL .= "WHERE stockid='" . $OrderLine->StockID . "' 
											 AND loccode = '" . $loc1 . "' 
											 AND serialno = '" . $Item->BundleRef . "'";
								} else {
									$SQL = "INSERT INTO stockserialitems (stockid,
												loccode,
												serialno,
												quantity)
											VALUES ('" . $OrderLine->StockID . "',
												'" . $loc1 . "',
												'" . $Item->BundleRef . "',
												" . -$Item->BundleQty . ")";
								}
							
							$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The serial stock item record could not be inserted because');
							$DbgMsg =  _('The following SQL to insert the serial stock item records was used');
						//	 prnMsg(_('Serial Stock ') . ' - ' . _(' ' . ' 1 ' .  $SQL  . ' 2 ' .  $Item->BundleQty  . ' 3 ' .  $aa3 . ' 4 ' .  $aa4 ),'info');

							$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);	
 
						/** end of handle stockserialitems records */
					
						/** now insert the serial stock movement **/
						$SQL = "INSERT INTO stockserialmoves (stockmoveno,
											stockid,
											serialno,
											moveqty)
									VALUES (" . $StkMoveNo . ",
										'" . DB_escape_string($OrderLine->StockID) . "',
										'" . DB_escape_string($Item->BundleRef) . "',
										" . $Item->BundleQty . ")";
						$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The serial stock movement record could not be inserted because');
						$DbgMsg = _('The following SQL to insert the serial stock movement records was used');
						$Result = DB_query($SQL, $db, $ErrMsg, $DbgMsg, true);
					 }//non blank BundleRef
					} //end foreach
				}
			} /*end of its a stock item - updates to locations and insert movements*/



$SQLupdatePR="update productionruns set bomunitcost=" . $BOMC . " where prno=" . $_SESSION['PR']->PRNo;


$ErrMsg =  _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The Item Assembly detail record could not be updated with the quantity processed because');
			$DbgMsg = _('The following SQL to update the Item Assembly detail record was used');
			$Result = DB_query($SQLupdatePR,$db, $ErrMsg, $DbgMsg, true);

// prnMsg(_('sql ') . $SQLupdatePR . _('see your system administrator') , 'warn');





/* If GLLink_Stock then insert GLTrans to debit the GL Code  and credit GRN Suspense account at standard cost*/
			if ($_SESSION['PR']->GLLink==1 AND $OrderLine->GLCode !=0){ /*GLCode is set to 0 when the GLLink is not activated this covers a situation where the GLLink is now active but it wasn't when this PO was entered */
				
/*first the debit using the GLCode in the PO detail record entry*/

				$SQL = "INSERT INTO gltrans (type,
								typeno,
								trandate,
								periodno,
								account,
								narrative,
								amount)
						VALUES (25,
							" . $GRN . ",
							'" . $_POST['DefaultReceivedDate'] . "',
							" . $PeriodNo . ",
							" . $OrderLine->GLCode . ",
							'PO: " . DB_escape_string($_SESSION['PR']->PRNo) . " " . DB_escape_string($_SESSION['PR']->SupplierID) . " - " . DB_escape_string($OrderLine->StockID) . " - " . DB_escape_string($OrderLine->ItemDescription) . " x " . DB_escape_string(-$OrderLine->ReceiveQty) . " @ " . number_format($CurrentStandardCost,2) . "',
							" . $CurrentStandardCost * -$OrderLine->ReceiveQty . ")";

				$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The purchase GL posting could not be inserted because');
				$DbgMsg = _('The following SQL to insert the purchase GLTrans record was used');
				$Result = DB_query($SQL,$db,$ErrMsg, $DbgMsg, true);

				/* If the CurrentStandardCost != UnitCost (the standard at the time the first delivery was booked in,  and its a stock item, then the difference needs to be booked in against the purchase price variance account*/

				if ($BomUnitCost != $CurrentStandardCost AND $OrderLine->StockID!='') {

					$UnitCostDifference = $BomUnitCost - $CurrentStandardCost;
					$StockGLCodes = GetStockGLCode($OrderLine->StockID,$db);

					$SQL = "INSERT INTO gltrans (type,
									typeno,
									trandate,
									periodno,
									account,
									narrative,
									amount)
							VALUES (25,
								" . $GRN . ",
								'" . $_POST['DefaultReceivedDate'] . "',
								" . $PeriodNo . ",
								" . $StockGLCodes['purchpricevaract'] . ",
								'" . _('Cost diff on') . ' ' . DB_escape_string($_SESSION['PR']->SupplierID) . ' - ' . DB_escape_string($OrderLine->StockID) . " " . -$OrderLine->ReceiveQty . " @ (" . number_format($CurrentStandardCost,2) . ' - ' ._('Prev std') . ' ' . number_format($BomUnitCost,2) . ")',
								" . ($UnitCostDifference * -$OrderLine->ReceiveQty) . ")";

					$ErrMsg = _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The standard cost difference GL posting could not be inserted because');
					$DbgMsg = _('The following SQL to insert the cost difference GLTrans record was used');
					$Result = DB_query($SQL,$db, $ErrMsg, $DbgMsg, true);
				}

	/*now the GRN suspense entry*/
				$SQL = "INSERT INTO gltrans (type,
								typeno,
								trandate,
								periodno,
								account,
								narrative,
								amount)
						VALUES (25,
							" . $GRN . ",
							'" . $_POST['DefaultReceivedDate'] . "',
							" . $PeriodNo . ",
							" . $_SESSION['CompanyRecord']['grnact'] . ", '" .
							_('PO') . ': ' . $_SESSION['PR']->PRNo . ' ' . DB_escape_string($_SESSION['PR']->SupplierID) . ' - ' . DB_escape_string($OrderLine->StockID) . ' - ' . DB_escape_string($OrderLine->ItemDescription) . ' x ' . -$OrderLine->ReceiveQty . ' @ ' . number_format($BomUnitCost,2) . "',
							" . -$BomUnitCost * -$OrderLine->ReceiveQty . ")";

				$ErrMsg =   _('CRITICAL ERROR') . '! ' . _('NOTE DOWN THIS ERROR AND SEEK ASSISTANCE') . ': ' . _('The GRN suspense side of the GL posting could not be inserted because');
				$DbgMsg =  _('The following SQL to insert the GRN Suspense GLTrans record was used');
				$Result = DB_query($SQL,$db, $ErrMsg, $DbgMsg,true);

			 } /* end of if GL and stock integrated and standard cost !=0 */
		} /*Quantity received is != 0 */
	} /*end of OrderLine loop */

	$SQL='COMMIT';
	$Result = DB_query($SQL,$db);
	$reference=$_SESSION['PR']->PRNo;

	unset($_SESSION['PR']->LineItems);
	unset($_SESSION['PR']);
	unset($_POST['ProcessGoodsProcessed']);
$insert="&PRNumber=" . $GRN;

	echo '<BR>'. _('GRN number'). ' '. $GRN .' '. _('has been processed').'<BR>';
	echo "<A HREF='$rootpath/PR_SelectProductionRun.php?" . SID . "'>" . _('Select a different Item Assembly for processing'). '</A>';
/*end of process goods received entry */

//if ($_SESSION['PO']->OrdDate>0)
//{$_POST['OrdDate'] = $_SESSION['PO']->OrdDate;}
/*	$_SESSION['PR']->Location=$_POST['StkLocation'];
	$_SESSION['PR']->PRNo = $_POST['PRNo'];
	$_SESSION['PR']->DelAdd2 = $_POST['DelAdd2'];
	$_SESSION['PR']->DelAdd3 = $_POST['DelAdd3'];
	$_SESSION['PR']->DelAdd4 = $_POST['DelAdd4'];
	$_SESSION['PR']->DelAdd5 = $_POST['DelAdd5'];
	$_SESSION['PR']->DelAdd6 = $_POST['DelAdd6'];
	$_SESSION['PR']->Initiator = $_POST['Initiator'];
	$_SESSION['PR']->Orig_OrderDate = $_POST['OrdDate'];
	$_SESSION['PR']->ReqDate = $_POST['ReqDate'];
	$_SESSION['PR']->ShipVia = $_POST['ShipVia'];
	$_SESSION['PR']->RequisitionNo = $_POST['Requisition'];
	$_SESSION['PR']->ExRate = $_POST['ExRate'];
	$_SESSION['PR']->Comments = $_POST['Comments'];
*/
	$insert="&PRNumber=" . $reference;

	echo "<META HTTP-EQUIV='Refresh' CONTENT='1; URL=" . $rootpath . '/GoodsProcessed2.php?' . $insert . "'>";
	echo '<P>';
	
	prnMsg(_('You should automatically be forwarded to the entry of the purchase order line items page') . '. ' . _('If this does not happen') . ' (' . _('if the browser does not support META Refresh') . ') ' . "<a href='$rootpath/GoodsProcessed2.php?" . SID . "'>" . _('click here') . '</a> ' . _('to continue'),'info');




//	include('includes/footer.inc');
//	exit;

} else { /*Process Goods received not set so show a link to allow mod of line items on order and allow input of date goods received*/

//	echo "<BR><CENTER><A HREF='$rootpath/PO_Items.php?=" . SID . "'>" . _('Modify Order Items'). '</A></CENTER>';

	if (!isset($_POST['DefaultReceivedDate'])){
	   $_POST['DefaultReceivedDate'] = Date($_SESSION['DefaultDateFormat']);
	}
	echo '<TABLE><TR><TD>'. _('Date Goods/Service Received'). ':</TD><TD><INPUT TYPE=text MAXLENGTH=10 SIZE=10 name=DefaultReceivedDate value="' . $_POST['DefaultReceivedDate'] . '"></TD></TR>';

	echo '</TABLE><CENTER><INPUT TYPE=SUBMIT NAME=Update Value=' . _('Update') . '><P>';
	echo '<INPUT TYPE=SUBMIT NAME="ProcessGoodsProcessed" Value="' . _('Process Item Assembly Goods') . '"></CENTER>';
	
}

echo '</FORM>';
echo '<P><a href="GoodsProcessed2.php?PRNumber=' . $_GET['PRNumber'] . '">Click here to process Finished Goods</a> (confirm quantities produced)</P>'	;
include('includes/footer.inc');
?>