<?php
/* $Revision: 1.12 $ */
/*
	R & OS PHP-PDF class code to set up a new page
	a new page is implicit on the establishment of a new pdf object so
	only for subsequent pages
*/

if ($PageNumber>1){
	$pdf->newPage();
}

$YPos = $Page_Height - $Top_Margin - ($line_height*2);


$pdf->addJpegFromFile('companies/' . $_SESSION['DatabaseName'] . '/logo.jpg',$Left_Margin,$YPos-55,0,100);

$FontSize=15;

$XPos = $Page_Width/2;

			$tmp4 = "00000" . $PRNo;
			$OrderNoPrint = substr($tmp4,-5,5);
			
			
$pdf->addText($XPos,$YPos+$line_height,$FontSize, _('Manufacturing Request No. '). ' ' . $OrderNoPrint);
$XPos = $Page_Width/2 - 80;

if ($ViewingOnly!=0) {
	$FontSize=16;
	$pdf->addText($XPos,$YPos,$FontSize, _('FOR VIEWING ONLY') . ', ' . _('DO NOT SEND TO ') );
	$pdf->addText($XPos,$YPos-$line_height,$FontSize, _('MANUFACTURERS') . ' - ' . _('THIS IS NOT AN ORDER') );
}

$Ypos -= ($line_height*3);
$FontSize=10;
$XPos = $Page_Width-$Right_Margin-50;
$pdf->addText($XPos,$YPos +40, $FontSize, _('Page') . ': ' .$PageNumber);

$regaddress = $_SESSION['CompanyRecord']['regoffice1'] . '   ' . $_SESSION['CompanyRecord']['regoffice2'];


/*Now print out the company name and address */
$XPos = $Left_Margin;
$YPos -=2*$line_height;
// $pdf->addText($Left_Margin,$YPos-20, $FontSize, $_SESSION['CompanyRecord']['coyname']);
// $pdf->addText($Left_Margin,$YPos-$line_height, $FontSize, $_SESSION['CompanyRecord']['regoffice1']);
//  $pdf->addText($Left_Margin,$YPos-(2*$line_height), $FontSize, $_SESSION['CompanyRecord']['regoffice2']);
$pdf->addText($Left_Margin,$YPos-40, $FontSize, $regaddress);
$pdf->addText($Left_Margin,$YPos-40-($line_height), $FontSize, $_SESSION['CompanyRecord']['regoffice3'] . ' ' . $_SESSION['CompanyRecord']['regoffice4'] . ' ' . $_SESSION['CompanyRecord']['regoffice5']);
$pdf->addText($Left_Margin,$YPos-40-(2*$line_height), $FontSize, _('Ph'). ': ' . $_SESSION['CompanyRecord']['telephone'] . ' ' ._('Fax').': ' . $_SESSION['CompanyRecord']['fax'] );
$pdf->addText($Left_Margin,$YPos-40-(3*$line_height), $FontSize, _('Email'). ': ' . $_SESSION['CompanyRecord']['email']);


$pdf->addText($Left_Margin,$YPos-40-(4*$line_height), $FontSize, $_SESSION['TaxAuthorityReferenceName'] . ' ' . $_SESSION['CompanyRecord']['gstno']);

$pdf->addText($Left_Margin,$YPos-40-(5*$line_height), $FontSize,  _('Initiated Date').': ' . ConvertSQLDate($POHeader['initdate']));

$pdf->addText($Left_Margin,$YPos-40-(6*$line_height), $FontSize,  _('Initiator').': ' . $POHeader['initiator']);


$workaddress = $POHeader['workadd1'] . '   ' . $POHeader['workadd2'];
//		$sql2 = "SELECT locationname from locations where loccode='" . $POHeader['intostocklocation'] . "'";	
$sql2 = "SELECT locationname, location from workcentres, locations where workcentres.location=locations.loccode and loccode='" . $POHeader['workcentre'] . "'";	

