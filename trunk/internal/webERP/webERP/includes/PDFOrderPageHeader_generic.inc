<?php
/* $Revision: 1.12 $ */
/* pdf-php by R&OS code to set up a new sales order page */
if ($PageNumber>1){
	$pdf->newPage();
}

$XPos = $Page_Width/2 - 60;
/* if the deliver blind flag is set on the order, we do not want to output
the company logo */
if ($DeliverBlind < 2) {
    $pdf->addJpegFromFile('companies/' . $_SESSION['DatabaseName'] . '/logo.jpg',20,670,0,100);
}
$FontSize=16;

	$pdf->addText(15, 650,$FontSize, _('Packing Slip'));

/*
if ($Copy=='Customer'){
	$pdf->addText(15, 650,$FontSize, _('Packing Slip') . ' - ' );
	$pdf->addText(15, 630,$FontSize,  _('Customer Copy') );
} else {
	$pdf->addText(15, 650,$FontSize, _('Packing Slip') . ' - ' );
	$pdf->addText(15, 630,$FontSize, _('Office Copy') );
}
*/

/* if the deliver blind flag is set on the order, we do not want to output
the company contact info */
if ($DeliverBlind < 2) {
    $FontSize=11;
    $FontSizeSm=10;
    $YPos = 610;
	$XPos = 20;
	$pdf->setFont('Helvetica', 'B', 12); 
    $pdf->addText($XPos, $YPos,$FontSizeSm, _('THIRD PARTY BILL TO').':' );
$YPos = 595;
	$pdf->addText($XPos, $YPos,$FontSize, $_SESSION['CompanyRecord']['coyname']);
    $pdf->setFont('Helvetica', '', 9); 
    $FontSize =10;
    $pdf->addText($XPos, $YPos-12,$FontSize, $_SESSION['CompanyRecord']['regoffice1']. ' ' . $_SESSION['CompanyRecord']['regoffice2']);
    $pdf->addText($XPos, $YPos-23,$FontSize, $_SESSION['CompanyRecord']['regoffice3'] . ' ' . $_SESSION['CompanyRecord']['regoffice4'] . ' ' . $_SESSION['CompanyRecord']['regoffice5']);
    $pdf->addText($XPos, $YPos-34,$FontSize, $_SESSION['CompanyRecord']['regoffice6']);
$pdf->addText($XPos, $YPos-45,$FontSize, _('Ph') . ': ' . $_SESSION['CompanyRecord']['telephone'] . ' ' . _('Fax'). ': ' . $_SESSION['CompanyRecord']['fax']);
    $pdf->addText($XPos, $YPos-56,$FontSize, $_SESSION['CompanyRecord']['email']);
}


   $FontSize=10;
    $FontSizeSm=10;
    $YPos = 610;
	$pdf->setFont('Helvetica', 'B', 10); 
    $pdf->addText($XPos+195, $YPos,$FontSizeSm, _('PICK UP LOCATION').':' );
$YPos = 595;


	$pdf->addText($XPos+195, $YPos,$FontSize, $myrow['locationname']);
    $pdf->setFont('Helvetica', '', 9); 
    $FontSize =10;
	$pdf->setFont('Helvetica', '', 9); 
    $FontSize =10;
	


	if (strlen($myrow['deladd2'])>1)
	{
		 $pdf->addText($XPos+195, $YPos-12,$FontSize, $myrow['deladd1']);
     $pdf->addText($XPos+195, $YPos-23,$FontSize, $myrow['deladd2']);
    $pdf->addText($XPos+195, $YPos-34,$FontSize, $myrow['deladd3'] . ' ' . $myrow['deladd4'] . ' ' . $myrow['deladd5']);
    $pdf->addText($XPos+195, $YPos-45,$FontSize, $myrow['deladd6']);
   $pdf->addText($XPos+195, $YPos-56,$FontSize, _('Contact') . ': ' . $myrow['contact'] . ' ' . _('Ph'). ': ' . $myrow['tel']);
    $pdf->addText($XPos+195, $YPos-67,$FontSize, $myrow['email']);
	}
	else
	{
	 $pdf->addText($XPos+195, $YPos-12,$FontSize, $myrow['deladd1']. ' ' . $myrow['deladd2']);
    $pdf->addText($XPos+195, $YPos-23,$FontSize, $myrow['deladd3'] . ' ' . $myrow['deladd4'] . ' ' . $myrow['deladd5']);
    $pdf->addText($XPos+195, $YPos-34,$FontSize, $myrow['deladd6']);
   $pdf->addText($XPos+195, $YPos-45,$FontSize, _('Contact') . ': ' . $myrow['contact'] . ' ' . _('Ph'). ': ' . $myrow['tel']);
    $pdf->addText($XPos+195, $YPos-56,$FontSize, $myrow['email']);
	}
  






   $FontSize=10;
    $FontSizeSm=10;
    $YPos = 610;
	$pdf->setFont('Helvetica', 'B', 10); 
    $pdf->addText($XPos+410, $YPos,$FontSizeSm, _('SHIP TO').':' );
