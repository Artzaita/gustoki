<?php 

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';

// récupération de la liste 
$request = 'SELECT *
			FROM `gus_producer`';
$producers = fetchAllData($bdd,$request);

$id = "";

if (isset($_GET['prodid']) && is_numeric($_GET['prodid'])) {
	$parameter = [$_GET['prodid']];
	$request = 'SELECT *
				FROM `gus_producer`
				INNER JOIN gus_photo ON gus_producer.Producer_Photo_Id=gus_photo.Id
				WHERE `Producer_Id` = ?';
	$producteur = fetchData($bdd,$request,$parameter);

	$request = 'SELECT *
				FROM `gus_product`
				INNER JOIN gus_photo ON gus_product.Product_Photo_Id=gus_photo.Id
				INNER JOIN gus_category ON gus_product.Product_Category_Id=gus_category.Id
				WHERE `Producer_Id` = ?';
	$products = fetchAllData($bdd,$request,$parameter);

	$id = "&prodid=".$_GET['prodid'];
}

$drapeau = "producteurs.php?lang=fr".$id;
$ikurrin = "producteurs.php?lang=eus".$id;

$template = 'producteurs';
include 'view/layout.phtml';