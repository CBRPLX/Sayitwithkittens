<?php chdir('../../');
require "inc/php/config.php";

if(!empty($_POST['pseudo']) && !empty($_POST['texte']) && !empty($_POST['kitten'])){
	$id_kitten = explode("_", $_POST['kitten']);
	$id_kitten = explode(".", $id_kitten[1]);
	$id_kitten = $id_kitten[0];
	// var_dump($id_kitten);
	$i = new \classe\Image();
	$i->set('id_kitten', $id_kitten);
	$i->set('texte', $_POST['texte']);
	$i->set('pseudo', $_POST['pseudo']);

	$count = null;
	$kitten = preg_replace('/"|\\\\/i', '', $_POST['kitten'], -1, $count);

	if($i->add()){
		$i->generate($kitten);
		echo $i->get('id_image');
	}else{
		echo 'false';
	}
}else{
	echo 'false';
}