<?php

/* $Revision: 1.14 $ */

$PageSecurity = 2;

include('includes/session.inc');
include('includes/SQL_CommonFunctions.inc');

//Get Out if we have no order number to work with
If (!isset($_GET['TransNo']) OR $_GET['TransNo']==""){
        $title = _('Select Order To Print');
        include('includes/header.inc');
        echo '<div align=center><br><br><br>';
        prnMsg( _('Select an Order Number to Print before calling this page') , 'error');
        echo '<BR><BR><BR><table class="table_index"><tr><td class="menu_group_item">
                <li><a href="'. $rootpath . '/SelectSalesOrder.php?'. SID .'">' . _('Outstanding Sales Orders') . '</a></li>
                <li><a href="'. $rootpath . '/SelectCompletedOrder.php?'. SID .'">' . _('Completed Sales Orders') . '</a></li>
                </td></tr></table></DIV><BR><BR><BR>';
        include('includes/footer.inc');
        exit();
}

/*retrieve the order details from the database to print */
$ErrMsg = _('There was a problem retrieving the order header details for Order Number') . ' SO' . $_GET['TransNo'] . ' ' . _('from the database');

$sql = "SELECT salesorders.debtorno,
    		salesorders.customerref,
		salesorders.subject,
		salesorders.comments,
		salesorders.orddate,
		salesorders.duedate,
		salesorders.deliverto,
		salesorders.deladd1 as custdeladd1,
		salesorders.deladd2 as custdeladd2,
		salesorders.deladd3 as custdeladd3,
		salesorders.deladd4 as custdeladd4,
		salesorders.deladd5 as custdeladd5,
		salesorders.deladd6 as custdeladd6,
		salesorders.deliverblind,
		salesorders.accountid,
		custbranch.braddress1,
		custbranch.braddress2,
		custbranch.braddress3,
		custbranch.braddress4,
		custbranch.braddress5,
		custbranch.braddress6,
		custbranch.brname,
		custbranch.contactname,
		custbranch.phoneno,
		custbranch.email as email2,
		debtorsmaster.name,
		debtorsmaster.address1,
		debtorsmaster.address2,
		debtorsmaster.address3,
		debtorsmaster.address4,
		debtorsmaster.address5,
		debtorsmaster.address6,
		shippers.shippername,
		shippers.shipper_id,
		salesorders.printedpackingslip,
		salesorders.datepackingslipprinted,
		locations.locationname,
		locations.deladd1,
		locations.deladd2,
		locations.deladd3,
		locations.deladd4,
		locations.deladd5,
		locations.deladd6,
		locations.contact,
		locations.email,
		locations.tel  
	FROM salesorders,
		debtorsmaster,
		custbranch,
		shippers,
		locations
	WHERE salesorders.debtorno=debtorsmaster.debtorno
	AND salesorders.accountid=custbranch.accountid
	AND salesorders.shipvia=shippers.shipper_id
	AND salesorders.fromstkloc=locations.loccode
	AND salesorders.orderno=" . $_GET['TransNo'];

$result=DB_query($sql,$db, $ErrMsg);

