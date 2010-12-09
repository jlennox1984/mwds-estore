<?php

/* $Revision: 1.23 $ */

/*
This is where the delivery details are confirmed/entered/modified and the order committed to the database once the place order/modify order button is hit.
*/

include('includes/DefineCartClass.php');

/* Session started in header.inc for password checking the session will contain the details of the order from the Cart class object. The details of the order come from SelectOrderItems.php 			*/

$PageSecurity=1;
include('includes/session.inc');
$title = _('Order Delivery Details');
include('includes/header.inc');
include('includes/FreightCalculation.inc');


if (!isset($_SESSION['Items']) OR !isset($_SESSION['Items']->DebtorNo)){
	prnMsg(_('This page can only be read if an order has been entered') . '. ' . _('To enter an order select customer transactions then sales order entry'),'error');
	include('includes/footer.inc');
	exit;
}

If ($_SESSION['Items']->ItemsOrdered == 0){
	prnMsg(_('This page can only be read if an there are items on the order') . '. ' . _('To enter an order select customer transactions, then sales order entry'),'error');
	include('includes/footer.inc');
	exit;
}

/*Calculate the earliest dispacth date in DateFunctions.inc */

$EarliestDispatch = CalcEarliestDispatchDate();

If (isset($_POST['ProcessOrder']) OR isset($_POST['MakeRecurringOrder'])) {

	/*need to check for input errors in any case before order processed */
	$_POST['Update']='Yes rerun the validation checks';

	/*store the old freight cost before it is recalculated to ensure that there has been no change - test for change after freight recalculated and get user to re-confirm if changed */

	$OldFreightCost = $_POST['FreightCost'];

}

If (isset($_POST['Update']) 
	OR isset($_POST['BackToLineDetails']) 
	OR isset($_POST['MakeRecurringOrder']))   {
	
	$InputErrors =0;
	If (strlen($_POST['DeliverTo'])<=1){
		$InputErrors =1;
		prnMsg(_('You must enter the person or company to whom delivery should be made'),'error');
	}
	If (strlen($_POST['Subject'])<=1){
		$InputErrors =1;
		prnMsg(_('You must a customer reference'),'error');
	}
	If (strlen($_POST['BrAdd1'])<=1){
		$InputErrors =1;
		prnMsg(_('You should enter the street address in the box provided') . '. ' . _('Orders cannot be accepted without a valid street address'),'error');
	}
	If (strpos($_POST['BrAdd1'],_('Box'))>0){
		prnMsg(_('You have entered the word') . ' "' . _('Box') . '" ' . _('in the street address') . '. ' . _('Items cannot be delivered to') . ' ' ._('box') . ' ' . _('addresses'),'warn');
	}
	If (!is_numeric($_POST['FreightCost'])){
		$InputErrors =1;
		prnMsg( _('The freight cost entered is expected to be numeric'),'error');
	}
	if (isset($_POST['MakeRecurringOrder']) AND $_POST['Quotation']==1){
		$InputErrors =1;
		prnMsg( _('A recurring order cannot be made from a quotation'),'error');
	}
	If (($_POST['DeliverBlind'])<=0){
		$InputErrors =1;
		prnMsg(_('You must select the type of packlist to print'),'error');
	}

/*	If (strlen($_POST['BrAdd3'])==0 OR !isset($_POST['BrAdd3'])){
		$InputErrors =1;
		echo "<BR>A region or city must be entered.<BR>";
	}

	Maybe appropriate in some installations but not here
	If (strlen($_POST['BrAdd2'])<=1){
		$InputErrors =1;
		echo "<BR>You should enter the suburb in the box provided. Orders cannot be accepted without a valid suburb being entered.<BR>";
	}

*/

	If(!Is_Date($_POST['DeliveryDate'])) {
		$InputErrors =1;
		prnMsg(_('An invalid date entry was made') . '. ' . _('The date entry for the despatch date must be in the format') . ' ' . $_SESSION['DefaultDateFormat'],'warn');
	}

	 /* This check is not appropriate where orders need to be entered in retrospectively in some cases this check will be appropriate and this should be uncommented

	 elseif (Date1GreaterThanDate2(Date($_SESSION['DefaultDateFormat'],$EarliestDispatch), $_POST['DeliveryDate'])){
		$InputErrors =1;
		echo '<BR><B>' . _('The delivery details cannot be updated because you are attempting to set the date the order is to be dispatched earlier than is possible. No dispatches are made on Saturday and Sunday. Also, the dispatch cut off time is') .  $_SESSION['DispatchCutOffTime']  . _(':00 hrs. Orders placed after this time will be dispatched the following working day.');
	}

	*/

	If ($InputErrors==0){

		$_SESSION['Items']->DeliverTo = $_POST['DeliverTo'];
		$_SESSION['Items']->DeliveryDate = $_POST['DeliveryDate'];
		$_SESSION['Items']->DeliveryDate2 = $_POST['DeliveryDate2'];
		$_SESSION['Items']->DelAdd1 = $_POST['BrAdd1'];
		$_SESSION['Items']->DelAdd2 = $_POST['BrAdd2'];
		$_SESSION['Items']->DelAdd3 = $_POST['BrAdd3'];
		$_SESSION['Items']->DelAdd4 = $_POST['BrAdd4'];
		$_SESSION['Items']->DelAdd5 = $_POST['BrAdd5'];
		$_SESSION['Items']->DelAdd6 = $_POST['BrAdd6'];
		$_SESSION['Items']->PhoneNo =$_POST['PhoneNo'];
		$_SESSION['Items']->Email =$_POST['Email'];
		$_SESSION['Items']->Location = $_POST['Location'];
		$_SESSION['Items']->CustRef = $_POST['Subject'];
		$_SESSION['Items']->Subject = $_POST['Subject'];
		$_SESSION['Items']->Comments = $_POST['Comments'];
		$_SESSION['Items']->Conditions = $_POST['Conditions'];
		$_SESSION['Items']->FreightCost = $_POST['FreightCost'];
		$_SESSION['Items']->FreightTax = $_POST['FreightTax'];
		$_SESSION['Items']->SalesTax = $_POST['SalesTax'];
		$_SESSION['Items']->ShipVia = $_POST['ShipVia'];
		$_SESSION['Items']->Quotation = $_POST['Quotation'];
		$_SESSION['Items']->DeliverBlind = $_POST['DeliverBlind'];

		/*$_SESSION['DoFreightCalc'] is a setting in the config.php file that the user can set to false to turn off freight calculations if necessary */

		if ($_SESSION['DoFreightCalc']==True){
		      list ($_POST['FreightCost'], $BestShipper) = CalcFreightCost($_SESSION['Items']->total, $_POST['BrAdd2'], $_POST['BrAdd3'], $_SESSION['Items']->totalVolume, $_SESSION['Items']->totalWeight, $_SESSION['Items']->Location, $db) ;
		      $_POST['ShipVia'] = $BestShipper;
		}

		/* What to do if the shipper is not calculated using the system
		- first check that the default shipper defined in config.php is in the database
		if so use this
		- then check to see if any shippers are defined at all if not report the error
		and show a link to set them up
		- if shippers defined but the default shipper is bogus then use the first shipper defined
		*/
		if (($BestShipper==''|| !isset($BestShipper)) AND ($_POST['ShipVia']=='' || !isset($_POST['ShipVia']))){
			$SQL =  "SELECT shipper_id FROM shippers WHERE shipper_id=" . $_SESSION['Default_Shipper'];
			$ErrMsg = _('There was a problem testing for the default shipper');
			$TestShipperExists = DB_query($SQL,$db,$ErrMsg);

			if (DB_num_rows($TestShipperExists)==1){

				$BestShipper = $_SESSION['Default_Shipper'];

			} else {

				$SQL =  'SELECT shipper_id FROM shippers';
				$TestShipperExists = DB_query($SQL,$db,$ErrMsg);

				if (DB_num_rows($TestShipperExists)>=1){
					$ShipperReturned = DB_fetch_row($TestShipperExists);
					$BestShipper = $ShipperReturned[0];
				} else {
					prnMsg(_('We have a problem') . ' - ' . _('there are no shippers defined'). '. ' . _('Please use the link below to set up shipping or freight companies') . ', ' . _('the system expects the shipping company to be selected or a default freight company to be used'),'error');
					echo "<A HREF='" . $rootpath . "Shippers.php'>". _('Enter') . '/' . _('Amend Freight Companies') .'</A>';
				}
			}
			if (isset($_SESSION['Items']->ShipVia) AND $_SESSION['Items']->ShipVia!=''){
				$_POST['ShipVia'] = $_SESSION['Items']->ShipVia;
			} else {
				$_POST['ShipVia']=$BestShipper;
			}
		}
	}
}


