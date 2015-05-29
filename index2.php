<?php

include 'inc/php/config.php';

$e = new \controller\emailController();

echo $e->genererInscriptionNews("Robert");

// $i = new \classe\Image();
// $i->getRandomKitten();