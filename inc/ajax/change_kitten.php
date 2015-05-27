<?php chdir('../../');
require "inc/php/config.php";

$i = new \classe\Image();
$nb_kitten = explode(".", explode("_", $_POST['bg'])[1])[0];
$new_bg = $i->chooseKitten($nb_kitten);
echo $new_bg;