if(isset($_POST['MakeRecurringOrder']) AND ! $InputErrors){
	
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=" . $rootpath . '/RecurringSalesOrders.php?' . SID . "&NewRecurringOrder=Yes'>";
	prnMsg(_('You should automatically be forwarded to the entry of recurring order details page') . '. ' . _('If this does not happen') . '(' . _('if the browser does not support META Refresh') . ') ' ."<a href='" . $rootpath . '/RecurringOrders.php?' . SID . "&NewRecurringOrder=Yes'>". _('click here') .'</a> '. _('to continue'),'info');
	include('includes/footer.inc');
	exit;
}


if ($_POST['BackToLineDetails']==_('Modify Order Lines')){

	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=" . $rootpath . '/SelectOrderItems.php?' . SID . "'>";
	prnMsg(_('You should automatically be forwarded to the entry of the order line details page') . '. ' . _('If this does not happen') . '(' . _('if the browser does not support META Refresh') . ') ' ."<a href='" . $rootpath . '/SelectOrderItems.php?' . SID . "'>". _('click here') .'</a> '. _('to continue'),'info');
	include('includes/footer.inc');
	exit;

}

If (isset($_POST['ProcessOrder'])) {
	/*Default OK_to_PROCESS to 1 change to 0 later if hit a snag */
	if ($InputErrors ==0) {
		$OK_to_PROCESS = 1;
	}
	If ($_POST['FreightCost'] != $OldFreightCost && $_SESSION['DoFreightCalc']==True){
		$OK_to_PROCESS = 0;
		prnMsg(_('The freight charge has been updated') . '. ' . _('Please reconfirm that the order and the freight charges are acceptable and then confirm the order again if OK') .' <BR> '. _('The new freight cost is') .' ' . $_POST['FreightCost'] . ' ' . _('and the previously calculated freight cost was') .' '. $OldFreightCost,'warn');
	} else {

/*check the customer's payment terms */
		$sql = "SELECT daysbeforedue,
				dayinfollowingmonth
			FROM debtorsmaster,
				paymentterms
			WHERE debtorsmaster.paymentterms=paymentterms.termsindicator
			AND debtorsmaster.debtorno = '" . $_SESSION['Items']->DebtorNo . "'";

		$ErrMsg = _('The customer terms cannot be determined') . '. ' . _('This order cannot be processed because');
		$TermsResult = DB_query($sql,$db,$ErrMsg);


		$myrow = DB_fetch_array($TermsResult);
		if ($myrow['daysbeforedue']==0 && $myrow['dayinfollowingmonth']==0){

/* THIS IS A CASH SALE NEED TO GO OFF TO 3RD PARTY SITE SENDING MERCHANT ACCOUNT DETAILS AND CHECK FOR APPROVAL FROM 3RD PARTY SITE BEFORE CONTINUING TO PROCESS THE ORDER

UNTIL ONLINE CREDIT CARD PROCESSING IS PERFORMED ASSUME OK TO PROCESS

		NOT YET CODED     */

			$OK_to_PROCESS =1;


		} #end if cash sale detected

	} #end if else freight charge not altered
} #end if process order

