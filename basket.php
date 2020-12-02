<?php 

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';

include './model/basket_management.php';




if ($_POST) {
	$get = "";
	
	if (isset($_POST['modify'])) {
		modifyBasket($_POST['Id_Product'],$_POST['Quantity_Product']);
	}
	
	if (isset($_POST['addBasket'])) {

		if (isset($_POST['medWeight'])) {

			addBasket($_POST['addBasket'],$_POST['medWeight']*$_POST['quantity']);

		} else {

			addBasket($_POST['addBasket'],$_POST['quantity']);

		}

		$get = "#".$_POST['addBasket'];
	}

	if (isset($_POST['delete'])) {
		deleteProduct($_POST['Id_Product']);
	}
	$redirect = $_SERVER['HTTP_REFERER'].$get;
	header("Location: ".$redirect);
} else {
	header("Location: index.php");
}