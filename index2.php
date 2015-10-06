<?php

include 'inc/php/config.php';

// $e = new \controller\emailController();
// echo $e->genererPostUpload("robin.pierrot@gmail.com");

$i = new \classe\Image();
$i->getRandomKitten();
$i->getSize();
var_dump($i);
// echo $i->get('texte');