if ($OK_to_PROCESS == 1 && $_SESSION['ExistingOrder']==0){

/* finally write the order header to the database and then the order line details - a transaction would	be good here */

	$DelDate = FormatDateforSQL($_SESSION['Items']->DeliveryDate);
	$crm_id = getCrmID($db);
	$DelDate = FormatDateforSQL($_SESSION['Items']->DeliveryDate);
	$OrderNo = getUniqueID($db);
	
	$Descr = $_POST['Conditions'];
	
					
					$today = date("YmdHis");
					$sql = "insert into crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values('".$crm_id."','1','1','SalesOrder','" . $Descr . "','".$today."','".$today."')";
	
					$ErrMsg =  _('The locations for the item') . ' ' . $myrow[0] .  ' ' . _('could not be added because');
					$DbgMsg = _('Could not add CRM') . ' ' . _('The SQL that was used to add the CRM entity');
					$CRMResult = DB_query($sql,$db,$ErrMsg,$DbgMsg);

					$sql2 = "update crmentity_seq set id = ".$crm_id."";
	echo '<BR>'._('Success')._('added.');
					
					$ErrMsg =  _('CRM Sequence failed') . ' ' . $myrow[0] .  ' ' . _('could not be added');
					$DbgMsg = _('CRM Sequence failed') . '   ' . _('The SQL that was used to add the CRM Sequence');
					$CRMseqResult = DB_query($sql2,$db,$ErrMsg,$DbgMsg);
//					echo '<BR>'._('The new crmid is').' ' . $new_id. ' '._('added.');
					//prnMsg(_('CRM Number') . ' ' . $crm_id . ' ' . _('has been entered'),'success');
	
	


	
	//	$OrderNo = DB_Last_Insert_ID($db,'salesorders','orderno');
	$StartOf_LineItemsSQL = "INSERT INTO salesorderdetails (
						orderlineno,
						orderno,
						stkcode,
						unitprice,
						quantity,
						discountpercent,
						narrative,
						salesorderid,
						productid)
					VALUES (";

	foreach ($_SESSION['Items']->LineItems as $StockItem) {
	//prnMsg(_('Session AccountId ') . ' ' . $_SESSION['Items']->AccountId . ' ' . _('Stock AccountId ') . ' ' . $StockItem->AccountId . ' ' . _('Session Location ') . ' ' . $_SESSION['Items']->Location . ' ' . _('Stock StockID ') . ' ' . $StockItem->StockID ,'success');
		$ItemTax = GetItemTax ($_SESSION['Items']->AccountId,$StockItem->StockID,$_SESSION['Items']->Location);
	
	
		$product_id = getProductID($StockItem->StockID);
		$LineItemsSQL = $StartOf_LineItemsSQL .
					$StockItem->LineNumber . ",
					" . $OrderNo . ",
					'" . $StockItem->StockID . "',
					". $StockItem->Price . ",
					" . $StockItem->Quantity . ",
					" . floatval($StockItem->DiscountPercent) . ",
					'" . DB_escape_string($StockItem->Narrative) . "',
					'" . $crm_id . "',
					'" . $product_id . "'
				)";
		$Ins_LineItemResult = DB_query($LineItemsSQL,$db);
		If (($StockItem->DiscountPercent < 0.0001) || ($StockItem->DiscountPercent == ''))
	{$StockItem->DiscountPercent = 0 ;}
	$ItemTaxTotal = ($StockItem->Price * $StockItem->Quantity - ($StockItem->Price * $StockItem->Quantity * $StockItem->DiscountPercent)) * $ItemTax;
		$TaxTotal = $TaxTotal + $ItemTaxTotal;
	//	prnMsg(_('Query ') . ' ' . $LineItemsSQL . ' ' . _('has been applied ') . ' ' . $StockItem->StockID ,'success');
	//	prnMsg(_('Tax Rate ') . ' ' . $ItemTax . ' ' . _('has been applied to item ') . ' ' . $StockItem->StockID ,'success');
	//	prnMsg(_('Tax Amount ') . ' ' . $ItemTaxTotal . ' ' . _('has been applied to item ') . ' ' . $StockItem->StockID ,'success');

	} /* inserted line items into sales order details */




if(($TaxTotal == '') || (!isset($TaxTotal)))
{$TaxTotal = 0;}
if(($_SESSION['Items']->FreightTax == '') || (!isset($_SESSION['Items']->FreightTax)))
{$_SESSION['Items']->FreightTax = 0;}



$one = $_SESSION['Items']->SalesTax;
$two = $_SESSION['Items']->SalesTaxOriginal;
//prnMsg(_('GST new ') . ' ' . $one . ' ' . _('Gst old ') . ' ' . $two,'success');

$three = $_SESSION['Items']->FreightCost;
$four = $_SESSION['Items']->FreightCostOriginal;
//prnMsg(_('Freight new ') . ' ' . $three . ' ' . _('Freight old ') . ' ' . $four,'success');


	$GrandTotal = $_SESSION['Items']->total + $TaxTotal;
	$DiscountTotal2 = $_SESSION['Items']->discounttotal;
//	prnMsg(_('Subject  ') . ' ' . $_SESSION['Items']->Subject . ' ' . _('Session CustRef ') . ' ' . $_SESSION['Items']->CustRef,'success');
	if ((!isset($_SESSION['Items']->CustRef)) || ($_SESSION['Items']->CustRef == ''))
	{ 
	$_SESSION['Items']->CustRef = $_SESSION['Items']->Subject;
	}
	
//prnMsg(_('Subject  ') . ' ' . $_SESSION['Items']->Subject . ' ' . _('Session CustRef ') . ' ' . $_SESSION['Items']->CustRef,'success');

//	$OrderNo = 'SO'.$OrderNoStart;
        
	$HeaderSQL = "INSERT INTO salesorders (
				orderno,
				debtorno,
				branchcode,
				customerref,
				comments,
				orddate,
				ordertype,
				shipvia,
				deliverto,
				deladd1,
				deladd2,
				deladd3,
				deladd4,
				deladd5,
				deladd6,
				contactphone,
				contactemail,
				freightcost,
				freighttax,
				fromstkloc,
				duedate,
				deliverydate,
				quotation,
                		deliverblind,
                		accountid,
						salesorderid,
						sostatus,
						subject,
						pending,
						subtotal,
						salestax,
						discounttotal,
						total)
			VALUES (
				'" . $OrderNo . "',
				'" . $_SESSION['Items']->DebtorNo . "',
				'" . $_SESSION['Items']->Branch . "',
				'". DB_escape_string($_SESSION['Items']->Subject) ."',
				'". DB_escape_string($_SESSION['Items']->Comments) ."',
				'" . Date("Y-m-d H:i") . "',
				'" . $_SESSION['Items']->DefaultSalesType . "',
				" . $_POST['ShipVia'] .",
				'" . DB_escape_string($_SESSION['Items']->DeliverTo) . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd1) . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd2) . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd3) . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd4) . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd5) . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd6) . "',
				'" . DB_escape_string($_SESSION['Items']->PhoneNo) . "',
				'" . DB_escape_string($_SESSION['Items']->Email) . "',
				" . $_SESSION['Items']->FreightCost .",
				" . $_SESSION['Items']->FreightTax .",
				'" . $_SESSION['Items']->Location ."',
				'" . $DelDate . "',
				'" . $DelDate . "',
				" . $_SESSION['Items']->Quotation . ",
				" . $_SESSION['Items']->DeliverBlind .",
				" . $_SESSION['Items']->AccountId .",
				" . $crm_id .",
						'Created',
						'". DB_escape_string($_SESSION['Items']->Subject) ."',
				'',
						" . $_SESSION['Items']->total . ",
				" . $TaxTotal . ",
				" . $DiscountTotal2 . ",
				" . $GrandTotal . "
                )";

	$ErrMsg = _('The order cannot be added because');
	$InsertQryResult = DB_query($HeaderSQL,$db,$ErrMsg);

	$Header10SQL = "UDPATE crmentity (
				description)
			VALUES (
				'" . DB_escape_string($_SESSION['Items']->Conditions) . "') 
				WHERE crmid=" . $crm_id;

	$ErrMsg = _('The order cannot be added because');
	$InsertQry10Result = DB_query($Header10SQL,$db,$ErrMsg);

