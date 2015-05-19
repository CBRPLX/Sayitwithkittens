<?php
require_once "inc/php/config.php";

global $dev;
$pdo = null;
try{
	if($dev){
		$pdo = new PDO('mysql:host=127.0.0.1;dbname=cbrplx_io', 'root', 'root');
	}else{
		$pdo = new PDO('mysql:host=mysql51-77.perso;dbname=robinpieappart', 'robinpieappart', 'KAC000762');
	}
	$pdo->query('SET NAMES UTF8');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}catch (PDOException $e){
	echo 'Erreur : '.$e->getMessage().'<br />';
	echo 'N° : '.$e->getCode();
}