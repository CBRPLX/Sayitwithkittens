<?php chdir('../../');
require "inc/php/config.php";

if(!empty($_POST['id_image'])){
	$i = new \classe\Image();
	$i->set('id_image', $_POST['id_image']);
	$i->load();

	if($i->moveFileFromPreview()){
		$i->setFileExist();
	}else{
		echo "false";
	}
}else{
	echo "false";
}