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

        $headers = 'MIME-Version: 1.0 '."\r\n";
        $headers .= 'Content-Transfer-Encoding: 8bit '."\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8 '."\r\n";
        $headers .= 'From: Say it with kittens <hello@sayitwithkittens.io>  '."\r\n";
        $headers .= 'Bcc: hello.cbrplx@gmail.com  '."\r\n";
        $headers .= 'Reply-To: Say it with kittens <hello@sayitwithkittens.io> '."\r\n";

        $res = mail($destinataire, $sujet, $texte, $headers, "-f hello@sayitwithkittens.io");
        return $res;
    }

    public function genererSquelette($contenu, $last = false){
    	global $twig;
    	global $dev;
        global $host;

        $template = $twig->loadTemplate('email/email_squelette.html.twig');
        $twig->addGlobal('host', $host);
        
        $image = new \classe\Image();
        $image->getMostLikedKitten();
        $image->getFilename();

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

    public function genererPostUpload($email){
        global $twig;
        global $dev;
        global $host;

        $template = $twig->loadTemplate('email/post_upload.html.twig');
        $twig->addGlobal('host', $host);

        $upload = new \classe\Upload();
        $upload->set('email_upload', $email);
        $upload->load();
        $upload->getFilename();
        
        if(!$upload->isFileExist()){
            $upload = false;
        }

        $contenu = $template->render(array(
            'upload' => $upload
        ));

        return $this->genererSquelette($contenu, true);
    }

    public function genererCheckUpload($email){
        global $twig;
        global $dev;
        global $host;

        $template = $twig->loadTemplate('email/check_upload.html.twig');
        $twig->addGlobal('host', $host);

        $upload = new \classe\Upload();
        $upload->set('email_upload', $email);
        $upload->load();
        $upload->getFilename();
        
        if(!$upload->isFileExist()){
            $upload = false;
        }

        $contenu = $template->render(array(
            'upload' => $upload
        ));

        return $this->genererSquelette($contenu, true);
    }

    public function genererVerify($id_upload, $accept = true, $reason = ""){
        global $twig;
        global $dev;
        global $host;

        $template = $twig->loadTemplate('email/verify.html.twig');
        $twig->addGlobal('host', $host);

        $i = new \classe\Upload();
        $i->set('id_upload', $id_upload);
        $i->load();
        $i->getFilename();

        if($i->isFileExist()){

            $contenu = $template->render(array(
                'upload' => $i,
                'accept' => $accept,
                'reason' => $reason
            ));

            return $this->genererSquelette($contenu, true);
        }

        
    }
}