<?php

include "inc/php/config.php";

// $i = new \classe\Image();
// $i->set('texte', 'Sale batard de fils de pute je vais niquer ta maman, ta grand-mère et aussi tout tes petits rejetons sale pd de mes deux');
// $i->set('pseudo', 'Je te love Jeanne d\'Arc');
// // $i->add();
// // $file = $i->generate();

// // echo '<img src="'.$file.'" />';

// var_dump($i->likeKitten(1));

if($_GET['id_image']){
	$pageController = new \controller\generalController();
	echo $pageController->genererKitten($_GET['id_image']);
}
?>