$LocnNameResult = DB_query($sql2,$db);
$LocnNameRow = DB_fetch_row($LocnNameResult);
$locationname = $LocnNameRow[0];

/*Now the delivery details */
$YPos -= 8;
$XPos = $Page_Width/2;
$FontSize=10;



$sql6 = "SELECT description from workcentres where code='" . $POHeader['workcentre'] . "'";	
$WorkCentreResult = DB_query($sql6,$db);
$WorkCentreRow = DB_fetch_row($WorkCentreResult);
$workcentre = $WorkCentreRow[0];


$pdf->addText($XPos+105,$YPos, $FontSize, _('Manufacturing Facility') . ':' );
$pdf->addText($XPos+105,$YPos-$line_height, $FontSize, $workcentre);

//$pdf->addText($XPos+105,$YPos-($line_height), $FontSize, $locationname);
  $pdf->addText($XPos+105,$YPos-(2*$line_height), $FontSize, $POHeader['workadd1']);
$pdf->addText($XPos+105,$YPos-(3*$line_height), $FontSize, $POHeader['workadd2']);
$pdf->addText($XPos+105,$YPos-(4*$line_height), $FontSize, $POHeader['workadd3'] . ' ' . $POHeader['workadd4'] . ' ' . $POHeader['workadd5']);
$pdf->addText($XPos+105,$YPos-(5*$line_height), $FontSize, $POHeader['workadd6']);


$pdf->addText($XPos+105,$YPos-(7*$line_height), $FontSize, _('Manufacture By') . ':' );
$pdf->addText($XPos+195,$YPos-(7*$line_height), $FontSize, ConvertSQLDate($POHeader['reqdate']));


$pdf->addText($XPos+105,$YPos-(8*$line_height), $FontSize, _('Requisition No.') . ':' );
$pdf->addText($XPos+195,$YPos-(8*$line_height), $FontSize, $POHeader['requisitionno']);






/*end of the small table showing the coy name and delivery address details */

$XPos = $Left_Margin;
$YPos -= ($line_height*4.5);         /* 4 lines down */

/*
PDF_moveto($p, $XPos+230, $YPos-100);
PDF_arc($p, $XPos+220, $YPos, 10, 0, 90);
PDF_arc($p, $XPos+5, $YPos, 10, 90, 180);
PDF_arc($p, $XPos+5, $YPos-100, 10, 180, 270);
PDF_arc($p, $XPos+220, $YPos-100, 10, 270, 360);
PDF_stroke($p);



$font=PDF_findfont($p,"Helvetica-Bold","host",0);
PDF_setfont($p, $font, 12.0);

*/
$YPos -= 30;


$XPos = $Page_Width/2 + 55;



$YPos -= $line_height;
$XPos = $XPos-175;
//$pdf->addText($XPos,$YPos, $FontSize, _('Comments') . ':' );
$YPos -= $line_height;
//$LeftOvers = $pdf->addTextWrap($XPos, $YPos,250,$FontSize,$POHeader['comments'], 'left');
//if (strlen($LeftOvers)>0){
//	$LeftOvers = $pdf->addTextWrap($XPos, $YPos-$line_height,250,$FontSize,$LeftOvers, 'left');
//}

$XPos = $Left_Margin;
$YPos -= ($line_height*1);
$pdf->addText($Left_Margin,$YPos, $FontSize, _('All amounts stated in CDN'));


$YPos -= ($line_height*.5);
/*draw a square grid for entering line items */
$pdf->line($Left_Margin, $YPos, $Page_Width-$Right_Margin, $YPos);
$pdf->line($Page_Width-$Right_Margin, $YPos, $Page_Width-$Right_Margin, $Bottom_Margin);
$pdf->line($Page_Width-$Right_Margin, $Bottom_Margin, $Left_Margin, $Bottom_Margin);
$pdf->line($Left_Margin, $Bottom_Margin, $Left_Margin, $YPos);