$YPos = 595;

if($Ship=='13')
{
	$pdf->addText($XPos+410, $YPos,$FontSize, $myrow['locationname']);
    $pdf->setFont('Helvetica', '', 9); 
    $FontSize =10;
    $pdf->addText($XPos+410, $YPos-12,$FontSize, $myrow['deladd1']. ' ' . $myrow['deladd2']);
    $pdf->addText($XPos+410, $YPos-23,$FontSize, $myrow['deladd3'] . ' ' . $myrow['deladd4'] . ' ' . $myrow['deladd6']);
    $pdf->addText($XPos+410, $YPos-34,$FontSize, $myrow['deladd5']);
  $pdf->addText($XPos+410, $YPos-45,$FontSize, _('Contact') . ': ' . $myrow['contact'] . ' ' . _('Ph'). ': ' . $myrow['tel']);
    $pdf->addText($XPos+410, $YPos-56,$FontSize, $myrow['email']);
 
}
else
{    	 
//$pdf->addTextWrap($XPos+410,$YPos,250,$FontSize,$myrow['brname'],'left');
//$pdf->addTextWrap($XPos+410, $YPos, 250, 14, $myrow['brname'], 'L', 0, 0);
$pdf->addText($XPos+410, $YPos,$FontSize, $myrow['brname']);
    $pdf->setFont('Helvetica', '', 8); 
    $FontSize =10;
	
	if (strlen($myrow['custdeladd2'])>1)
	{
	  $pdf->addText($XPos+410, $YPos-12,$FontSize, $myrow['custdeladd1']);
	 $pdf->addText($XPos+410, $YPos-23,$FontSize, $myrow['custdeladd2']);
	
	$pdf->addText($XPos+410, $YPos-34,$FontSize, $myrow['custdeladd3'] . ' ' . $myrow['custdeladd4'] . ' ' . $myrow['custdeladd6']);
    $pdf->addText($XPos+410, $YPos-45,$FontSize, $myrow['custdeladd5']);
  $pdf->addText($XPos+410, $YPos-56,$FontSize, _('Contact') . ': ' . $myrow['contactname'] . ' ' . _('Ph'). ': ' . $myrow['phoneno']);
    $pdf->addText($XPos+410, $YPos-67,$FontSize, $myrow['email2']);
 
	}
	
	else
	
	{
	  $pdf->addText($XPos+410, $YPos-12,$FontSize, $myrow['custdeladd1']. ' ' . $myrow['custdeladd2']);
	
	$pdf->addText($XPos+410, $YPos-23,$FontSize, $myrow['custdeladd3'] . ' ' . $myrow['custdeladd4'] . ' ' . $myrow['custdeladd6']);
    $pdf->addText($XPos+410, $YPos-34,$FontSize, $myrow['custdeladd5']);
  $pdf->addText($XPos+410, $YPos-45,$FontSize, _('Contact') . ': ' . $myrow['contactname'] . ' ' . _('Ph'). ': ' . $myrow['phoneno']);
    $pdf->addText($XPos+410, $YPos-56,$FontSize, $myrow['email2']);
 
	}
  

}


$XPos = 175;
$YPos = 750;

// $YPos += 30;
$FontSize=11;
$pdf->setFont('Helvetica', 'B', 11); 

$pdf->addText($XPos, $YPos,$FontSize, _('Customer').':');
//$pdf->addText($XPos, $YPos-15,$FontSize, $myrow['name']);

$LeftOvers = $pdf->addTextWrap($XPos,$YPos-15,150,$FontSize,$myrow['name']);

