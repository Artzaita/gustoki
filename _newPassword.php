<?php 


session_start();

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';
include './_alert.php';


$mail = $_POST['email'];


$parameter = [$mail];

$request = 'SELECT * FROM `gus_chpswd` WHERE `Chpswd_Mail` = ?';

$result = fetchData($bdd,$request,$parameter);


if ($result == false) {
	$request = 'INSERT INTO `gus_chpswd`(`Chpswd_Mail`) VALUES (?)';

	$insert = recordData($bdd,$request,$parameter);
	
}

// préparation du mail de réinitialisation du mot de passe
$to = $mail;

switch ($langue) {
	case 'fr':
		$subject = "Réinitialisation de votre mot de passe";

		$body = "Bonjour, vous avez demandé à réinitialiser votre mot de passe sur le site Gustoki. \r\n";
		$body .= "Pour cela, vous pouvez cliquer sur le lien ci-dessous : \r\n";
		$body .= "<a href='http://gustoki.larrun-prod.com/chpswd.php?lang=fr&login=".$mail."'>réinitialiser le mot de passe</a> \r\n";
		$body .= "Si vous n'êtes pas à l'origine de cette procédure, veuillez ne pas tenir compte de ce courriel. \r\n";
		$body .= "Merci de votre confiance.\r\n";
		$body .= "A bientôt sur Gustoki.\r\n";

		$headers = "From: gustoki@gustoki.com\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8 \r\n";

		break;
	
	default:
		$subject = "Zure pasahitza berrezartzea";

		$body = "Agur, zure pasahitza berrezartzeko eskatu duzu Gustoki gunean. \r\n";
		$body .= "Horretarako beheko estekan klik egin dezakezu : \r\n";
		$body .= "<a href='http://gustoki.larrun-prod.com/chpswd.php?lang=eus&login=".$mail."'>pasahitza berrezarri</a> \r\n";
		$body .= "Prozedura honen hasiera ez bazara, mesedez ez ikusi mezu elektroniko hau. \r\n";
		$body .= "Milesker zure konfiantzagatik.\r\n";
		$body .= "Laster ikusiko dugu Gustokin.\r\n";

		break;
}

$headers = "From: gustoki@gustoki.com\r\n";
$headers .= "Content-type: text/html; charset=UTF-8 \r\n";

mail($to, $subject, $body, $headers);


echo 'Success';

 ?>