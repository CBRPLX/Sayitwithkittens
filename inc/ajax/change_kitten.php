<?php chdir('../../');
require "inc/php/config.php";

$i = new \classe\Image();
while ($_POST['bg'] == $new_bg = $i->chooseKitten()) {
	
}
echo $new_bg;