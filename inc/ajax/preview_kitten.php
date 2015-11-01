<?php chdir('../../');
require "inc/php/config.php";

if(!empty($_POST['id_image'])){
	// if($mail){
		$u = new \classe\Image();
		$u->set('id_image', $_POST['id_image']);
		$u->load();
		$validate = $u->validatePreview();
		if($validate != false){
			echo "";
		}else{
			echo "false1";
		}
	// }else{
	// 	echo "false";
	// }
}else{
	echo "false";
}