<?php chdir('../../');
require "inc/php/config.php";

if(!empty($_POST['id_image'])){
	// if($mail){
		$u = new \classe\Upload();
		$u->set('id_upload', $_POST['id_image']);
		$u->load();
		$validate = $u->validate();
		if($validate != false){
			echo $validate;
		}else{
			echo "false";
		}
	// }else{
	// 	echo "false";
	// }
}else{
	echo "false";
}