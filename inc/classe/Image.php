<?php
namespace classe;
include "inc/php/config.php";

class Image{

	private $id_image;
	private $texte;
	private $date_creation;
	private $ip_creator;
	private $pseudo;
	private $likes;

	public function __construct () {
		
    }

    public function get($attr){
    	return $this->$attr;
    }

    public function set($attr, $value){
    	$this->$attr = $value;
    }

    public function add(){
    	global $pdo;

    	if(!empty($this->texte) && !empty($this->pseudo) && $this->pseudo != "Sayitwithkittens"){
    		$ip = $this->getIPCreator();

    		if(strlen($this->texte) > 50){
    			$this->texte = substr($this->texte, 0, 50);
    		}

    		if(strlen($this->pseudo) > 15){
    			$this->pseudo = substr($this->pseudo, 0, 15);
    		}
    		
    		$sql = "INSERT INTO image (texte, date_creation, ip_creator, pseudo, likes)
    				VALUES (?,?,?,?,?)";

    		$stmt = $pdo->prepare($sql);
    		$stmt->execute(array($this->texte, time(), $ip, $this->pseudo, 0));

    		if($stmt->rowCount() > 0){
    			$this->id_image = $pdo->lastInsertId();
    			return true;
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }

    public function chooseKitten(){
    	$files = glob('assets/kittens/kitten_*.*');

		if ($files !== false){
		    $nb_kittens = count($files);
		}else{
		    $nb_kittens = 0;
		}
    	return $files[rand(0, $nb_kittens-1)];
    }

    public function generate(){
    	if(!empty($this->texte) && !empty($this->id_image)){
	    	/* Nom du kitten d'origine */
			$filename = $this->chooseKitten();

			/* Get extension du kitten d'origine */
			$imgInfo = getimagesize($filename);
			$srcWidth =  $imgInfo[0];
			$srcHeight = $imgInfo[1];
			$srcType   = $imgInfo[2];
			switch($srcType) { 
			    case 1 : $srcType = "gif"; break;
			    case 2 : $srcType = "jpeg"; break;
			    case 3 : $srcType = "png"; break;
			    default: $srcType = "???";
			}

			/* Définition du header */
			header("Content-Type: image/png");

			/* Compute new dimension */
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

			/* Getimage */
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

			/* Create output image */
			$outImg = imagecreatetruecolor ($outWidth, $outHeight);
			imagealphablending($outImg,false);
			imagesavealpha($outImg,true);

			/* Resize Image */
			imagecopyresampled($outImg, $im, 0, 0, 0, 0, $outWidth, $outHeight, $srcWidth, $srcHeight);

	 
			/* Create final image */
			$imgImg = imagecreatetruecolor ($imgWidth, $imgHeight);
			imagealphablending($imgImg,false);
			imagesavealpha($imgImg,true);

			imagecopyresampled($imgImg, $outImg, 0, 0, $crop_width, $crop_height, $outWidth, $outHeight, $outWidth, $outHeight);

			/* Création de quelques couleurs */
			$white = imagecolorallocate($im, 255, 255, 255);
			$grey_lite = imagecolorallocatealpha($im, 0, 0, 0, 110);
			$grey = imagecolorallocatealpha($im, 0, 0, 0, 70);
			$black = imagecolorallocatealpha($im, 0, 0, 0, 20);
			// imagefilledrectangle($im, 0, 0, 399, 29, $white);

			/* Le texte à dessiner */
			$text = $this->texte;
			// $text = wordwrap($text, 25, "\n");

			/* Fonts */
			$font = 'dist/fonts/grobold.ttf';
			$proxima = "dist/fonts/ProximaNovaBold.ttf";

			/* On remet la transparence */
			imagealphablending($imgImg, true);

			/* On crée le texte */
			$box = new \classe\Box($imgImg);
			$box->setFontFace($font);
			$box->setFontColor(new \classe\Color(255, 255, 255));
			$box->setTextShadow(new \classe\Color(0, 0, 0, 50), 2, 2);
			$box->setFontSize(80);
			$box->setLineHeight(1.2);
			// $box->enableDebug();
			$box->setBox(20, 30, 860, 500);
			$box->setTextAlign('center', 'center');
			$box->draw($text);

			/* Compute the coordinates pour centrer le # */
			$tb = imagettfbbox(17, 0, $proxima, "#SAYITWITHKITTENS");
			$x = ceil((900 - $tb[2]) / 2);

			/* Ajout du # */
			/* Ajout d'ombres au texte */
			imagettftext($imgImg, 17, 0, $x+3, 583, $grey_lite, $proxima, "#SAYITWITHKITTENS");
			imagettftext($imgImg, 17, 0, $x+2, 582, $grey, $proxima, "#SAYITWITHKITTENS");
			imagettftext($imgImg, 17, 0, $x+1, 581, $black, $proxima, "#SAYITWITHKITTENS");

			/* Ajout du texte */
			imagettftext($imgImg, 17, 0, $x+0, 580, $white, $proxima, "#SAYITWITHKITTENS");

			imagepng($imgImg, "assets/generate/".$this->id_image.".png");
			// imagepng($imgImg);
			imagedestroy($imgImg);
			return "assets/generate/".$this->id_image.".png";
		}else{
			return false;
		}

    }

    public function getIPCreator(){
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    public function setCookie($id_image){
    	if(!empty($id_image))
    		setcookie('Kitten_'.sha1($id_image) , sha1($id_image), time() + 3600 * 24 * 7 * 4 , '' , '' , false , true);
    }

    public function verifCookie($id_image){
    	if(!empty($id_image)){
    		if(isset($_COOKIE['Kitten_'.sha1($id_image)])){
    			return false;
    		}else{
    			return true;
    		}
    	}else{
    		return false;
    	}
    }

    public function likeKitten($id_image){
    	global $pdo;

    	if(!empty($id_image)){
    		if($this->verifCookie($id_image)){
    			$this->setCookie($id_image);

    			$sql = "SELECT likes FROM image WHERE id_image = ?";
    			$stmt = $pdo->prepare($sql);
    			$stmt->execute(array($id_image));

    			if($stmt->rowCount() > 0){
    				$res = $stmt->fetch(\PDO::FETCH_OBJ);

    				$sql = "UPDATE image SET likes = ? WHERE id_image = ?";
    				$stmt = $pdo->prepare($sql);
    				$stmt->execute(array($res->likes+1, $id_image));

    				return true;
    			}else{
    				return false;
    			}
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }

}