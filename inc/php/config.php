<?php
header('Content-type: text/html; charset=utf-8');
setlocale (LC_TIME, 'fr_FR.utf8','fra', 'fr_FR');
ini_set('date.timezone', 'Europe/Paris');
session_start();

$dev = true;
if($_SERVER["SERVER_NAME"] == "sayitwithkittens.io" || $_SERVER["SERVER_NAME"] == "www.sayitwithkittens.io"){
	$dev = false;
}

if($dev || isset($_GET['dev']){
	ini_set('display_error', '1');
	error_reporting(E_ERROR | E_PARSE);
	$host = "sayitwithkittens.localhost";
}else{
	ini_set('display_error', '0');
	error_reporting(0);
	$host = "sayitwithkittens.io";
}

$refresh = false;
if(isset($_GET["refresh"])) $refresh = true;

require_once "vendor/autoload.php";
require_once "inc/php/pdo.php";

$loader = new \Twig_Loader_Filesystem('inc/template', 'Template');
$twig = new \Twig_Environment($loader, array('debug' => true));

if (isset($_GET['PHPSESSID'])){
	$requesturi = preg_replace('/?PHPSESSID=[^&]+/',"",$_SERVER['REQUEST_URI']);
	$requesturi = preg_replace('/&PHPSESSID=[^&]+/',"",$requesturi);
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: http://".$_SERVER['HTTP_HOST'].$requesturi);
	exit;
}