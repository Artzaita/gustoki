<?php 



// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include '../model/db_connect.php';
include '../model/db_management.php';


$request = 'SELECT * FROM `gus_cust`';
$customers = fetchAllData($bdd,$request);


if ($_POST) {
	if (isset($_POST['delete'])) {
		$parameter = [$_POST['Id']];
		$request = 'DELETE FROM `gus_cust` WHERE `Cust_Id`=?';
		$deleteCust = deleteData($bdd,$request,$parameter);
	}
}



$template = 'client';
include 'view/layout.phtml';