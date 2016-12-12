<?php

require 'inc/php/config.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'index');

    $r->addRoute('GET', '/index.php', 'redir-index');

    $r->addRoute('GET', '/upload/', 'upload');

    $r->addRoute('GET', '/generate/', 'generate');

    // {id_image} doit être un nombre (\d+)
    $r->addRoute('GET', '/preview/{id_image:\d+}/', 'preview');

    // {id_image} doit être un nombre (\d+)
    $r->addRoute('GET', '/cat/{id_image:\d+}/', 'kitten');

    // {id_upload} doit être un nombre (\d+)
    $r->addRoute('GET', '/verify/{id_upload:\d+}/', 'verify');
});

// On récupère la methode HTTP et l'url
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// On enlève les paramètres après ? puis on décode l'url
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

//On envoie l'url au dispatcher
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {

    // Si la route n'existe pas
    case FastRoute\Dispatcher::NOT_FOUND:
        echo "404";
        break;

    // Si la route est interdite
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo "405";
        break;

    // Si la route est bonne
    case FastRoute\Dispatcher::FOUND:
        // On récupère le nom de la route + ses paramètres
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // On appelle les bonnes methodes en fonction de la route
        switch ($handler) {

            // Index
            case 'index':
                $pageController = new \controller\generalController();
                echo $pageController->genererIndex();
                break;

            // Redirection sur l'index
            case 'redir-index':
                header("Location:/");
                break;

            // Upload
            case 'upload':
                $pageController = new \controller\generalController();
                echo $pageController->genererUpload();
                break;

            // Generate
            case 'generate':
                $pageController = new \controller\generalController();
                echo $pageController->genererGenerate();
                break;

            // Preview
            case 'preview':
                $pageController = new \controller\generalController();
                echo $pageController->genererPreview($vars["id_image"]);
                break;

            // Kitten
            case 'kitten':
                $pageController = new \controller\generalController();
                echo $pageController->genererKitten($vars["id_image"]);
                break;

            // Verify
            case 'verify':
                $pageController = new \controller\generalController();
                echo $pageController->genererValidate($vars["id_upload"]);
                break;
        }

        break;
}