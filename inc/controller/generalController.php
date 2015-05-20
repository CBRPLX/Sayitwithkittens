<?php
namespace controller;
include 'inc/php/config.php';

class generalController {

	public function __construct () {
		
    }

    public function genererIndex(){
        global $twig;
        global $dev;

        $template = $twig->loadTemplate('index.html.twig');
        $contenu = $template->render(array());

        return $contenu;
    }

    public function genererGenerate(){
    	global $twig;
        global $dev;

        $image = new \classe\Image();
        $kitten_img = $image->chooseKitten();

        $template = $twig->loadTemplate('generate.html.twig');
        $contenu = $template->render(array(
        	'kitten_img' => $kitten_img
        ));

        return $contenu;
    }

    public function genererKitten($id_image){
        global $twig;
        global $dev;

        $template = $twig->loadTemplate('kitten.html.twig');
        $contenu = $template->render(array(
            'kitten_img' => sha1($id_image)
        ));

        return $contenu;
    }
}