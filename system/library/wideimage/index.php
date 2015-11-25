<?php
require( "WideImage.php");

$img = WideImage::load("SDC10527.JPG");
$img = $img->resize(1000, 309, 'outside')->crop('0% - 50', '30% - 40', 1000, 309);
$img = $img->saveToFile('minha_foto_menor.jpg');



?>

<img src="minha_foto_menor.jpg" width="1000" height="309"  />