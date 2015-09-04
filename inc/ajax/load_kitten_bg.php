<?php chdir('../../');
require "inc/php/config.php";

if(!empty($_POST['id_kitten'])){
	$i = new \classe\Image();
	$_SESSION['kitten_img'] = $i->chooseKitten($_POST['id_kitten']-1);
}else{
	echo 'false';
}