$Header2SQL = "INSERT INTO sobillads (
				sobilladdressid	,
				bill_street,
				bill_street2,
				bill_city,
				bill_state,
				bill_code,
				bill_country)
			VALUES (
				'" . $crm_id . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd1) . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd2) . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd3) . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd4) . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd5) . "',
				'" . DB_escape_string($_SESSION['Items']->DelAdd6) . "'
                )";

	$ErrMsg = _('The order cannot be added because');
	$InsertQryResult = DB_query($Header2SQL,$db,$ErrMsg);

	/* SALEORDERID AND CRMENTITY */
	//prnMsg(_('Tax Total Amount ') . ' ' . $TaxTotal . ' ' . _('has been entered'),'success');







		
	if ($_SESSION['Items']->Quotation==1){
		prnMsg(_('Quotation Number') . ' ' . $OrderNo . ' ' . _('has been entered'),'success');
	} else {
		prnMsg(_('Order Number') . ' ' . $OrderNo . ' ' . _('has been entered'),'success');
	}
	
	if (count($_SESSION['AllowedPageSecurityTokens'])>1){
		/* Only allow print of packing slip for internal staff - customer logon's cannot go here */
		
		if ($_POST['Quotation']==0) { /*then its not a quotation its a real order */
		
			echo "<P><A  target='_blank' HREF='$rootpath/PrintCustOrder.php?" . SID . '&TransNo=' . $OrderNo . "'>". _('Print packing slip') . ' (' . _('Preprinted stationery') . ')' .'</A>';
			echo "<P><A  target='_blank' HREF='$rootpath/PrintCustOrder_generic.php?" . SID . '&TransNo=' . $OrderNo . "'>". _('Print packing slip') . ' (' . _('Laser') . ')' .'</A>';

			echo "<P><A HREF='$rootpath/ConfirmDispatch_Invoice.php?" . SID . "&OrderNumber=$OrderNo'>". _('Confirm Order Delivery Quantities and Produce Invoice') ."</A>";
			
		} else {
			/*link to print the quotation */
			echo "<P><A HREF='$rootpath/PDFQuotation.php?" . SID . "&QuotationNo=$OrderNo'>". _('Print Quotation') ."</A>";
			
		}
		echo "<P><A HREF='$rootpath/SelectOrderItems.php?" . SID . "&NewOrder=Yes'>". _('New Order') .'</A>';
	} else {
		/*its a customer logon so thank them */
		prnMsg(_('Thank you for your business'),'success');
	}

	unset($_SESSION['Items']->LineItems);
	unset($_SESSION['Items']);
	include('includes/footer.inc');
	exit;

} elseif ($OK_to_PROCESS == 1 && $_SESSION['ExistingOrder']!=0){
$accountid = GetAccountID($_SESSION['ExistingOrder']);

foreach ($_SESSION['Items']->LineItems as $StockItem) {
	//prnMsg(_(' Account ID ') . ' ' . $accountid . ' ' . _(' Account ID2 ') . ' ' . $_SESSION['ExistingOrder'] . ' ' . _(' Account ID3 ') . ' ' . $_SESSION['Branch'] . ' ' . _('has been applied to item ') . ' ' . $StockItem->StockID ,'success');

		$ItemTax = GetItemTax ($accountid,$StockItem->StockID,$_SESSION['Items']->Location);
	
	
		$product_id = getProductID($StockItem->StockID);
		If (($StockItem->DiscountPercent < 0.0001) || ($StockItem->DiscountPercent == ''))
	{$StockItem->DiscountPercent = 0 ;}
	$ItemTaxTotal = ($StockItem->Price * $StockItem->Quantity - ($StockItem->Price * $StockItem->Quantity * $StockItem->DiscountPercent)) * $ItemTax;
		$TaxTotal = $TaxTotal + $ItemTaxTotal;
	//	prnMsg(_('Query ') . ' ' . $LineItemsSQL . ' ' . _('has been applied ') . ' ' . $StockItem->StockID ,'success');
	//	prnMsg(_('Tax Rate ') . ' ' . $ItemTax . ' ' . _('has been applied to item ') . ' ' . $StockItem->StockID ,'success');
	//	prnMsg(_('Tax Amount ') . ' ' . $ItemTaxTotal . ' ' . _('has been applied to item ') . ' ' . $StockItem->StockID ,'success');

	} /* inserted line items into sales order details */

// prnMsg(_('TaxTotal PRE ') . ' ' . $TaxTotal . ' ' . _('Gst new ') . ' ' . $_SESSION['Items']->SalesTax . ' ' . _('Gst old ') . ' ' . $_SESSION['Items']->SalesTaxOriginal,'success');

if (($_SESSION['Items']->SalesTax != '') && ($_SESSION['Items']->SalesTax != $TaxTotal))

{
	$TaxTotal = $_SESSION['Items']->SalesTax;
	
	$one = $_SESSION['Items']->SalesTax;
	$two = $_POST['Items']->SalesTax;
	// prnMsg(_('TaxTotal REVISED') . ' ' . $TaxTotal . ' ' . _('Gst new ') . ' ' . $one . ' ' . _('Gst post ') . ' ' . $two,'success');

}

		

	$GrandTotal = $_SESSION['Items']->total + $TaxTotal;
	$DiscountTotal2 = $_SESSION['Items']->discounttotal;


/* update the order header then update the old order line details and insert the new lines */

	$DelDate = FormatDateforSQL($_SESSION['Items']->DeliveryDate);

	/*
if ($_SESSION['Items']->SalesTax != $_SESSION['Items']->SalesTaxOriginal)
{$TaxTotal = $_SESSION['Items']->SalesTax;
}

$one = $_SESSION['Items']->SalesTax;
$two = $_SESSION['Items']->SalesTaxOriginal;
prnMsg(_('GST new ') . ' ' . $one . ' ' . _('Gst old ') . ' ' . $two,'success');
*/

$three = $_SESSION['Items']->FreightCost;
$four = $_SESSION['Items']->FreightCostOriginal;
// prnMsg(_('Freight new ') . ' ' . $three . ' ' . _('Freight old ') . ' ' . $four,'success');

if(($TaxTotal == '') || (!isset($TaxTotal)))
{$TaxTotal = 0;}
if(($_SESSION['Items']->FreightTax == '') || (!isset($_SESSION['Items']->FreightTax)))
{$_SESSION['Items']->FreightTax = 0;}

//	prnMsg(_('Subject  ') . ' ' . $_SESSION['Items']->Subject . ' ' . _('Session CustRef ') . ' ' . $_SESSION['Items']->CustRef,'success');
	if ((!isset($_SESSION['Items']->CustRef)) || ($_SESSION['Items']->CustRef == ''))
	{ 
	$_SESSION['Items']->CustRef = $_SESSION['Items']->Subject;
	}
	
// prnMsg(_('Subject  ') . ' ' . $_SESSION['Items']->Subject . ' ' . _('Session CustRef ') . ' ' . $_SESSION['Items']->CustRef,'success');

	$Result = DB_query('BEGIN',$db);

	$HeaderSQL = "UPDATE salesorders
			SET debtorno = '" . $_SESSION['Items']->DebtorNo . "',
				branchcode = '" . $_SESSION['Items']->Branch . "',
				customerref = '". DB_escape_string($_SESSION['Items']->Subject) ."',
				subject = '". DB_escape_string($_SESSION['Items']->Subject) ."',
				comments = '". DB_escape_string($_SESSION['Items']->Comments) ."',
				ordertype = '" . $_SESSION['Items']->DefaultSalesType . "',
				shipvia = " . $_POST['ShipVia'] .",
				deliverto = '" . $_SESSION['Items']->DeliverTo . "',
				deladd1 = '" . DB_escape_string($_SESSION['Items']->DelAdd1) . "',
				deladd2 = '" . DB_escape_string($_SESSION['Items']->DelAdd2) . "',
				deladd3 = '" . DB_escape_string($_SESSION['Items']->DelAdd3) . "',
				deladd4 = '" . DB_escape_string($_SESSION['Items']->DelAdd4) . "',
				deladd5 = '" . DB_escape_string($_SESSION['Items']->DelAdd5) . "',
				deladd6 = '" . DB_escape_string($_SESSION['Items']->DelAdd6) . "',
				contactphone = '" . DB_escape_string($_SESSION['Items']->PhoneNo) . "',
				contactemail = '" . DB_escape_string($_SESSION['Items']->Email) . "',
				freightcost = " . $_SESSION['Items']->FreightCost .",
				freighttax = " . $_SESSION['Items']->FreightTax .",
				fromstkloc = '" . $_SESSION['Items']->Location ."',
				duedate = '" . $DelDate . "',
				deliverydate = '" . $DelDate . "',
				printedpackingslip = " . $_POST['ReprintPackingSlip'] . ",
				quotation = " . $_SESSION['Items']->Quotation . ",
				deliverblind = " . $_SESSION['Items']->DeliverBlind . ",
				subtotal = " . $_SESSION['Items']->total . ",
				salestax = " . $TaxTotal . ",
				discounttotal = " . $DiscountTotal2 . ",
				total = " . $GrandTotal . "
			WHERE salesorders.orderno=" . $_SESSION['ExistingOrder'];


	$DbgMsg = _('The SQL that was used to update the order and failed was');
	$ErrMsg = _('The order cannot be updated because');
	$InsertQryResult = DB_query($HeaderSQL,$db,$ErrMsg,$DbgMsg,true);

$Header11SQL = "UPDATE crmentity
			SET description = '". DB_escape_string($_SESSION['Items']->Conditions) ."' 
				WHERE crmid = " . $_SESSION['Items']->SalesOrderId;


	$DbgMsg = _('The SQL that was used to update the order and failed was');
	$ErrMsg = _('The order cannot be updated because');
	$InsertQry11Result = DB_query($Header11SQL,$db,$ErrMsg,$DbgMsg,true);


	foreach ($_SESSION['Items']->LineItems as $StockItem) {

		/* Check to see if the quantity reduced to the same quantity
		as already invoiced - so should set the line to completed */
		if ($StockItem->Quantity == $StockItem->QtyInv){
			$Completed = 1;
		} else {  /* order line is not complete */
			$Completed = 0;
		}
	$product_id = getProductID($StockItem->StockID);
	$salesorderid = getSalesOrderId($_SESSION['ExistingOrder']);
		
		$LineItemsSQL = "UPDATE salesorderdetails SET unitprice="  . $StockItem->Price . ', 
								quantity=' . $StockItem->Quantity . ', 
								discountpercent=' . floatval($StockItem->DiscountPercent) . ', 
								completed=' . $Completed . ', 
								productid = ' . $product_id . ', 
								salesorderid = ' . $salesorderid . '
					WHERE salesorderdetails.orderno=' . $_SESSION['ExistingOrder'] . " 
					AND salesorderdetails.orderlineno='" . $StockItem->LineNumber . "'";

		$ErrMsg = _('The updated order line cannot be modified because');
		$Upd_LineItemResult = DB_query($LineItemsSQL,$db,$ErrMsg,$DbgMsg,true);
//prnMsg(_('Product Id ') .' ' . $product_id . ' ' . _('has been updated'),'success');
//prnMsg(_('Order update ') .' ' . $LineItemsSQL . ' ' . _('has been updated'),'success');
//prnMsg(_('Order update ') .' ' . $StockItem->DiscountPercent . ' ' . _('has been updated'),'success');
	
	} /* updated line items into sales order details */

	$Result=DB_query('COMMIT',$db);

	unset($_SESSION['Items']->LineItems);
	unset($_SESSION['Items']);

	prnMsg(_('Order number') .' ' . $_SESSION['ExistingOrder'] . ' ' . _('has been updated'),'success');
	
	echo "<BR><A HREF='$rootpath/PrintCustOrder.php?" . SID . '&TransNo=' . $_SESSION['ExistingOrder'] . "'>". _('Print packing slip - pre-printed stationery') .'</A>';
	echo "<BR><A  target='_blank' HREF='$rootpath/PrintCustOrder_generic.php?" . SID . '&TransNo=' . $_SESSION['ExistingOrder'] . "'>". _('Print packing slip') . ' (' . _('Laser') . ')' .'</A>';
	echo "<P><A HREF='$rootpath/SelectSalesOrder.php?" . SID  . "'>". _('Select A Different Order') .'</A>';
	include('includes/footer.inc');
	exit;
}


