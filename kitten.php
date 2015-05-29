<?php

include "inc/php/config.php";

if($_GET['id_image']){
	$pageController = new \controller\generalController();
	echo $pageController->genererKitten($_GET['id_image']);
}
?>