<?php 

session_start();

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';


if (!isset($_SESSION['firstName'])) {
	header('location:index.php');
}

$products = $_SESSION['panier'];

$parameter= [$_SESSION['Customer']];

$deliveries = fetchAllData($bdd, $request);

$request = 'SELECT * 
			FROM `gus_cust` 
			INNER JOIN gus_newDelivery ON gus_cust.Cust_Delivery_Id = gus_newDelivery.Delivery_Id 
			WHERE Cust_Number = ?';
$customer = fetchData($bdd, $request, $parameter);

$request = 'SELECT * FROM `gus_newDelivery`';

$deliveries = fetchAllData($bdd, $request);








$template = 'commande';
include 'view/layout.phtml';
