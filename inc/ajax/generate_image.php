<?php chdir('../../');
require "inc/php/config.php";

if(!empty($_POST['pseudo']) && !empty($_POST['texte']) && !empty($_POST['kitten'])){
	$i = new \classe\Image();
	$i->set('texte', $_POST['texte']);
	$i->set('pseudo', $_POST['pseudo']);
	if($i->add()){
		$i->generate($_POST['kitten']);
		echo $i->get('id_image');
	}else{
		echo 'false';
	}
}else{
	echo 'false';
}