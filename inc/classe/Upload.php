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
        if(!empty($this->id_upload)){
            global $pdo;

            $sql = "SELECT * FROM kitten_upload WHERE id_upload = ? LIMIT 0,1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($this->id_upload));

            if($stmt->rowCount() > 0){
                $res = $stmt->fetch(\PDO::FETCH_OBJ);

                foreach ($res as $k => $v) {
                    $this->$k = $v;
                }
            }else{
                return false;
            }
        }elseif(!empty($this->email_upload)){
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

    public function validate(){
        $this->getFilename();
        if($this->isFileExist()){

            $dir = "assets/kittens/kitten_*.jpg";
            $files = glob($dir);

            if($files != false){
                $files = count($files);

                /* Get extension du kitten uploadé */
                $imgInfo = getimagesize($this->path);
                $srcWidth =  $imgInfo[0];
                $srcHeight = $imgInfo[1];
                $srcType   = $imgInfo[2];
                switch($srcType) { 
                    case 1 : $srcType = "gif"; break;
                    case 2 : $srcType = "jpeg"; break;
                    case 3 : $srcType = "png"; break;
                    default: $srcType = "???";
                }

                /* Create jpg */
                switch ($srcType) {
                    case 'gif':
                        $im = imagecreatefromgif($this->path);
                        break;
                    case 'jpeg':
                        $im = imagecreatefromjpeg($this->path);
                        break;
                    case 'png':
                        $im = imagecreatefrompng($this->path);
                        break;
                    
                    default:
                        break;
                }
                if($im != false){
                    $jpg = imagejpeg($im, "assets/kittens/kitten_".$files.".jpg");

                    if($jpg){
                        $del = unlink($this->path);

                        if($del){
                            global $pdo;

                            $sql = "UPDATE kitten_upload SET validate = 1, id_kitten = ? WHERE id_upload = ?;";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(array($files, $this->id_upload));

                            return $files;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}