//If there are no rows, there's a problem.
if (DB_num_rows($result)==0){
        $title = _('Print Packing Slip Error');
        include('includes/header.inc');
         echo '<div align=center><br><br><br>';
        prnMsg( _('Unable to Locate Order Number') . ' : SO' . $_GET['TransNo'] . ' ', 'error');
        echo '<BR><BR><BR><table class="table_index"><tr><td class="menu_group_item">
                <li><a href="'. $rootpath . '/SelectSalesOrder.php?'. SID .'">' . _('Outstanding Sales Orders') . '</a></li>
                <li><a href="'. $rootpath . '/SelectCompletedOrder.php?'. SID .'">' . _('Completed Sales Orders') . '</a></li>
                </td></tr></table></DIV><BR><BR><BR>';
        include('includes/footer.inc');
        exit();
} elseif (DB_num_rows($result)==1){ /*There is only one order header returned - thats good! */

        $myrow = DB_fetch_array($result);
        /* Place the deliver blind variable into a hold variable to used when
        producing the packlist */
        $Ship = $myrow['shipper_id'];
        $DeliverBlind = $myrow['deliverblind'];
        if ($myrow['printedpackingslip']==1 AND ($_GET['Reprint']!='OK' OR !isset($_GET['Reprint']))){
                $title = _('Print Packing Slip Error');
                include('includes/header.inc');
                echo '<P>';
                prnMsg( _('The packing slip for order number') . ' SO' . $_GET['TransNo'] . ' ' .
                        _('has previously been printed') . '. ' . _('It was printed on'). ' ' . ConvertSQLDate($myrow['datepackingslipprinted']) .
                        '<br>' . _('This check is there to ensure that duplicate packing slips are not produced and dispatched more than once to the customer'), 'warn' );
              echo '<P><A HREF="' . $rootpath. '/PrintCustOrder_generic.php?' . SID . '&TransNo=' . $_GET['TransNo'] . '&Reprint=OK">'. _('Do a Re-Print') . ' (' . _('Plain paper') . ' - ' . _('Letter') . ' ' . _('portrait') . ') ' . _('Even Though Previously Printed'). '</A>';
                echo '<BR><BR><BR>';
                echo  _('Or select another Order Number to Print');
                echo '<table class="table_index"><tr><td class="menu_group_item">
                        <li><a href="'. $rootpath . '/SelectSalesOrder.php?'. SID .'">' . _('Outstanding Sales Orders') . '</a></li>
                        <li><a href="'. $rootpath . '/SelectCompletedOrder.php?'. SID .'">' . _('Completed Sales Orders') . '</a></li>
                        </td></tr></table></DIV><BR><BR><BR>';




                include('includes/footer.inc');
                exit;
        }//packing slip has been printed.
}

/*retrieve the order details from the database to print */

/* Then there's an order to print and its not been printed already (or its been flagged for reprinting/ge_Width=807;
)
LETS GO */
$PaperSize = 'letter';
include('includes/PDFStarter.php');

$FontSize=11;
$pdf->selectFont('./fonts/Helvetica.afm');
$pdf->addinfo('Title', _('Customer Laser Packing Slip') );
$pdf->addinfo('Subject', _('Laser Packing slip for order') . ' ' . $_GET['TransNo']);

