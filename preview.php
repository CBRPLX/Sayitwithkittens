<?php

include "inc/php/config.php";

if($_GET['id_image']){
	$pageController = new \controller\generalController();
	echo $pageController->genererPreview($_GET['id_image']);
}else{
	echo "Paramètre manquant";
}
?>