if (strlen($LeftOvers)>1){
	$LeftOvers = $pdf->addTextWrap($XPos,$YPos-30,170,$FontSize,$LeftOvers);
	}

$FontSize=10;
$pdf->setFont('Helvetica', '', 10); 

$pdf->addText($XPos, $YPos-45,$FontSize, $myrow['address1'] . ' ' . $myrow['address2']);
$pdf->addText($XPos, $YPos-60,$FontSize, $myrow['address3'] . ' ' . $myrow['address4'] . ' ' . $myrow['address5']);
$pdf->addText($XPos, $YPos-75,$FontSize, $myrow['address6']);

$pdf->setFont('Helvetica', 'B', 12); 
$pdf->addText($XPos, $YPos-90,$FontSize, _('Ship Via'). ' : ' . $myrow['shippername']);
$pdf->addText($XPos, $YPos-105,$FontSize,  _('Ship Date'). ':' . $myrow['duedate']);
//$pdf->line(265,$YPos-95,375, $YPos-95);

$pdf->setFont('Helvetica', '', 10); 

//$LeftOvers = $pdf->addTextWrap($XPos,$YPos-115,170,$FontSize,$myrow['comments']);

//if (strlen($LeftOvers)>1){
//	$LeftOvers = $pdf->addTextWrap($XPos,$YPos-130,170,$FontSize,$LeftOvers);
//	if (strlen($LeftOvers)>1){
//		$LeftOvers = $pdf->addTextWrap($XPos,$YPos-145,170,$FontSize,$LeftOvers);
//		if (strlen($LeftOvers)>1){
//			$LeftOvers = $pdf->addTextWrap($XPos,$YPos-160,170,$FontSize,$LeftOvers);
//			if (strlen($LeftOvers)>1){
//				$LeftOvers = $pdf->addTextWrap($XPos,$YPos-175,170,$FontSize,$LeftOvers);
//			}
//		}
//	}
//}

$pdf->setFont('Helvetica', 'B', 12); 

$pdf->addText(420, 750,$FontSize, _('Order No'). ':');
$pdf->addText(500, 750,$FontSize, 'SO' . $_GET['TransNo']);
$pdf->addText(420, 750-15,$FontSize, _('Customer No.'). ' : ');
$pdf->addText(500, 750-15,$FontSize, $myrow['debtorno']);
$pdf->addText(420, 750-30,$FontSize, _('Your Ref'). ':');
$pdf->addText(500, 750-30,$FontSize, $myrow['subject']);
$pdf->addText(420, 750-55,$FontSize,  _('Order Date'). ':');
$pdf->addText(500, 750-55,$FontSize,  ConvertSQLDate($myrow['orddate']));
$pdf->addText(420, 750-70,$FontSize,  _('Printed') . ': ');
$pdf->addText(500, 750-70,$FontSize,  Date($_SESSION['DefaultDateFormat']));
$pdf->addText(420, 750-85,$FontSize,  _('Page'). ':');
$pdf->addText(500, 750-85,$FontSize,  $PageNumber);
$pdf->addText(510, 750-85,$FontSize,  _(' of '));
$pdf->addText(528, 750-85,$FontSize,  $Noofpages);


$pdf->setFont('Helvetica', 'B', 10); 


$YPos -= 248;
$XPos = 30;
		$pdf->line(25,$YPos,585, $YPos);

$header_line_height = $line_height+25;

$LeftOvers = $pdf->addTextWrap($XPos,$YPos,127,$FontSize, _('Item Code and Description'),'left');
// $LeftOvers = $pdf->addTextWrap(95,$YPos,220,$FontSize, _('Item Description'),'left');
$LeftOvers = $pdf->addTextWrap(232,$YPos,85,$FontSize, _('Order Qty'),'right');
$LeftOvers = $pdf->addTextWrap(297,$YPos,85,$FontSize,_('Qty Shipped'),'right');
$LeftOvers = $pdf->addTextWrap(250,$YPos,235,$FontSize,_('Batch or Lot Codes'),'right');
//$LeftOvers = $pdf->addTextWrap(462,$YPos,85,$FontSize, _('Prev Dels'),'right');
$LeftOvers = $pdf->addTextWrap(495,$YPos,85,$FontSize, _('KG'),'right');

$YPos -= $line_height;

$pdf->setFont('Helvetica', '', 9); 

$FontSize =9;

?>
