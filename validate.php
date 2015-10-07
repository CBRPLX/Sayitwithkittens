<?php

include "inc/php/config.php";

if($_GET['id_upload']){
	$pageController = new \controller\generalController();
	echo $pageController->genererValidate($_GET['id_upload']);
}