echo '<CENTER><FONT SIZE=4><B>'. _('Customer') .' : ' . $_SESSION['Items']->CustomerName . '</B></FONT></CENTER>';
echo "<FORM ACTION='" . $_SERVER['PHP_SELF'] . '?' . $SID . "' METHOD=POST>";


/*Display the order with or without discount depending on access level*/
if (in_array(2,$_SESSION['AllowedPageSecurityTokens'])){

	echo '<CENTER><B>';
	
	if ($_SESSION['Items']->Quotation==1){
		echo _('Quotation Summary');
	} else {
		echo _('Order Summary');
	}
	echo "</B>
	<TABLE CELLPADDING=2 COLSPAN=7 BORDER=1>
	<TR>
		<TD class='tableheader'>". _('Item Code') ."</TD>
		<TD class='tableheader'>". _('Item Description') ."</TD>
		<TD class='tableheader'>". _('Quantity') ."</TD>
		<TD class='tableheader'>". _('Unit') ."</TD>
		<TD class='tableheader'>". _('Price') ."</TD>
		<TD class='tableheader'>". _('Discount') ." %</TD>
		<TD class='tableheader'>". _('Total') ."</TD>
	</TR>";

	$_SESSION['Items']->total = 0;
	$_SESSION['Items']->discounttotal = 0;
	$_SESSION['Items']->totalVolume = 0;
	$_SESSION['Items']->totalWeight = 0;
	$k = 0; //row colour counter

	foreach ($_SESSION['Items']->LineItems as $StockItem) {

		$LineTotal = $StockItem->Quantity * $StockItem->Price * (1 - $StockItem->DiscountPercent);
		$DisplayLineTotal = number_format($LineTotal,2);
		$DisplayPrice = number_format($StockItem->Price,2);
		$DisplayQuantity = number_format($StockItem->Quantity,$StockItem->DecimalPlaces);
		$DisplayDiscount = number_format(($StockItem->DiscountPercent * 100),2);


		if ($k==1){
			echo "<tr bgcolor='#CCCCCC'>";
			$k=0;
		} else {
			echo "<tr bgcolor='#EEEEEE'>";
			$k=1;
		}

		 echo "<TD>$StockItem->StockID</TD>
		 	<TD>$StockItem->ItemDescription</TD>
			<TD ALIGN=RIGHT>$DisplayQuantity</TD>
			<TD>$StockItem->Units</TD>
			<TD ALIGN=RIGHT>$DisplayPrice</TD>
			<TD ALIGN=RIGHT>$DisplayDiscount</TD>
			<TD ALIGN=RIGHT>$DisplayLineTotal</TD>
		</TR>";

		$_SESSION['Items']->total = $_SESSION['Items']->total + $LineTotal;
		$_SESSION['Items']->totalVolume = $_SESSION['Items']->totalVolume + ($StockItem->Quantity * $StockItem->Volume);
		$_SESSION['Items']->discounttotal = $_SESSION['Items']->discounttotal + ($StockItem->Quantity * $StockItem->Price * $StockItem->DiscountPercent);
		$_SESSION['Items']->totalWeight = $_SESSION['Items']->totalWeight + ($StockItem->Quantity * $StockItem->Weight);
	}

	$DisplayTotal = number_format($_SESSION['Items']->total,2);
	$DiscountTotal = number_format($_SESSION['Items']->discounttotal,2);
	echo "<TR>
		<TD COLSPAN=6 ALIGN=RIGHT><B>". _('Discount Total') ." $DiscountTotal   ". _('TOTAL Excl Tax/Freight') ."</B></TD>
		<TD ALIGN=RIGHT>$DisplayTotal</TD>
	</TR></TABLE>";

	$DisplayVolume = number_format($_SESSION['Items']->totalVolume,2);
	$DisplayWeight = number_format($_SESSION['Items']->totalWeight,2);
	echo "<TABLE BORDER=1><TR>
		<TD>". _('Total Weight') .":</TD>
		<TD>$DisplayWeight</TD>
		<TD>". _('Total Volume') .":</TD>
		<TD>$DisplayVolume</TD>
	</TR></TABLE>";

} else {

/*Display the order without discount */

	echo '<CENTER><B>' . _('Order Summary') . "</B>
	<TABLE CELLPADDING=2 COLSPAN=7 BORDER=1><TR>
		<TD class='tableheader'>". _('Item Description') ."</TD>
		<TD class='tableheader'>". _('Quantity') ."</TD>
		<TD class='tableheader'>". _('Unit') ."</TD>
		<TD class='tableheader'>". _('Price') ."</TD>
		<TD class='tableheader'>". _('Total') ."</TD>
	</TR>";

	$_SESSION['Items']->total = 0;
	$_SESSION['Items']->totalVolume = 0;
	$_SESSION['Items']->totalWeight = 0;
	$k=0; // row colour counter
	foreach ($_SESSION['Items']->LineItems as $StockItem) {

		$LineTotal = $StockItem->Quantity * $StockItem->Price * (1 - $StockItem->DiscountPercent);
		$DisplayLineTotal = number_format($LineTotal,2);
		$DisplayPrice = number_format($StockItem->Price,2);
		$DisplayQuantity = number_format($StockItem->Quantity,$StockItem->DecimalPlaces);

		if ($k==1){
			echo "<tr bgcolor='#CCCCCC'>";
			$k=0;
		} else {
			echo "<tr bgcolor='#EEEEEE'>";
			$k=1;
		}
		echo "<TD>$StockItem->ItemDescription</TD>
			<TD ALIGN=RIGHT>$DisplayQuantity</TD>
			<TD>$StockItem->Units</TD>
			<TD ALIGN=RIGHT>$DisplayPrice</TD>
			<TD ALIGN=RIGHT>" . $DisplayLineTotal . "</FONT></TD>
		</TR>";

		$_SESSION['Items']->total = $_SESSION['Items']->total + $LineTotal;
		$_SESSION['Items']->totalVolume = $_SESSION['Items']->totalVolume + $StockItem->Quantity * $StockItem->Volume;
		$_SESSION['Items']->totalWeight = $_SESSION['Items']->totalWeight + $StockItem->Quantity * $StockItem->Weight;

	}

	$DisplayTotal = number_format($_SESSION['Items']->total,2);
	echo "<TABLE><TR>
		<TD>". _('Total Weight') .":</TD>
		<TD>$DisplayWeight</TD>
		<TD>". _('Total Volume') .":</TD>
		<TD>$DisplayVolume</TD>
	</TR></TABLE>";

	$DisplayVolume = number_format($_SESSION['Items']->totalVolume,2);
	$DisplayWeight = number_format($_SESSION['Items']->totalWeight,2);
	echo '<TABLE BORDER=1><TR>
		<TD>'. _('Total Weight') .":</TD>
		<TD>$DisplayWeight</TD>
		<TD>". _('Total Volume') .":</TD>
		<TD>$DisplayVolume</TD>
	</TR></TABLE>";

}

