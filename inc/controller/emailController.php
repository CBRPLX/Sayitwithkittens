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

        $mail = new \PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.servermx.com';                       // Specify main and backup server
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        // $mail->SMTPDebug   = 3;
        $mail->Username = 'hello@sayitwithkittens.io';                   // SMTP username
        $mail->Password = 'KAC381381521cbrplx';               // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
        $mail->Port = 587;                                    //Set the SMTP port number - 587 for authenticated TLS

        $mail->setFrom('hello@sayitwithkittens.io', 'Say it with kittens');     //Set who the message is to be sent from
        $mail->addReplyTo('robin.pierrot@gmail.com', 'Robin Pierrot');  //Set an alternative reply-to address
        $mail->addBCC('hello@sayitwithkittens.io');
        $mail->addAddress($destinataire);  // Add a recipient

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $sujet;
        $mail->Body    = $texte;

        $res = $mail->send();


        return $res;
    }

    public function genererSquelette($contenu, $last = false){
    	global $twig;
    	global $dev;
        global $host;

        $template = $twig->load('email/email_squelette.html.twig');
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
        $template = $twig->load('email/inscription_news.html.twig');

        $contenu = $template->render(array(
            'nom' => ucfirst(strtolower($nom))
        ));

        return $this->genererSquelette($contenu, true);
    }

    public function genererNouvelleInscription($nom, $email){
        global $twig;
        global $dev;
        $template = $twig->load('email/new_inscription.html.twig');

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

        $template = $twig->load('email/post_upload.html.twig');
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

        $template = $twig->load('email/check_upload.html.twig');
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

        $template = $twig->load('email/verify.html.twig');
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