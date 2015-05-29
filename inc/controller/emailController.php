<?php
namespace controller;
include 'inc/php/config.php';

class emailController {

	public function __construct () {
		
    }

    /**
     * Pour envoyer un mail, il faut appeller la fonction "genererXXXX" que l'on souhaite parmis celles ci-dessous.
     * Le code de l'email complet sera retourné.
     * Puis, appeller la fonction envoyerEmail, en indiquant l'expediteur, le destinataire, le sujet, puis le texte (code retourné avant).
     * Un booléan est retourné pour connaitre le resultat de l'opération
     */
    public function envoyerEmail($destinataire, $sujet, $texte) {
        global $pdo;

        $headers = "MIME-Version: 1.0 \n";
        $headers .= "Content-Transfer-Encoding: 8bit \n";
        $headers .= "Content-type: text/html; charset=UTF-8 \n";
        $headers .= "From: cbrplx.io <robin.pierrot@gmail.com>  \n";
        $headers .= "Bcc: cbrplx.io <cyberplix@gmail.com>  \n";
        $headers .="Reply-To: cbrplx.io <robin.pierrot@gmail.com> \n";

        $res = mail($destinataire, $sujet, $texte, $headers);
        return $res;
    }

    public function genererSquelette($contenu, $last = false){
    	global $twig;
    	global $dev;
        $template = $twig->loadTemplate('email/email_squelette.html.twig');

        $image = new \classe\Image();
        $image->getRandomKitten();

        $texte_filename = explode(" ", strtolower($image->get('texte')));
        $image->set('img', implode("_", $texte_filename));

        return $template->render(array(
            "contenu" => $contenu,
            "image" => $image,
            "last" => $last
        ));
    }

    public function genererInscriptionNews($nom){
        global $twig;
        global $dev;
        $template = $twig->loadTemplate('email/inscription_news.html.twig');

        $contenu = $template->render(array(
            'nom' => ucfirst(strtolower($nom))
        ));

        return $this->genererSquelette($contenu, true);
    }

    public function genererNouvelleInscription($nom, $email){
        global $twig;
        global $dev;
        $template = $twig->loadTemplate('email/new_inscription.html.twig');

        $contenu = $template->render(array(
            'nom' => $nom,
            'email' => $email
        ));

        return $this->genererSquelette($contenu);
    }
}