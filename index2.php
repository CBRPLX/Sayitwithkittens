<?php

// include 'inc/php/config.php';

// ini_set('display_error', '1');
// 	error_reporting(E_ERROR | E_PARSE);

// // $e = new \controller\emailController();
// // echo $e->genererInscriptionNews("Paul");

// require_once "Mail.php";

// $from = "<hello@sayitwithkittens.io>";
// $to = "<cyberplix@gmail.com>";
// $subject = "Hi!";
// $body = "Hi,\n\nHow are you?";
// $host = "ssl://smtp.gmail.com";
// $port = "465";
// $username = "hello@sayitwithkittens.io";
// $password = "KAC000762";
// $headers = array ('From' => $from,
//   'To' => $to,
//   'Subject' => $subject);
// $smtp = Mail::factory('smtp',
//   array ('host' => $host,
//     'port' => $port,
//     'auth' => true,
//     'username' => $username,
//     'password' => $password));
// $mail = $smtp->send($to, $headers, $body);
// if (PEAR::isError($mail)) {
//   echo("<p>" . $mail->getMessage() . "</p>");
//  } else {
//   echo("<p>Message successfully sent!</p>");
//  }