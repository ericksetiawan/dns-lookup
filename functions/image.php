<?php
$img_number = imagecreate(270,35);
$backcolor = imagecolorallocate($img_number,102,102,153);
$textcolor = imagecolorallocate($img_number,255,255,255);

imagefill($img_number,0,0,$backcolor);
$number = " Your IP is : $_SERVER[REMOTE_ADDR]";
imagestring($img_number,1,225,23, "norak.us", $textcolor );

Imagestring($img_number,10,5,5,$number,$textcolor);

header("Content-type: image/jpeg");
imagejpeg($img_number);

imagecolordeallocate($backcolor);
imagecolordeallocate($textcolor);
imagedestroy($img_number);
?>
