<?php chdir('../../');
require "inc/php/config.php";

if(!empty($_POST['id_image'])){
	$e = new \controller\emailController();
	$contenu = $e->genererVerify($_POST['id_image']);
	$mail = $e->envoyerEmail('Say it with kittens <robin.pierrot@gmail.com>', "Your photo has been accepted", $contenu);

	if($mail){
		$u = new \classe\Upload();
		$u->set('id_upload', $_POST['id_image']);
		$u->load();
		$validate = $u->validate();
		if($validate != false){
			echo $validate;
		}else{
			echo "false";
		}
	}else{
		echo "false";
	}
}else{
	echo "false";
}