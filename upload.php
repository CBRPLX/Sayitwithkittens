<?php

include "inc/php/config.php";

$pageController = new \controller\generalController();
echo $pageController->genererUpload();

?>