echo '<TABLE><TR>
	<TD>'. _('Deliver To') .":</TD>
	<TD><input type=text size=42 max=40 name='DeliverTo' value='" . $_SESSION['Items']->DeliverTo . "'></TD>
</TR>";

echo '<TR>
	<TD>'. _('Deliver from the warehouse at') .":</TD>
	<TD><Select name='Location'>";

if ($_SESSION['Items']->Location=='' OR !isset($_SESSION['Items']->Location)) {
	$_SESSION['Items']->Location = $DefaultStockLocation;
}

$StkLocsResult = DB_query('SELECT locationname,loccode FROM locations',$db);
while ($myrow=DB_fetch_row($StkLocsResult)){
	if ($_SESSION['Items']->Location==$myrow[1]){
		echo "<OPTION SELECTED Value='$myrow[1]'>$myrow[0]";
	} else {
		echo "<OPTION Value='$myrow[1]'>$myrow[0]";
	}
}

echo '</SELECT></TD></TR>';


if (!$_SESSION['Items']->DeliveryDate) {
	$_SESSION['Items']->DeliveryDate = Date($_SESSION['DefaultDateFormat'],$EarliestDispatch);
}

if ((isset($_SESSION['Items']->SalesOrderId)) || ($_SESSION['Items']->SalesOrderId>0))
{
$sql2='SELECT description FROM crmentity where crmid=' . $_SESSION['Items']->SalesOrderId;
$TResult = DB_query($sql2,$db);
$my2row=DB_fetch_row($TResult);
$description=$my2row[0];
}
echo '<TR>
	<TD>'. _('Dispatch Date') .":</TD>
	<TD><input type='Text' SIZE=15 MAXLENGTH=14 name='DeliveryDate' value=" . $_SESSION['Items']->DeliveryDate . "></TD>
