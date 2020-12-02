<?php 

session_start();

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';

if (!isset($_SESSION['firstName'])) {
	header('location:connexion.php?lang='.$langue);
}


$custNum = $_SESSION['Customer'];

$parameter = [$custNum];
$request = 'SELECT * 
			FROM `gus_cust` 
			INNER JOIN gus_newDelivery ON gus_cust.Cust_Delivery_Id = gus_newDelivery.Delivery_Id 
			WHERE Cust_Number = ?';
$customer = fetchData($bdd, $request, $parameter);

$request = 'SELECT *
			FROM gus_newDelivery';

$deliveries = fetchAllData($bdd, $request);


if ($_POST) {

	if (isset($_POST['modification'])) {

		$civility = $_POST['civility'];
		$firstName = $_POST['firstName'];
		$name = $_POST['name'];
		$login = $_POST['mail'];
		$phone = $_POST['phone'];
		$dob = $_POST['DoB'];
		$address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$CP = $_POST['CP'];
		$village = $_POST['village'];
		$deliveryId = $_POST['delivery'];

		$parameter = [$civility,$name,$firstName,$login,$phone,$dob,$address1,$address2,$CP,$village,$deliveryId,$custNum];
		$request = 'UPDATE `gus_cust` SET `Cust_Civility`=?,`Cust_Name`=?,`Cust_FirstName`=?,`Cust_Mail`=?,`Cust_Phone`=?,`Cust_DoB`=?,`Cust_Address1`=?,`Cust_Address2`=?,`Cust_CP`=?,`Cust_City`=?, `Cust_Delivery_Id`=? WHERE `Cust_Number`=?';
		$query = updateData($bdd,$request,$parameter);

/*		switch ($langue) {
			case 'fr':
				header('location:compte.php?lang=fr');
				break;
			
			default:
				header('location:compte.php?lang=eus');
				break;
		}*/

		header('location:compte.php?lang='.$langue);

	}

	if (isset($_POST['delete'])) {

		$parameter = ['custNum'];
		$request = 'DELETE 
					FROM gus_cust
					WHERE Cust_Number = ?';
		$query = deleteData($bdd,$request,$parameter);

		header('location:deconnexion.php');
	}

	if (isset($_POST['newPswd'])) {

		$parameter = [$_POST['newPswd1'],$custNum];
		$request = 'UPDATE `gus_cust`
					SET `Cust_Pswd`=?
					WHERE `Cust_Number`=?';
		$query = updateData($bdd,$request,$parameter);

		$_SESSION['info'] = "Votre mot de passe a été modifié";
	}
}


$template = 'compte';
include 'view/layout.phtml';