<?php
namespace classe;

class Newsletter{

	private $id_newsletter;
	private $nom;
	private $email;
	private $date_inscription;

	public function __construct () {
		
    }

    public function get($attr){
    	return $this->$attr;
    }

    public function set($attr, $value){
    	$this->$attr = $value;
    }

    public function add($nom, $email){
        global $pdo;

        $sql = "SELECT * FROM kitten_newsletter WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($email));

        if($stmt->rowCount() == 0){
            $sql = "INSERT INTO kitten_newsletter (nom, email, date_inscription) 
                    VALUES (?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($nom, $email, time()));
            if($stmt->rowCount() > 0){                
                $pageController = new \controller\emailController();
                $contenu = $pageController->genererInscriptionNews($_POST["nom"]);
                
                // $destinataire = ucfirst(strtolower($_POST["nom"]))." <".$_POST["email"].">";
                $pageController->envoyerEmail($_POST["email"], "Subscription to the newsletter", $contenu);

                $contenu = $pageController->genererNouvelleInscription($_POST["nom"], $_POST["email"]);
                $pageController->envoyerEmail('Say it with kittens <robin.pierrot@gmail.com>', "New subscription to the newsletter Sayitwithkittens.io", $contenu);

                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}