</TR>";

echo '<TR>
	<TD>'. _('Delivery Address 1') . ":</TD>
	<TD><input type=text size=42 max=40 name='BrAdd1' value='" . $_SESSION['Items']->DelAdd1 . "'></TD>
</TR>";

echo "<TR>
	<TD>". _('Delivery Address 2') . ":</TD>
	<TD><input type=text size=42 max=40 name='BrAdd2' value='" . $_SESSION['Items']->DelAdd2 . "'></TD>
</TR>";

echo '<TR>
	<TD>'. _('Delivery Address 3') . ":</TD>
	<TD><input type=text size=42 max=40 name='BrAdd3' value='" . $_SESSION['Items']->DelAdd3 . "'></TD>
</TR>";

echo "<TR>
	<TD>". _('Delivery Address 4') . ":</TD>
	<TD><input type=text size=42 max=40 name='BrAdd4' value='" . $_SESSION['Items']->DelAdd4 . "'></TD>
</TR>";

echo "<TR>
	<TD>". _('Delivery Address 5') . ":</TD>
	<TD><input type=text size=22 max=20 name='BrAdd5' value='" . $_SESSION['Items']->DelAdd5 . "'></TD>
</TR>";

echo "<TR>
	<TD>". _('Delivery Address 6') . ":</TD>
	<TD><input type=text size=17 max=15 name='BrAdd6' value='" . $_SESSION['Items']->DelAdd6 . "'></TD>
</TR>";

echo '<TR>
	<TD>'. _('Contact Phone Number') .":</TD>
	<TD><input type=text size=25 max=25 name='PhoneNo' value='" . $_SESSION['Items']->PhoneNo . "'></TD>
</TR>";

echo '<TR><TD>' . _('Contact Email') . ":</TD><TD><input type=text size=40 max=38 name='Email' value='" . $_SESSION['Items']->Email . "'></TD></TR>";

echo '<TR><TD>'. _('Customer Reference') .":</TD>
	<TD><input type=text size=25 max=25 name='Subject' value='" . $_SESSION['Items']->Subject . "'></TD>
</TR>";

echo '<TR>
	<TD>'. _('External Terms and Conditions') .":</TD>
	<TD><TEXTAREA NAME=Comments COLS=31 ROWS=5>" . $_SESSION['Items']->Comments ."</TEXTAREA></TD>
</TR>";

echo '<TR>
	<TD>'. _('Internal Comments') .":</TD>
	<TD><TEXTAREA NAME=Conditions COLS=31 ROWS=5>" . $description ."</TEXTAREA></TD>
</TR>";

	/* This field will control whether or not to display the company logo and
    address on the packlist */

	echo '<TR><TD>' . _('Packlist Type') . ":</TD><TD><SELECT NAME='DeliverBlind'>";
        for ($p = 1; $p <= 2; $p++) {
            echo '<OPTION VALUE=' . $p;
            if ($p == $_SESSION['Items']->DeliverBlind) {
                echo ' SELECTED>';
            } else {
                echo '>';
            }
            switch ($p) {
                case 2:
                    echo _('Hide Company Details/Logo'); 
		    break;
                default:
                    echo _('Show Company Details/Logo');
		    break;
            }
        }
    echo '</SELECT></TD></TR>';
    
if ($_SESSION['PrintedPackingSlip']==1){

    echo '<TR>
    	<TD>'. _('Reprint packing slip') .":</TD>
	<TD><SELECT name='ReprintPackingSlip'>";
    echo '<OPTION Value=0>' . _('Yes');
    echo '<OPTION SELECTED Value=1>' . _('No');
    echo '</SELECT>	'. _('Last printed') .': ' . ConvertSQLDate($_SESSION['DatePackingSlipPrinted']) . '</TD></TR>';

} else {

    echo "<INPUT TYPE=hidden name='ReprintPackingSlip' value=0>";

}

echo '<TR><TD>'. _('Freight Charge') .':</TD>';
echo "<TD><INPUT TYPE=TEXT SIZE=10 MAXLENGTH=12 NAME='FreightCost' VALUE=" . $_SESSION['Items']->FreightCost . '></TD>';

if ($_SESSION['DoFreightCalc']==True){
	echo "<TD><INPUT TYPE=SUBMIT NAME='Update' VALUE='" . _('Recalc Freight Cost') . "'></TD></TR>";
}

echo '<TR><TD>'. _('Freight Tax') .':</TD>';
echo "<TD><INPUT TYPE=TEXT SIZE=10 MAXLENGTH=12 NAME='FreightTax' VALUE=" . $_SESSION['Items']->FreightTax . '></TD>';

if ($_SESSION['DoFreightCalc']==True){
	echo "<TD><INPUT TYPE=SUBMIT NAME='Update' VALUE='" . _('Recalc Freight Cost') . "'></TD></TR>";
}

echo '<TR><TD>'. _('GST Charged') .':</TD>';
echo "<TD><INPUT TYPE=TEXT SIZE=10 MAXLENGTH=12 NAME='SalesTax' VALUE=" . $_SESSION['Items']->SalesTax . '></TD>';

if ($_SESSION['DoFreightCalc']==True){
	echo "<TD></TD></TR>";
}

if ((!isset($_POST['ShipVia']) OR $_POST['ShipVia']=='') AND isset($_SESSION['Items']->ShipVia)){
	$_POST['ShipVia'] = $_SESSION['Items']->ShipVia;
}

echo '<TR><TD>'. _('Freight Company') .":</TD><TD><SELECT name='ShipVia'>";
$SQL = 'SELECT shipper_id, shippername FROM shippers';
$ShipperResults = DB_query($SQL,$db);
while ($myrow=DB_fetch_array($ShipperResults)){
	if ($myrow['shipper_id']==$_POST['ShipVia']){
			echo '<OPTION SELECTED VALUE=' . $myrow['shipper_id'] . '>' . $myrow['shippername'];
	}else {
		echo '<OPTION VALUE=' . $myrow['shipper_id'] . '>' . $myrow['shippername'];
	}
}

echo '</SELECT></TD></TR>';


