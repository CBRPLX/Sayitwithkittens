<?php chdir('../../');
require "inc/php/config.php";

if(!empty($_POST['id_image']) && !empty($_POST['reason'])){

	// $e = new \controller\emailController();
	// $contenu = $e->genererVerify($_POST['id_image'], false, $_POST['id_reason']);
	// $mail = $e->envoyerEmail('Say it with kittens <robin.pierrot@gmail.com>', "Your photo has been rejected", $contenu);

	// if($mail){
		$u = new \classe\Upload();
		$u->set('id_upload', $_POST['id_image']);
		$u->load();
		$reject = $u->reject($_POST['reason']);
		if($reject != false){
			echo "";
		}else{
			echo "false";
		}
	// }else{
	// 	echo "false";
	// }
}else{
	echo "false";
}