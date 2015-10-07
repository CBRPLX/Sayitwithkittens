<?php

include 'inc/php/config.php';

$e = new \controller\emailController();
echo $e->genererVerify(2, false, "Pornography");

// $i = new \classe\Image();
// $i->getRandomKitten();
// $i->getSize();
// var_dump($i);
// echo $i->get('texte');