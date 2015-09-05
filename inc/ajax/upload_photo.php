<?php chdir("../../");
require "inc/php/config.php";

if(!empty($_POST["nom_upload"]) && !empty($_POST["email_upload"])){

	if(filter_var($_POST["email_upload"], FILTER_VALIDATE_EMAIL)){

		global $pdo;

		$sql = "INSERT INTO kitten_upload (nom_upload, email_upload) 
				VALUES (?,?)";

		$stmt = $pdo->prepare($sql);
		$stmt->execute(array($_POST["nom_upload"], $_POST["email_upload"]));

		if($stmt->rowCount() > 0){
			$last_insert = $pdo->lastInsertId();


			$uploaddir = 'assets/people';

			foreach($_FILES as $file){
				$file_name = pathinfo($file['name']);
				if(strtolower($file_name["extension"]) == "png" 
					|| strtolower($file_name["extension"]) == "jpg" 
					|| strtolower($file_name["extension"]) == "jpeg"
					|| strtolower($file_name["extension"]) == "gif"){

					if(move_uploaded_file($file['tmp_name'], $uploaddir ."/upload-".$_POST["email_upload"]."-".$last_insert.".".strtolower($file_name['extension']))){

						echo "true";
					}
				}else{
					echo "false";
				}
			}
		}else{
			echo "false";
		}

	}else{
		echo "false";
	}
}else{
	echo "false";
}