<?php
namespace classe;
include "inc/php/config.php";

class Upload{

	private $id_upload;
	private $nom_upload;
	private $email_upload;

	public function __construct () {
		
    }

    public function get($attr){
    	return $this->$attr;
    }

    public function set($attr, $value){
    	$this->$attr = $value;
    }

    public function load(){
        if(!empty($this->email_upload)){
            global $pdo;

            $sql = "SELECT * FROM kitten_upload WHERE email_upload = ? ORDER BY id_upload DESC LIMIT 0,1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($this->email_upload));

            if($stmt->rowCount() > 0){
                $res = $stmt->fetch(\PDO::FETCH_OBJ);

                foreach ($res as $k => $v) {
                    $this->$k = $v;
                }
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function getFilename(){
		$this->filename = "upload-".$this->email_upload."-".$this->id_upload;
    }

    public function isFileExist(){
        $img = glob('assets/people/'.$this->filename.'.*');

        if(count($img) > 0){
            $this->path = $img[0];
            return true;
        }else{
            return false;
        }
    }

}