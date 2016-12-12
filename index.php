<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'inc/php/config.php';

$app = new \Slim\Slim();

$app->get('/', function () {
    $pageController = new \controller\generalController();
	echo $pageController->genererIndex();
})->name('index');

$app->get('/upload/', function () {
    $pageController = new \controller\generalController();
	echo $pageController->genererUpload();
});

$app->get('/generate/', function () {
    $pageController = new \controller\generalController();
	echo $pageController->genererGenerate();
});

$app->get('/preview/:id_image/', function ($id_image) {
	$pageController = new \controller\generalController();
	echo $pageController->genererPreview($id_image);
});

$app->get('/cat/:id_image/', function ($id_image) {
	$pageController = new \controller\generalController();
	echo $pageController->genererKitten($id_image);
});

$app->get('/verify/:id_upload/', function ($id_upload) {
	$pageController = new \controller\generalController();
	echo $pageController->genererValidate($id_upload);
});

$app->run();