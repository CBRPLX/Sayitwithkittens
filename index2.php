<?php

include 'inc/php/config.php';

ini_set('display_error', '1');
	error_reporting(E_ERROR | E_PARSE);

// $e = new \controller\emailController();
// echo $e->genererInscriptionNews("Paul");

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

// require 'PHPMailerAutoload.php';
 
$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->SMTPDebug   = 2;
$mail->Username = 'robin.pierrot@gmail.com';                   // SMTP username
$mail->Password = 'KAC381381521cbrplx';               // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
$mail->Port = 587;                                    //Set the SMTP port number - 587 for authenticated TLS
$mail->setFrom('hello@sayitwithkittens.io', 'Say it with kittens');     //Set who the message is to be sent from
$mail->addReplyTo('hello@sayitwithkittens.io', 'Say it with kittens');  //Set an alternative reply-to address
$mail->addAddress('cyberplix@gmail.com');  // Add a recipient
// $mail->addBCC('bcc@example.com');
// $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
// $mail->addAttachment('/usr/labnol/file.doc');         // Add attachments
// $mail->addAttachment('/images/image.jpg', 'new.jpg'); // Optional name
$mail->isHTML(true);                                  // Set email format to HTML
 
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
 
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
 echo "<br/><br/>";
if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}
 
echo 'Message has been sent';