//for ($i=1;$i<=2;$i++){  /*Print it out twice one copy for customer and one for office */
//	if ($i==2){
//		$pdf->newPage();
//	}

	$line_height=20;

	/* Now ... Has the order got any line items still outstanding to be invoiced */
	$packlisttext=$_GET['packlisttext'];
	$packlisttext1=$_POST['packlisttext'];
	$packlisttext2=$_REQUEST['packlisttext'];
	$packlisttextA=$_GET['packlisttext1'];
	$packlisttext1A=$_POST['packlisttext1'];
	$packlisttext2A=$_REQUEST['packlisttext1'];
	$PageNumber = 1;
	$TotalWeight=0;
	$TotalVolume=0;
	$TotalPieces=0;
	$ErrMsg = _('There was a problem retrieving the order header details for Order Number') . ' SO' .
		$_GET['TransNo'] . ' ' . _('from the database');

	$sql = "SELECT salesorderdetails.stkcode, 
			stockmaster.description, 
			stockmaster.kgs, 
			stockmaster.volume, 
			salesorderdetails.quantity, 
			salesorderdetails.qtyinvoiced, 
			salesorderdetails.unitprice,
			salesorderdetails.narrative
		FROM salesorderdetails INNER JOIN stockmaster
			ON salesorderdetails.stkcode=stockmaster.stockid
		WHERE salesorderdetails.orderno=" . $_GET['TransNo'];
	$result=DB_query($sql,$db, $ErrMsg);

	$sql3 = "SELECT salesorderdetails.stkcode, 
			stockmaster.description, 
			stockmaster.kgs, 
			stockmaster.volume, 
			salesorderdetails.quantity, 
			salesorderdetails.qtyinvoiced, 
			salesorderdetails.unitprice,
			salesorderdetails.narrative
		FROM salesorderdetails INNER JOIN stockmaster
			ON salesorderdetails.stkcode=stockmaster.stockid
		WHERE salesorderdetails.orderno=" . $_GET['TransNo'];
	$result3=DB_query($sql3,$db, $ErrMsg);

	if (DB_num_rows($result)>0){
	
	
	
	
	
	
	
	
	
	
	
		/*Yes there are line items to start the ball rolling with a page header */
		$YP=500;
			
if (DB_num_rows($result3)>0){
	$PageNumber3=0;
	while ($myrow3=DB_fetch_array($result3)){
			//$LeftOvers = $pdf->addTextWrap(305,$YPos,85,$FontSize,$myrow3['kgs'],'right');
			if ($YP-20 <= 325){
			/* We reached the end of the page so finsih off the page and start a newy */
				$PageNumber3++;
				$YP += (20+5);
			} //end if need a new page headed up
			/*increment a line down for the next line item */
			$YP -= (20+5);
			$NP1=$PageNumber3/2;
			$NP=$NP1/2;
			$Noofpages=floor($NP);
			If ($Noofpages==0)
			{$Noofpages=1;}
		} //end while there are line items to print out
}		
include('includes/PDFOrderPageHeader_generic.inc');
				
		while ($myrow2=DB_fetch_array($result)){
			$UnitWeight = number_format($myrow2['kgs'],3);
			
			$DisplayQty = $myrow2['quantity'];
			
			//$DisplayQty = number_format($myrow2['quantity'],2);
			
			
			$DisplayPrevDel = number_format($myrow2['qtyinvoiced'],2);
			$DisplayQtySupplied = number_format($myrow2['quantity'] - $myrow2['qtyinvoiced'],2);
			$Weight1 = $UnitWeight * $DisplayQtySupplied;
			$TotalWeight += $Weight1;
			$TotalWeightP = $TotalWeight*2.20462262 ;
			$TotalWeight2 = number_format($TotalWeightP,2);
			
			$TotalPieces += $DisplayQtySupplied;
			$Weight = number_format($Weight1,3);
			$FontSize=9;
			$item=$myrow2['stkcode'] . ' - ' . $myrow2['description'];
			$LeftOvers = $pdf->addTextWrap($XPos,$YPos,225,$FontSize,$item);
			//$LeftOvers = $pdf->addTextWrap($XPos,$YPos,127,$FontSize,$myrow2['stkcode']);
			//$LeftOvers = $pdf->addTextWrap(90,$YPos,215,$FontSize,$myrow2['description']);
			$LeftOvers = $pdf->addTextWrap(228,$YPos,85,$FontSize,$DisplayQty,'right');
			//  $LeftOvers = $pdf->addTextWrap(305,$YPos,85,$FontSize,$DisplayQtySupplied,'right');
			//$LeftOvers = $pdf->addTextWrap(451,$YPos,85,$FontSize,$DisplayPrevDel,'right');
			$LeftOvers = $pdf->addTextWrap(490,$YPos,85,$FontSize,$Weight1,'right');
	$pdf->line(370,$YPos-5,370, $YPos+20);
//$pdf->line(500,$YPos-5,500, $YPos+20);
$pdf->line(321,$YPos-5,321, $YPos+20);
$pdf->line(273,$YPos-5,273, $YPos+20);
$pdf->line(544,$YPos-5,544, $YPos+20);
	$pdf->line(25,$YPos-5,585, $YPos-5);

			if ($YPos-$line_height <= 130){
			/* We reached the end of the page so finsih off the page and start a newy */
				$PageNumber++;
				include ('includes/PDFOrderPageHeader_generic.inc');
				$YPos += ($line_height+5);
			} //end if need a new page headed up
			/*increment a line down for the next line item */
			$YPos -= ($line_height+5);
			} //end while there are line items to print out
		
//$pdf->line(25,$YPos+4,750, $YPos+4);
$pdf->setFont('Helvetica', 'B', 11); 
//$packlisttext=$_GET['packlisttext'];
//	$packlisttext1="TESTING";
//	$packlisttext2=$_REQUEST['packlisttext'];
	
$FontSize =12;
$LeftOvers = $pdf->addTextWrap(400,$YPos,170,$FontSize, _('Total Weight (KG)') . ' :   ','left');
$LeftOvers = $pdf->addTextWrap(400,$YPos-15,170,$FontSize, _('Total Weight (LBS)') . ' :   ','left');
$LeftOvers = $pdf->addTextWrap(410,$YPos,170,$FontSize, $TotalWeight,'right');
$LeftOvers = $pdf->addTextWrap(410,$YPos-15,170,$FontSize,$TotalWeight2,'right');
$TotalPieces = $pdf->addTextWrap(55,$YPos,250,$FontSize, _('Piece Count (this delivery)') . ' :   ' . $TotalPieces,'right');


$LeftOvers = $pdf->addTextWrap(35,$YPos-50,410,$FontSize, $packlisttext,'left');

$LeftOvers = $pdf->addTextWrap(35,$YPos-80,410,$FontSize, $packlisttext1,'left');

$LeftOvers = $pdf->addTextWrap(35,$YPos-110,410,$FontSize, $packlisttext2,'left');

$LeftOvers = $pdf->addTextWrap(135,$YPos-50,410,$FontSize, $packlisttextA,'left');

$LeftOvers = $pdf->addTextWrap(135,$YPos-80,410,$FontSize, $packlisttext1A,'left');

$LeftOvers = $pdf->addTextWrap(135,$YPos-110,410,$FontSize, $packlisttext2A,'left');

//$packlisttext= $pdf->addTextWrap(55,$YPos-50,35,$FontSize, _('Notes') . ' :   ' . $packlisttext,'left');

//$packlisttext1= $pdf->addTextWrap(55,$YPos-80,35,$FontSize, _('Notes1') . ' :   ' . $packlisttext1,'left');

//$packlisttext2= $pdf->addTextWrap(55,$YPos-110,35,$FontSize, _('Notes2') . ' :   ' . $packlisttext2,'left');

$FontSize =10;
$LeftOvers = $pdf->addTextWrap($Xpos+15,$YPos-35,170,$FontSize, _('Signature: '),'left');
$LeftOvers = $pdf->addTextWrap($Xpos+15,$YPos-55,170,$FontSize, _('Actual Ship Date: '),'left');
$LeftOvers = $pdf->addTextWrap($Xpos+15,$YPos-75,170,$FontSize, _('Total Pallets: '),'left');
		$pdf->line($Xpos+70,$YPos-35,$Xpos+250, $YPos-35);
		$pdf->line($Xpos+105,$YPos-55,$Xpos+250, $YPos-55);
		$pdf->line($Xpos+80,$YPos-75,$Xpos+250, $YPos-75);
		

		$pdf->line(25,$YPos-80,25, $YPos-140);
		$pdf->line(130,$YPos-80,130, $YPos-140);
		$pdf->line(241,$YPos-80,241, $YPos-140);
		$pdf->line(353,$YPos-80,353, $YPos-140);
		$pdf->line(465,$YPos-80,465, $YPos-140);
		$pdf->line(585,$YPos-80,585, $YPos-140);
		

		$pdf->line(25,$YPos-80,585, $YPos-80);
		$pdf->line(25,$YPos-140,585, $YPos-140);

	} /*end if there are order details to show on the order*/

	//$Copy='Customer';

//} /*end for loop to print the whole lot twice */

$pdfcode = $pdf->output();
$len = strlen($pdfcode);
if ($len<=20){
        $title = _('Print Packing Slip Error');
        include('includes/header.inc');
        echo '<p>'. _('There were no oustanding items on the order to deliver') . '. ' . _('A dispatch note cannot be printed').
                '<BR><A HREF="' . $rootpath . '/SelectSalesOrder.php?' . SID . '">'. _('Print Another Packing Slip/Order').
                '</A>' . '<BR>'. '<A HREF="' . $rootpath . '/index.php?' . SID . '">' . _('Back to the menu') . '</A>';
        include('includes/footer.inc');
	exit;
} else {
	header('Content-type: application/pdf');
	header('Content-Length: ' . $len);
	header('Content-Disposition: inline; filename=PackingSlip.pdf');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
//echo 'here';
	$pdf->Stream();

	$sql = "UPDATE salesorders SET printedpackingslip=1, datepackingslipprinted='" . Date('Y-m-d') . "' WHERE salesorders.orderno=" .$_GET['TransNo'];
	$result = DB_query($sql,$db);
}

?>
