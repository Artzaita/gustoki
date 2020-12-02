<?php 

session_start();

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';
include './_alert.php';


if (isset($_SESSION['firstName'])) {
	header('location:commande.php?lang='.$langue);
}


$request = 'SELECT *
			FROM gus_newDelivery';
$deliveries = fetchAllData($bdd, $request);

$request = 'SELECT * 
			FROM `gus_quest`';
$questions = fetchAllData($bdd, $request);

if (isset($_SESSION['basket'])) {
	$_SESSION['returnURL'] = 'panier.php?lang='.$langue;
} else {
	$_SESSION['returnURL'] = 'compte.php?lang='.$langue;
}

$returnURL = $_SESSION['returnURL'];




if ($_POST){


	if (isset($_POST['connexion'])) {
		

		$login = $_POST['mail'];
		$pswd = $_POST['paswd'];

		//test de l'existence du login

		$parameter = [$login];

		$request = 'SELECT *
					FROM `gus_cust`
					WHERE Cust_Mail = ?';

		$applicant = fetchData($bdd, $request, $parameter);

		

		if ($applicant == false) {
			$_SESSION['info'] = 'identifiant inconnu';
			header('location:connexion.php?lang='.$langue);
		} else {

			if ($pswd !== $applicant['Cust_Pswd']) {
				$_SESSION['info'] = 'connexion impossible';
				header('location:connexion.php?lang='.$langue);
			} else {
				
				$_SESSION['firstName'] = $applicant['Cust_FirstName'];
				$_SESSION['Name'] = $applicant['Cust_Name'];
				$_SESSION['Customer'] = $applicant['Cust_Number'];
				$_SESSION['Mail'] = $applicant['Cust_Mail'];
				$_SESSION['Civility'] = $applicant['Cust_Civility'];

				$parameter = [$applicant['Cust_Mail']];
				$request = 'SELECT * FROM `gus_chpswd` WHERE `Chpswd_Mail` = ?';

				$result = fetchData($bdd,$request,$parameter);

				if (isset($result)) {
					$request = 'DELETE FROM `gus_chpswd`
								WHERE `Chpswd_Mail`=?';

					$delete = deleteData($bdd,$request,$parameter);
	
				}

				if ($testURL == 0) {
					header('location:'.$returnURL);
				} else {
					header('location:commande.php?lang='.$langue);
				}
			}
		}
	}

	if (isset($_POST['creation'])) {




		$civility = $_POST['civility'];
		$firstName = $_POST['firstName'];
		$name = $_POST['name'];
		$login = $_POST['mail'];
		$pswd = $_POST['pswd'];
		$phone = $_POST['phone'];
		$dob = $_POST['DoB'];
		$address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$CP = $_POST['CP'];
		$village = $_POST['village'];
		$deliveryId = $_POST['delivery'];
		$questionId = $_POST['question'];
		$answer = $_POST['answer'];

		$request = 'SELECT * FROM `gus_last_cust_number`';
		$lastCust = fetchData($bdd,$request);
		$testCust = substr($lastCust['Last_Insertion'], 0, 8);
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		$custRoot = $year.$month.$day;

		if ($custRoot == $testCust) {
			$custNumber = $lastCust['Last_Insertion'] + 1;
		} else {
			$custNumber = $custRoot.'001';
		}

		$creationDate = date('Y-m-d');

		//test de l'existence du login

		$parameter = [$login];

		$request = 'SELECT *
					FROM `gus_cust`
					WHERE Cust_Mail = ?';

		$applicant = fetchData($bdd, $request, $parameter);

		if ($applicant == true) {
			$_SESSION['info'] = 'le mail est déjà raccordé à un compte existant';
			header('location:connexion.php?lang='.$langue);
		} else {
		
			$parameter = [$custNumber,$civility,$name,$firstName,$login,$pswd,$phone,$dob,$address1,$address2,$CP,$village,$creationDate,$deliveryId];


			$request = 'INSERT INTO `gus_cust`(`Cust_Number`, `Cust_Civility`, `Cust_Name`, `Cust_FirstName`, `Cust_Mail`, `Cust_Pswd`, `Cust_Phone`, `Cust_DoB`, `Cust_Address1`, `Cust_Address2`, `Cust_CP`, `Cust_City`, `Cust_Creation`, `Cust_Delivery_Id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
			$createCust = recordData($bdd,$request,$parameter);

			$parameter = [$custNumber];
			$request = 'UPDATE `gus_last_cust_number` SET `Last_Insertion`=? WHERE `Id`=1';
			$saveLastCust = updateData($bdd,$request,$parameter);

			$parameter = [$custNumber,$questionId,$answer];
			$request = 'INSERT INTO `gus_ans`(`Ans_Cust_Number`, `Ans_Quest_Id`, `Ans_Ans`) VALUES (?,?,?)';
			$ans = recordData($bdd,$request,$parameter);

			$_SESSION['firstName'] = $firstName;
			$_SESSION['Name'] = $name;
			$_SESSION['Customer'] = $custNumber;
			$_SESSION['Mail'] = $login;
			$_SESSION['Civility'] = $civility;

			header('location:connexion.php?lang='.$langue);

			} 
		}
	}










$template = 'connexion';
include 'view/layout.phtml';