echo '<TR><TD>'. _('Quotation Only') .":</TD><TD><SELECT name='Quotation'>";
if ($_SESSION['Items']->Quotation==1){
	echo "<OPTION SELECTED VALUE=1>" . _('Yes');
	echo "<OPTION VALUE=0>" . _('No');
} else {
	echo "<OPTION VALUE=1>" . _('Yes');
	echo "<OPTION SELECTED VALUE=0>" . _('No');
}
echo '</SELECT></TD></TR>';


echo '</TABLE></CENTER>';

echo "<BR><CENTER><INPUT TYPE=SUBMIT NAME='BackToLineDetails' VALUE='" . _('Modify Order Lines') . "'>";

if ($_SESSION['ExistingOrder']==0){
	echo "<BR><INPUT TYPE=SUBMIT NAME='ProcessOrder' VALUE='" . _('Place Order') . "'>";
	echo "<BR><BR><BR><INPUT TYPE=SUBMIT NAME='MakeRecurringOrder' VALUE='" . _('Create Reccurring Order') . "'>";
} else {
	echo "<BR><INPUT TYPE=SUBMIT NAME='ProcessOrder' VALUE='" . _('Commit Order Changes') . "'>";
}

echo '</FORM>';
include('includes/footer.inc');


Function GetUniqueID (&$db){

/*Gets the Product ID for VTiger */
	$result = mysql_query('SELECT soid FROM so_seq');
if (!$result) {
   die('Could not query:' . mysql_error());
}
$temp_id = mysql_result($result, 0); // outputs current crmid

$OrderNoStart = $temp_id + 1;

$sql = "update so_seq set soid = ".$OrderNoStart."";
					
					$ErrMsg =  _('SO Sequence failed') . ' ' . $myrow[0] .  ' ' . _('could not be added');
					$DbgMsg = _('SO Sequence failed') . '   ' . _('The SQL that was used to add the SO Sequence');
					$CRMseqResult = DB_query($sql,$db,$ErrMsg,$DbgMsg);



return $OrderNoStart;
}


Function GetCrmID (&$db){

/*Gets the Product ID for VTiger */
	$result = mysql_query('SELECT id FROM crmentity_seq');
if (!$result) {
   die('Could not query:' . mysql_error());
}
$temp_id = mysql_result($result, 0); // outputs current crmid
$crm_id = $temp_id + 1;


return $crm_id;
}

Function GetProductID ($stockid){

/*Gets the Product ID for VTiger */
	$Aresult = mysql_query('SELECT productid FROM stockmaster WHERE stockid = "'.$stockid.'" ');
if (!$Aresult) {
   die('Could not query:' . mysql_error());
}

$product_id = mysql_result($Aresult, 0); // outputs current crmid



return $product_id;
}
Function GetAccountID ($orderno){

/*Gets the Product ID for VTiger */
	$Xresult = mysql_query('SELECT accountid FROM salesorders WHERE orderno = "'.$orderno.'" ');
if (!$Xresult) {
   die('Could not query:' . mysql_error());
}

$accountid = mysql_result($Xresult, 0); // outputs current crmid



return $accountid;
}

Function GetSalesOrderId ($orderno){

/*Gets the Product ID for VTiger */
	$Cresult = mysql_query('SELECT salesorderid FROM salesorders WHERE orderno = "'.$orderno.'" ');
if (!$Cresult) {
   die('Could not query:' . mysql_error());
}

$salesorderid = mysql_result($Cresult, 0); // outputs current crmid



return $salesorderid;
}



Function GetItemTax($accountid,$stockid,$loccode)
{
			$Aresult = mysql_query('SELECT taxgroupid FROM custbranch WHERE accountid = "'.$accountid.'" ');
		//prnMsg(_('Query ') . ' ' . $Aresult . ' ' . _('has been applied ') . ' ' . $accountid ,'success');
		//prnMsg(_('Query variables accountid ') . ' ' . $accountid . ' ' . _('Aresult ') . ' ' . $Aresult ,'warning');
		if (!$Aresult) {
		   die('Could not query:' . mysql_error());
		   
		}
		
		$taxgroupid = mysql_result($Aresult, 0); // outputs current crmid
		//prnMsg(_('Query variables taxgroupid ') . ' ' . $taxgroupid ,'warning');
		$Bresult = mysql_query('SELECT taxcatid FROM stockmaster WHERE stockid = "'.$stockid.'" ');
		  // prnMsg(_('Query ') . ' ' . $Bresult . ' ' . _('has been applied ') . ' ' . $stockid ,'success');
		if (!$Bresult) {
		die('Could not query:' . mysql_error());
		}
		
		$taxcatid = mysql_result($Bresult, 0); // outputs current crmid
		
		$Cresult = mysql_query('SELECT taxprovinceid FROM locations WHERE loccode = "'.$loccode.'" ');
		if (!$Cresult) {
		   die('Could not query:' . mysql_error());
		}
		
		$dispatchprovince = mysql_result($Cresult, 0); // outputs current crmid
		//prnMsg(_('Query variables taxgroupid ') . ' ' . $taxgroupid . ' ' . _('taxcatid ') . ' ' . $taxcatid . ' ' . _(' dispatchprovince ') . ' ' . $dispatchprovince ,'warning');
		
$Dresult = mysql_query('SELECT taxgrouptaxes.calculationorder,
							taxauthorities.description,
							taxgrouptaxes.taxauthid,
							taxauthorities.taxglcode,
							taxgrouptaxes.taxontax,
							taxauthrates.taxrate
					FROM taxauthrates INNER JOIN taxgrouptaxes ON
						taxauthrates.taxauthority=taxgrouptaxes.taxauthid
						INNER JOIN taxauthorities ON
						taxauthrates.taxauthority=taxauthorities.taxid
					WHERE taxgrouptaxes.taxgroupid=' . $taxgroupid . ' 
					AND taxauthrates.dispatchtaxprovince=' . $dispatchprovince . ' 
					AND taxauthrates.taxcatid = ' . $taxcatid . '
					ORDER BY taxgrouptaxes.calculationorder');
					
		if (!$Dresult) {
		   die('Could not query:' . mysql_error());
		}
		
$taxrate1 = mysql_result($Dresult,0,"taxrate");
$taxrate2 = mysql_result($Dresult,1,"taxrate");
$taxontax1 = mysql_result($Dresult,0,"taxontax");
$taxontax2 = mysql_result($Dresult,1,"taxontax");

	
				
		if ($taxontax1 == 1 && $taxontax2 == 1)
			{ $ItemTax=1*$taxrate1+1*$taxrate2-1; }	
		elseif ($taxontax1 == 1 && $taxontax2 == 0)
			{ $ItemTax=1*$taxrate2+1*$taxrate1-1; }	
		elseif ($taxontax1 == 0 && $taxontax2 == 1)
			{ $ItemTax=(1+$taxrate1)*(1+$taxrate2)-1; }	
		else
			{ $ItemTax=$taxrate1+$taxrate2; }	
			
			return $ItemTax;
}


?>