$YPos -= $line_height;
/*Set up headings */
$FontSize=10;		
$pdf->setFont('Helvetica', 'B', 10); 

$pdf->addText($Left_Margin+1,$YPos, $FontSize, _('Code') );
$pdf->addText($Left_Margin+65,$YPos, $FontSize, _('Item Description') );
$pdf->addText($Left_Margin+350,$YPos, $FontSize, _('Quantity') );
$pdf->addText($Left_Margin+410,$YPos, $FontSize, _('Unit') );
$pdf->addText($Left_Margin+450,$YPos, $FontSize, _('Price') );
$pdf->addText($Left_Margin+500,$YPos, $FontSize, _('Total') );
$pdf->setFont('Helvetica', '', 10); 

$YPos -= $line_height;
$pdf->line($Left_Margin, $YPos, $Page_Width-$Right_Margin, $YPos);
$YPos -= $line_height;

/*Set up headings */
$FontSize=10;

$sql3 = "SELECT description from stockmaster where stockid='" . $POHeader['stockno'] . "'";	
$StockNameResult = DB_query($sql3,$db);
$StockNameRow = DB_fetch_row($StockNameResult);
$stockname = $StockNameRow[0];


$sql4 = "SELECT labourcost from stockmaster where stockid='" . $POHeader['stockno'] . "'";	
$StockCostResult = DB_query($sql4,$db);
$StockCostRow = DB_fetch_row($StockCostResult);
$labourcost = $StockCostRow[0];

$total1=$POHeader['prodrunqty']*$labourcost;
$total=number_format($total1,2);

$sql5 = "SELECT units from stockmaster where stockid='" . $POHeader['stockno'] . "'";	
$StockUnitResult = DB_query($sql5,$db);
$StockUnitRow = DB_fetch_row($StockUnitResult);
$units = $StockUnitRow[0];

$prodrunqty=$POHeader['prodrunqty']*100/100;
//$prodrunqty = rtrim($prodrunqty, "0");
$text1 = rtrim($prodrunqty, 'a..z');
$prodrunqty = rtrim($text1, '.');
//echo $text1; // only the '.' is trimmed.
settype($prodrunqty, "double");
//if(is_integer($prodrunqty)==true)
//{
//$runqty = number_format($prodrunqty,0);
//$prodrunqty=$runqty;
//$prodrunqty="TRUE";
	//		}
//if(is_integer($prodrunqty)==false)
//{
//$prodrunqty="FALSE";
//}



$LeftOvers = $pdf->addTextWrap($Left_Margin+1, $YPos,250,$FontSize,$POHeader['stockno'], 'left');
$LeftOvers = $pdf->addTextWrap($Left_Margin+50, $YPos,250,$FontSize,$stockname, 'left');
$LeftOvers = $pdf->addTextWrap($Left_Margin+350, $YPos,250,$FontSize,$prodrunqty, 'left');
$LeftOvers = $pdf->addTextWrap($Left_Margin+410, $YPos,250,$FontSize,$units, 'left');
//$LeftOvers = $pdf->addTextWrap($Left_Margin+285, $YPos,250,$FontSize,$POHeader['reqdate'], 'left');
$LeftOvers = $pdf->addTextWrap($Left_Margin+450, $YPos,250,$FontSize,$labourcost, 'left');
$LeftOvers = $pdf->addTextWrap($Left_Margin+500, $YPos,250,$FontSize,$total, 'left');

$YPos-=$line_height;

/*draw a line */
$pdf->line($Left_Margin, $YPos, $Page_Width-$Right_Margin, $YPos);

$YPos-=$line_height;
$pdf->setFont('Helvetica', 'B', 10); 

$LeftOvers = $pdf->addTextWrap($Left_Margin+5, $YPos,250,$FontSize,'Comments: ', 'left');
$pdf->setFont('Helvetica', '', 10); 

$LeftOvers = $pdf->addTextWrap($Left_Margin+65, $YPos,250,$FontSize,$POHeader['comments'], 'left');

?>