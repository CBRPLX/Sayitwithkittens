<?php chdir('../../');
require "inc/php/config.php";

$i = new \classe\Image();
$nb_kitten = explode("_", $_POST['bg']);
$nb_kitten = explode(".", $nb_kitten[1]);
$new_bg = $i->chooseKitten($nb_kitten[0]);
echo $new_bg;