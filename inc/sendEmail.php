﻿<?php

// Replace this with your own email address
$siteOwnersEmail = 'nycholas@live.com';

if($_POST) {

	$name = trim(stripslashes($_POST['contactName']));
	$email = trim(stripslashes($_POST['contactEmail']));
	$subject = trim(stripslashes($_POST['contactSubject']));
	$contact_message = trim(stripslashes($_POST['contactMessage']));
	$error = array();

	// Check Name
	if (strlen($name) < 2) {
		$error['name'] = "Por favor, informe seu nome.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Entre com um endereço de email válido.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Sua mensagem deve ter ao menos 15 caracteres.";
	}
	// Subject
	if ($subject == '') {
		$subject = "Contact Form Submission";
	}


	// Set Message
	$message = "Email from: " . $name . "<br />";
	$message .= "Email address: " . $email . "<br />";
	$message .= "Message: <br />";
	$message .= $contact_message;
	$message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

	// Set From: header
	$from =  $name . " <" . $email . ">";

	// Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


	if ( empty($error) ) {

		ini_set("sendmail_from", $siteOwnersEmail); // for windows server
		$mail = mail($siteOwnersEmail, $subject, $message, $headers);

		if ($mail) {
			$error['OK'] = "done";
			echo json_encode($error);
		} else {
			$error['sending'] = "Something went wrong. Please try again.";
			echo json_encode($error);
		}

	} # end if - no validation error

	else {

		echo json_encode($error);

	} # end else - there was a validation error

}

?>