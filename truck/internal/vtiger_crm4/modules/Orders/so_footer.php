<?php

define('USD',"$");
define('EURO', chr(128) );

$top="215";

$desc=explode("\n",$description);
$cond=explode("\n",$conditions);
$num=230;

/* **************** Begin Description ****************** */
// $descBlock=array("10",$top,"53", $num);
// $pdf->addDescBlock($description, "Description", $descBlock);

//$discountBlockPositions=array( "15","220","40", "40" );
//$discountText="Discount Total ".$price_discount;
//$pdf->addTextBlock( "", $discountText ,$discountBlockPositions );


/* ************** End Description *********************** */



/* **************** Begin Terms ****************** */
$termBlock=array("10",$top,"106", $num);
$pdf->addDescBlock($conditions, "Terms & Conditions", $termBlock);

/* ************** End Terms *********************** */


?>
