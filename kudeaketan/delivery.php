<?php 


// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include '../model/db_connect.php';
include '../model/db_management.php';


if ($_POST) {
	$name = $_POST['Name'];
	$izena = $_POST['Izenburua'];
	$descr = $_POST['Description'];
	$deskr = $_POST['Deskribapen'];
	$type = $_POST['Type'];

	$parameter = [$name,$izena,$descr,$deskr,$type];

	$request = 'INSERT INTO `gus_delivery`(`Delivery_Name`, `Delivery_Izenburua`, `Delivery_Description`, `Delivery_Deskribapen`, `Delivery_Type`) VALUES (?,?,?,?,?)';

	$insert = recordData($bdd,$request,$parameter);
}

$request = 	'SELECT *
			FROM `gus_delivery`
			ORDER BY `Delivery_Name` ASC';

$deliveries = fetchAllData($bdd,$request);




$template = 'delivery';
include 'view/layout.phtml';