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

			$tmp4 = "00000" . $ShiptRef;
			$OrderNoPrint = substr($tmp4,-5,5);
			
			
$pdf->addText($XPos+70,$YPos+$line_height,$FontSize, _('Shipping Request No. '). ' ' . $OrderNoPrint);
$XPos = $Page_Width/2 - 30;

if ($ViewingOnly!=0) {
	$FontSize=16;
	$pdf->addText($XPos,$YPos,$FontSize, _('FOR VIEWING ONLY') . ', ' . _('DO NOT SEND TO ') );
	$pdf->addText($XPos,$YPos-$line_height,$FontSize, _('SHIPPER') . ' - ' . _('THIS IS A COPY') );
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



	   $sqlx = "SELECT purchorderdetails.podetailitem,
	      				purchorders.intostocklocation,
						purchorders.supplierno,
						purchorders.deladd1,
						purchorders.deladd2,
						purchorders.deladd3,
						purchorders.deladd4,
						purchorders.deladd5,
						purchorders.deladd6
				FROM purchorderdetails 
				INNER JOIN purchorders
					ON purchorderdetails.orderno=purchorders.orderno
				WHERE purchorderdetails.shiptref=" . $ShiptRef;
	   $LineItemsResult=DB_query($sqlx,$db);
 DB_data_Seek($LineItemsResult,0);
		   $myrowx=DB_fetch_array($LineItemsResult);
		   $StockLocation = $myrowx['intostocklocation'];
		   
		   
		   $sqly = "SELECT locationname, deladd1, deladd2, deladd3, deladd4, deladd5, deladd6, tel, fax, contact from locations WHERE loccode ='" . $StockLocation ."'";
		   $LineItemsResult2=DB_query($sqly,$db);
 DB_data_Seek($LineItemsResult2,0);
		   $myrowy=DB_fetch_array($LineItemsResult2);
		
   $sqlz = "SELECT suppname, address1, address2, address3, address4, address5, address6 from suppliers WHERE supplierid ='" . $myrowx['supplierno'] ."'";
		   $LineItemsResult3=DB_query($sqlz,$db);
 DB_data_Seek($LineItemsResult3,0);
		   $myrowz=DB_fetch_array($LineItemsResult3);
		

$pdf->setFont('Helvetica', 'B', 10); 

$pdf->addText($XPos-50,$YPos, $FontSize, _('Pick Up From') . ':' );

$pdf->setFont('Helvetica', '', 10); 

$pdf->addText($XPos-50,$YPos-$line_height, $FontSize, $myrowz['suppname']);

  $pdf->addText($XPos-50,$YPos-(2*$line_height), $FontSize, $myrowz['address1']);
  if($myrowz['address2']=="" || (!isset($myrowz['address2'])))
  {
$pdf->addText($XPos-50,$YPos-(3*$line_height), $FontSize, $myrowz['address3'] . ' ' . $myrowz['address4'] . ' ' . $myrowz['address5']);
$pdf->addText($XPos-50,$YPos-(4*$line_height), $FontSize, $myrowz['address6']);
   }
  else
  {
  $pdf->addText($XPos-50,$YPos-(3*$line_height), $FontSize, $myrowz['address2']);
$pdf->addText($XPos-50,$YPos-(4*$line_height), $FontSize, $myrowz['address3'] . ' ' . $myrowz['address4'] . ' ' . $myrowz['address5']);
$pdf->addText($XPos-50,$YPos-(5*$line_height), $FontSize, $myrowz['address6']);
}



//$sql6 = "SELECT description from workcentres where code='" . $POHeader['workcentre'] . "'";	
//$WorkCentreResult = DB_query($sql6,$db);
//$WorkCentreRow = DB_fetch_row($WorkCentreResult);
//$workcentre = $WorkCentreRow[0];

$pdf->setFont('Helvetica', 'B', 10); 

$pdf->addText($XPos+145,$YPos, $FontSize, _('Deliver To') . ':' );

$pdf->setFont('Helvetica', '', 10); 

$pdf->addText($XPos+145,$YPos-$line_height, $FontSize, $myrowy['locationname']);

//$pdf->addText($XPos+105,$YPos-($line_height), $FontSize, $locationname);
  $pdf->addText($XPos+145,$YPos-(2*$line_height), $FontSize, $myrowy['deladd1']);
  if($myrowy['deladd2']=="" || (!isset($myrowy['deladd2'])))
  {
$pdf->addText($XPos+145,$YPos-(3*$line_height), $FontSize, $myrowy['deladd3'] . ' ' . $myrowy['deladd4'] . ' ' . $myrowy['deladd5']);
$pdf->addText($XPos+145,$YPos-(4*$line_height), $FontSize, $myrowy['deladd6']);
   }
  else
  {
$pdf->addText($XPos+145,$YPos-(3*$line_height), $FontSize, $myrowy['deladd2']);
$pdf->addText($XPos+145,$YPos-(4*$line_height), $FontSize, $myrowy['deladd3'] . ' ' . $myrowy['deladd4'] . ' ' . $myrowy['deladd5']);
$pdf->addText($XPos+145,$YPos-(5*$line_height), $FontSize, $myrowy['deladd6']);
  }






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
$pdf->addText($Left_Margin,$YPos, $FontSize, _('All amounts stated in').' - ' . $POHeader['currcode']);

$pdf->addText($XPos+420,$YPos, $FontSize, _('Deliver By') . ':' );
$pdf->addText($XPos+495,$YPos, $FontSize, ConvertSQLDate($POHeader['reqdate']));


$pdf->addText($XPos+225,$YPos, $FontSize, _('Requisition No.') . ':' );
$pdf->addText($XPos+310,$YPos, $FontSize, $POHeader['requisitionno']);


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

		if ($_POST['ShowAmounts']=='Yes'){
$pdf->addText($Left_Margin+450,$YPos, $FontSize, _('Price') );
$pdf->addText($Left_Margin+500,$YPos, $FontSize, _('Total') );
		}
		
$pdf->setFont('Helvetica', '', 10); 

$YPos -= $line_height;
$pdf->line($Left_Margin, $YPos, $Page_Width-$Right_Margin, $YPos);
//$YPos -= $line_height;

/*Set up headings */
$FontSize=10;


$YPos-=$line_height;

?>