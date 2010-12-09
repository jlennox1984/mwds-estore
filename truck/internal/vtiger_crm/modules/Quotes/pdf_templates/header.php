<?php

// ************** Begin company information *****************
$imageBlock=array("10","8","56.25","42.25");
$pdf->addImage( $logo_name, $imageBlock);

// x,y,width
$companyBlockPositions=array( "60","17","60" );
$companyText=$org_address."\n".$org_city.", ".$org_state." ".$org_code." ".$org_country;
$pdf->addTextBlock( $org_name, $companyText ,$companyBlockPositions );

// ************** End company information *******************


// ************* Begin Top-Right Header ***************
// title
$titleBlock=array("140","7", "70");
$pdf->title( "Quote","", $titleBlock );
//$soBubble=array("140","17","20");
//$pdf->addBubbleBlock($so_id, "SO ID", $soBubble);

//$poBubble=array("126","17","20");
//$pdf->addBubbleBlock($subject, "Customer Ref.", $poBubble);

// page number
$pageBubble=array("177","17",0);
$pdf->addBubbleBlock($page_num, "Page", $pageBubble);
// ************** End Top-Right Header *****************



// ************** Begin Addresses **************
// shipping Address
$contactLocation = array("10","43","60");
$contactText=$contact_name;
$pdf->addTextBlock( "Contact Person:", $contactText, $contactLocation );

// shipping Address
$shipLocation = array("65","43","60");
$shipText=$ship_street."   ".$ship_street2."\n".$ship_city.", ".$ship_state." ".$ship_code."\n".$ship_country;
$pdf->addTextBlock( "Shipping Address:", $shipText, $shipLocation );

// billing Address
$billPositions = array("140","43","60");
$billText=$bill_street."   ".$bill_street2."\n".$bill_city.", ".$bill_state." ".$bill_code."\n".$bill_country;
$pdf->addTextBlock("Billing Address:",$billText, $billPositions);
// ********** End Addresses ******************





/*  ******** Begin Quote Data ************************ */
// terms block
$termBlock=array("10","65","60");
$pdf->addRecBlock($account_name, "Customer Name", $termBlock);

// due date block
$dueBlock=array("115","65","4");
$pdf->addRecBlock($valid_till, "Valid Till",$dueBlock);

// invoice number block
$invBlock=array("160","65","4");
$pdf->addRecBlock($quote_id, "Quote No#",$invBlock);

/* ************ End Quote Data ************************ */



?>
