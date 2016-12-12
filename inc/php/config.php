<?php
header('Content-type: text/html; charset=utf-8');
setlocale (LC_TIME, 'fr_FR.utf8','fra', 'fr_FR');
ini_set('date.timezone', 'Europe/Paris');

if(!isset($_SESSION)){ 
	session_start();
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

if(!empty($_GET["bg"])){
	$bg = new \classe\Image();
    $bg->chooseKitten($_GET["bg"]-1);;
}

$twig->addGlobal("host", "sayitwithkittens.io");