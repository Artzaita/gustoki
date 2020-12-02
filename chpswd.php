<?php


session_start();

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';
include './_alert.php';

if (isset($_GET['login']) || isset($_POST)) {
	if ($_GET['login']) {
		
		$parameter = [$_GET['login']];

		$request = 'SELECT * FROM gus_chpswd WHERE Chpswd_Mail = ?';

		$test = fetchData($bdd,$request,$parameter);

		if ($test = false) {
			$_SESSION['info'] = "Courriel non reconnu.";
			header('location:index.php?lang='.$langue);
		}
	}

	if ($_POST) {

		$mail = $_POST['email'];
		$pswd = $_POST['pswd'];

		$parameter = [$pswd,$mail];

		$request = 'UPDATE `gus_cust` SET`Cust_Pswd`=? WHERE `Cust_Mail` = ?';

		$chpswd = updateData($bdd,$request,$parameter);

		$parameter = [$mail];

		$request = 'DELETE FROM `gus_chpswd`
					WHERE `Chpswd_Mail`=?';

		$delete = deleteData($bdd,$request,$parameter);

		switch ($langue) {
			case 'fr':
				$_SESSION['info'] = "Votre mot de passe a été modifié, veuillez vous reconnecter";
				break;
			
			default:
				$_SESSION['info'] = "Zure pasahitza aldatu da, hasi saioa berriro";
				break;
		}


		header('location:compte.php?lang='.$langue);

	}
} else {
	header('location:index.php?lang='.$langue);
}


$template = 'chpswd';
include 'view/layout.phtml';