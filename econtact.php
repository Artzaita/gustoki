<?php 


require ('root.php');

$drapeau = "contact";
$ikurrin = "kontaktua";

if ($_POST) {
	
	$lastName = $_POST['LastName'];
	
	$firstName = $_POST['FirstName'];

	$mail = $_POST['Mail'];

	$motif = $_POST['Motif'];
	
	$message = $_POST['Message'];

	// création d'un mail à l'intention de l'administrateur pour l'informer d'une demande de contact

	$to = 'gustoki@gustoki.com';

	$subject = 'Demande de contact depuis le site internet';

	$body = "Nom = $lastName \r\n";
	$body .= "Prénom = $firstName \r\n";
	$body .= "Courriel = $mail \r\n";
	$body .= "Message = $message \r\n";

	$headers = "From: contact@gustoki.com \r\n";
	$headers .= "Content-type: text/plain; charset=UTF-8 \r\n";

	mail($to, $subject, $body, $headers);

}


$template = 'contact';
include 'view/layout.phtml';

