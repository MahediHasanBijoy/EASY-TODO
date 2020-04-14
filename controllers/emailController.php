<?php 

require_once 'vendor/autoload.php';
require_once 'config/constants.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
  ->setUsername(Email)
  ->setPassword(password)
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);




function sendVerificationEmail($userEmail, $token){
	global $mailer;

	$body = '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Verify email</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<div class="wrapper">
		<p>
			Thank you for signing up on our website. Please click on the link below to verify your email.
		</p>
		<a href="http://localhost/projects/todo/homepage.php?token=' .$token. '" title="">
			Verify your email address
		</a>
	</div>
</body>
</html>';

	// Create a message
	$message = (new Swift_Message('Verify your email address'))
	  ->setFrom([Email => 'Bijoy'])
	  ->setTo($userEmail)
	  ->setBody($body, 'text/html');
	  ;

	// Send the message
	$result = $mailer->send($message);
}


// function for forgot password
function sendPasswordResetLink($userEmail,$token){
	global $mailer;

	$body = '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Verify email</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<div class="wrapper">
		<p>
			Hello there,

			Please click on the link below to reset your password.
		</p>
		<a href="http://localhost/projects/todo/homepage.php?password-token=' .$token. '" title="">
			Reset your password
		</a>
	</div>
</body>
</html>';

	// Create a message
	$message = (new Swift_Message('Reset your password'))
	  ->setFrom([Email => 'Bijoy'])
	  ->setTo($userEmail)
	  ->setBody($body, 'text/html');
	  ;

	// Send the message
	$result = $mailer->send($message);
}
