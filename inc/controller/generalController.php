<?php
namespace controller;
include 'inc/php/config.php';

class generalController {

	public function __construct () {
		
    }

    public function genererIndex(){
        global $twig;
        global $dev;

        $kitten_img = "";
        if(!empty($_SESSION['kitten_img']))
            $kitten_img = $_SESSION['kitten_img'];

        $template = $twig->loadTemplate('index.html.twig');
        $contenu = $template->render(array(
            'kitten_img' => $kitten_img
        ));

        return $contenu;
    }

    public function genererGenerate(){
    	global $twig;
        global $dev;

        $kitten_img = "";
        if(!empty($_SESSION['kitten_img']))
            $kitten_img = $_SESSION['kitten_img'];

        $template = $twig->loadTemplate('generate.html.twig');
        $contenu = $template->render(array(
        	'kitten_img' => $kitten_img
        ));

        return $contenu;
    }

    public function genererKitten($id_image){
        global $twig;
        global $dev;

        $i = new \classe\Image();
        $i->set('id_image', $id_image);
        $i->load();

        // $kitten_bg = "";
        if(isset($_SESSION['kitten_img']))
            unset($_SESSION['kitten_img']);

        $template = $twig->loadTemplate('kitten.html.twig');
        $contenu = $template->render(array(
            'kitten_img' => sha1($id_image),
            'img' => $i
        ));

        return $contenu;
    }
}