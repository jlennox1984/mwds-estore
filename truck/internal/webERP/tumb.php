<?php
function tn ($path,$filename,$Catid_raw) {
$Catid=strtoupper($Catid_raw);
//Name you want to save your file as
$save = $path. '/'.$Catid .'-thumb.jpg';

$file = $filename;
echo "Creating file: $save";
$size = 0.45;
header('Content-type: image/jpeg') ;
list($width, $height) = getimagesize($file) ;
$modwidth = 100;
$modheight = 100;
$tn = imagecreatetruecolor($modwidth, $modheight) ;
$image = imagecreatefromjpeg($file) ;
imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ;

// Here we are saving the .jpg, you can make this gif or png if you want
//the file name is set above, and the quality is set to 100%
imagejpeg($tn, $save, 100) ;
}
?> 

