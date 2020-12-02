<?php 

session_start();

require ('root.php');


// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';
include './_alert.php';


$drapeau = "accueil";
$ikurrin = "harrera";

$current = $_SERVER['SCRIPT_NAME'];



$request = "SELECT *
			FROM `gus_product`
			INNER JOIN gus_photo ON gus_product.Product_Photo_Id = gus_photo.Id
			INNER JOIN gus_category ON gus_product.Product_Category_Id = gus_category.Id
			WHERE `Product_Promotion` = 'oui'";
$productPromotion = fetchData($bdd,$request);

$request = "SELECT *
			FROM `gus_producer`
			INNER JOIN gus_photo ON gus_producer.Producer_Photo_Id = gus_photo.Id
			WHERE `Producer_Promotion` = 'oui'";
$producerPromotion = fetchData($bdd,$request);




$template = 'index';
include 'view/layout.phtml';

