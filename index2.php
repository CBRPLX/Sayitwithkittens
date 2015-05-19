<?php
include 'Box.php';
include 'Color.php';

$dev = false;
if(isset($_GET['dev'])) $dev = true;

//Filename
$filename = "kitten.jpg";

//Get extension
$imgInfo = getimagesize($filename) or diewith("Unable to open '$uri'");
$srcWidth =  $imgInfo[0];
$srcHeight = $imgInfo[1];
$srcType   = $imgInfo[2];
switch($srcType) { 
    case 1 : $srcType = "gif"; break;
    case 2 : $srcType = "jpeg"; break;
    case 3 : $srcType = "png"; break;
    default: $srcType = "???";
}
if($dev)
	var_dump($srcType);

// Définition du content-type
if(!$dev)
	header("Content-Type: image/png");

//Compute new dimension
$inWidth = '900';
$inHeight = '600';

$xRatio = ($inWidth) ?  ($srcWidth  / $inWidth) : 0;
$yRatio = ($inHeight) ? ($srcHeight / $inHeight): 0;
$ratio = min($xRatio, $yRatio);
// if($ratio <= 1 ) $ratio = 1;

$outWidth = intval($srcWidth / $ratio);
$outHeight = intval($srcHeight/ $ratio);

if(($outWidth-$inWidth) > ($outHeight-$inHeight)){
    $crop_width = intval(abs(($outWidth-$inWidth)/2));
    $crop_height = intval(0);
}else{ 
    $crop_width = intval(0);
    $crop_height = intval(abs(($outHeight-$inHeight)/2));
}

$imgWidth = intval($outWidth - ($crop_width*2));
$imgHeight = intval($outHeight - ($crop_height*2));

// Getimage
switch ($srcType) {
	case 'gif':
		$im = imagecreatefromgif($filename);
		break;
	case 'jpeg':
		$im = imagecreatefromjpeg($filename);
		break;
	case 'png':
		$im = imagecreatefrompng($filename);
		break;
	
	default:
		diewith("Bad extension");
		break;
}

// Create output image
$outImg = imagecreatetruecolor ($outWidth, $outHeight);
imagealphablending($outImg,false);
imagesavealpha($outImg,true);

// Resize image
if($dev){
	echo "<br/>imagecopyresampled($outImg, $im, 0, 0, 0, 0, $outWidth, $outHeight, $srcWidth, $srcHeight);<br/>";
}else{
	imagecopyresampled($outImg, $im, 0, 0, 0, 0, $outWidth, $outHeight, $srcWidth, $srcHeight);
}

// Create final image
$imgImg = imagecreatetruecolor ($imgWidth, $imgHeight);
imagealphablending($imgImg,false);
imagesavealpha($imgImg,true);

imagecopyresampled($imgImg, $outImg, 0, 0, $crop_width, $crop_height, $outWidth, $outHeight, $outWidth, $outHeight);

// Création de quelques couleurs
$white = imagecolorallocate($im, 255, 255, 255);
$grey_lite = imagecolorallocatealpha($im, 0, 0, 0, 110);
$grey = imagecolorallocatealpha($im, 0, 0, 0, 70);
$black = imagecolorallocatealpha($im, 0, 0, 0, 20);
// imagefilledrectangle($im, 0, 0, 399, 29, $white);

// Le texte à dessiner
$text = "Sale fils de pute de connard de merde tu vas manger du caca";
$text = "T'as vraiment une tête de cul";
if(!empty($_GET['text']))
$text = $_GET['text'];

$text = wordwrap($text, 25, "\n");

// Remplacez le chemin par votre propre chemin de police
$font = 'GROBOLD.ttf';
$pacifico = "Lobster.otf";
$proxima = "ProximaNovaBold.ttf";



//On remet la transparence
imagealphablending($imgImg, true);

$box = new GDText\Box($imgImg);
$box->setFontFace($font);
$box->setFontColor(new GDText\Color(255, 255, 255));
$box->setTextShadow(new GDText\Color(0, 0, 0, 50), 2, 2);
$box->setFontSize(80);
$box->setLineHeight(1.2);
$box->setBox(20, 30, 860, 500);
$box->setTextAlign('center', 'center');
$box->draw($text);

// Compute the coordinates pour centrer le #
$tb = imagettfbbox(17, 0, $proxima, "#SAYITWITHKITTENS");
$x = ceil((900 - $tb[2]) / 2);
// $y = ceil((600 - $tb[1]) / 2);
if($dev)
var_dump($tb);

// Ajout du #
// Ajout d'ombres au texte
imagettftext($imgImg, 17, 0, $x+3, 583, $grey_lite, $proxima, "#SAYITWITHKITTENS");
imagettftext($imgImg, 17, 0, $x+2, 582, $grey, $proxima, "#SAYITWITHKITTENS");
imagettftext($imgImg, 17, 0, $x+1, 581, $black, $proxima, "#SAYITWITHKITTENS");

// Ajout du texte
imagettftext($imgImg, 17, 0, $x+0, 580, $white, $proxima, "#SAYITWITHKITTENS");

// Utiliser imagepng() donnera un texte plus claire,
// comparé à l'utilisation de la fonction imagejpeg()
if(!$dev)
imagepng($imgImg, "coucou.png");
imagedestroy($imgImg);
readfile("coucou.png");
?>