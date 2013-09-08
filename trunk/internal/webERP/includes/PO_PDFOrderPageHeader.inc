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

$XPos = $Page_Width/2 - 30;

			$tmp4 = "00000" . $OrderNo;
			$OrderNoPrint = substr($tmp4,-5,5);
			
$pdf->addText($XPos,$YPos+$line_height,$FontSize, _('PO Number'). ' ' . $OrderNoPrint);

if ($ViewingOnly!=0) {
	$FontSize=16;
	$pdf->addText($XPos,$YPos,$FontSize, _('FOR VIEWING ONLY') . ', ' . _('DO NOT SEND TO SUPPLIER') );
	$pdf->addText($XPos,$YPos-$line_height,$FontSize, _('SUPPLIERS') . ' - ' . _('THIS IS NOT AN ORDER') );
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


$pdf->addText($Left_Margin,$YPos-40-(6*$line_height), $FontSize,  _('Initiator').': ' . $POHeader['initiator']);





$deladdress = $POHeader['deladd1'] . '   ' . $POHeader['deladd2'];
		$sql2 = "SELECT locationname from locations where loccode='" . $POHeader['intostocklocation'] . "'";	
$LocnNameResult = DB_query($sql2,$db);
$LocnNameRow = DB_fetch_row($LocnNameResult);
$locationname = $LocnNameRow[0];

/*Now the delivery details */
$YPos -= 8;
$XPos = $Page_Width/2 + 25;
$FontSize=10;
$pdf->addText($XPos+105,$YPos, $FontSize, _('Deliver To') . ':' );
$pdf->addText($XPos+105,$YPos-$line_height, $FontSize, $locationname);
$pdf->addText($XPos+105,$YPos-(2*$line_height), $FontSize, $deladdress);
//  $pdf->addText($XPos+105,$YPos-$line_height, $FontSize, $POHeader['deladd1']);
//$pdf->addText($XPos+105,$YPos-(2*$line_height), $FontSize, $POHeader['deladd2']);
$pdf->addText($XPos+105,$YPos-(3*$line_height), $FontSize, $POHeader['deladd3'] . ' ' . $POHeader['deladd4'] . ' ' . $POHeader['deladd5']);
$pdf->addText($XPos+105,$YPos-(4*$line_height), $FontSize, $POHeader['deladd6']);


/*draw a nice curved corner box around the delivery to address */
/*from the top right */
$pdf->partEllipse($XPos+250+60,$YPos+10,0,100,10,10);
/*line to the top left */
$pdf->line($XPos+250+60, $YPos+20,$XPos+108, $YPos+20);
/*Do top left corner */
$pdf->partEllipse($XPos+110, $YPos+10,100,180,10,10);
/*Do a line to the bottom left corner */
$pdf->line($XPos+110, $YPos-70-10,$XPos+250+60, $YPos-70-10);
/*Now do the bottom left corner 180 - 270 coming back west*/
$pdf->partEllipse($XPos+110, $YPos-70,190,270,10,10);
/*Now a line to the bottom right */
$pdf->line($XPos+100, $YPos-72,$XPos+100, $YPos+10);
/*Now do the bottom right corner */
$pdf->partEllipse($XPos+250+60, $YPos-70,260,380,10,10);
/*Finally join up to the top right corner where started */
$pdf->line($XPos+320, $YPos-70,$XPos+320, $YPos+10);



/*Now the delivery details */
$FontSize=10;
$pdf->addText($XPos-175,$YPos, $FontSize, _('To') . ':' );
//$pdf->addText($XPos-175,$YPos-$line_height, $FontSize, $locationname);
//$pdf->addText($XPos-175,$YPos-(2*$line_height), $FontSize, $deladdress);
//  $pdf->addText($XPos+175,$YPos-$line_height, $FontSize, $POHeader['deladd1']);
//$pdf->addText($XPos+175,$YPos-(2*$line_height), $FontSize, $POHeader['deladd2']);
//$pdf->addText($XPos-175,$YPos-(3*$line_height), $FontSize, $POHeader['deladd3'] . ' ' . $POHeader['deladd4'] . ' ' . $POHeader['deladd5']);
//$pdf->addText($XPos-175,$YPos-(4*$line_height), $FontSize, $POHeader['deladd6']);


$pdf->addText($XPos-173,$YPos-$line_height, $FontSize, $POHeader['suppname']);
$pdf->addText($XPos-173,$YPos-(2*$line_height), $FontSize, $POHeader['address1'] . ' ' . $POHeader['address2']);
$pdf->addText($XPos-173,$YPos-(3*$line_height), $FontSize, $POHeader['address3']  . ' ' .  $POHeader['address4']  . ' ' .  $POHeader['address5']);
$pdf->addText($XPos-173,$YPos-(4*$line_height), $FontSize, $POHeader['address6']);




/*draw a nice curved corner box around the delivery to address */
/*from the top right */
$pdf->partEllipse($XPos-50+60,$YPos+10,0,100,10,10);
/*line to the top left */
$pdf->line($XPos-50+60, $YPos+20,$XPos-180, $YPos+20);
/*Do top left corner */
$pdf->partEllipse($XPos-180, $YPos+10,100,180,10,10);
/*Do a line to the bottom left corner */
$pdf->line($XPos-180, $YPos-70-10,$XPos-50+60, $YPos-70-10);
/*Now do the bottom left corner 180 - 270 coming back west*/
$pdf->partEllipse($XPos-180, $YPos-70,190,270,10,10);
/*Now a line to the bottom right */
$pdf->line($XPos-190, $YPos-72,$XPos-190, $YPos+10);
/*Now do the bottom right corner */
$pdf->partEllipse($XPos-50+60, $YPos-70,260,380,10,10);
/*Finally join up to the top right corner where started */
$pdf->line($XPos+20, $YPos-70,$XPos+20, $YPos+10);







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


$XPos = $Page_Width/2 + 25;

$pdf->addText($XPos+105,$YPos, $FontSize, _('Deliver By') . ':' );
$pdf->addText($XPos+175,$YPos, $FontSize, ConvertSQLDate($POHeader['reqdeldate']));


$pdf->addText($XPos-175,$YPos, $FontSize, _('Order Date') . ':' );
$pdf->addText($XPos-105,$YPos, $FontSize, ConvertSQLDate($POHeader['orddate']));

//$pdf->addText($XPos-175,$YPos, $FontSize, _('Initiator').': ');
//$pdf->addText($XPos-105,$YPos, $FontSize, $POHeader['initiator']);


$YPos -= $line_height;
$pdf->addText($XPos+105,$YPos, $FontSize, _('Ship Via').': ');
$pdf->addText($XPos+175,$YPos, $FontSize, $POHeader['shipvia']);


$YPos -= $line_height;
$XPos = $XPos-175;
$pdf->addText($XPos,$YPos, $FontSize, _('Comments') . ':' );
$YPos -= $line_height;
$LeftOvers = $pdf->addTextWrap($XPos, $YPos,250,$FontSize,$POHeader['comments'], 'left');
if (strlen($LeftOvers)>0){
	$LeftOvers = $pdf->addTextWrap($XPos, $YPos-$line_height,250,$FontSize,$LeftOvers, 'left');
}

$XPos = $Left_Margin;
$YPos -= ($line_height*1);
$pdf->addText($Left_Margin,$YPos, $FontSize, _('All amounts stated in').' - ' . $POHeader['currcode']);


$YPos -= ($line_height*.5);
/*draw a square grid for entering line items */
$pdf->line($Left_Margin, $YPos, $Page_Width-$Right_Margin, $YPos);
$pdf->line($Page_Width-$Right_Margin, $YPos, $Page_Width-$Right_Margin, $Bottom_Margin);
$pdf->line($Page_Width-$Right_Margin, $Bottom_Margin, $Left_Margin, $Bottom_Margin);
$pdf->line($Left_Margin, $Bottom_Margin, $Left_Margin, $YPos);

$YPos -= $line_height;
/*Set up headings */
$FontSize=10;
$pdf->addText($Left_Margin+1,$YPos, $FontSize, _('Code') );
$pdf->addText($Left_Margin+65,$YPos, $FontSize, _('Item Description') );
$pdf->addText($Left_Margin+400,$YPos, $FontSize, _('Quantity') );
$pdf->addText($Left_Margin+450,$YPos, $FontSize, _('Unit') );
$pdf->addText($Left_Margin+485,$YPos, $FontSize, _('Date Reqd'));
$pdf->addText($Left_Margin+600,$YPos, $FontSize, _('Price') );
$pdf->addText($Left_Margin+680,$YPos, $FontSize, _('Total') );

$YPos-=$line_height;

/*draw a line */
$pdf->line($Left_Margin, $YPos, $Page_Width-$Right_Margin, $YPos);

?>