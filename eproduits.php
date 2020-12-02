<?php 

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';


$request = 'SELECT * FROM `gus_category`';
$categories = fetchAllData($bdd,$request);


if (!isset($_GET['catid'])) {

	$cat = 'Tous les produits';
	$kat = 'Ekoizpen guztiak';

	$parameter = [];

	$request = 'SELECT *
			FROM `gus_product`
			INNER JOIN gus_category ON gus_product.Product_Category_Id = gus_category.Id
			INNER JOIN gus_photo ON gus_product.Product_Photo_Id = gus_photo.Id
			INNER JOIN gus_unity ON gus_product.Unity_Id = gus_unity.Id
			INNER JOIN gus_producer ON gus_product.Producer_Id = gus_producer.Producer_Id
			WHERE 1
			ORDER BY gus_product.Title ASC';

} elseif (isset($_GET['catid']) && is_numeric($_GET['catid'])) {
	
	$parameter = [$_GET['catid']];

	$request = 'SELECT *
				FROM `gus_category`
				WHERE `Id`=?';

	$query = fetchData($bdd,$request,$parameter);

	$cat = $query['Category'];
	$kat = $query['Kategoria'];

	$parameter = [$_GET['catid']];

	$request = 'SELECT *
			FROM `gus_product`
			INNER JOIN gus_category ON gus_product.Product_Category_Id = gus_category.Id
			INNER JOIN gus_photo ON gus_product.Product_Photo_Id = gus_photo.Id
			INNER JOIN gus_unity ON gus_product.Unity_Id = gus_unity.Id
			INNER JOIN gus_producer ON gus_product.Producer_Id = gus_producer.Producer_Id
			WHERE Product_Category_Id=?
			ORDER BY gus_product.Title ASC';

	}


	


	$products = fetchAllData($bdd,$request,$parameter);



if (isset($query['Id'])) {
	$drapeau = str_replace(' ', '-', $cat);
	$ikurrin = str_replace(' ', '-', $kat);
} else {
	$drapeau = "produits";
	$ikurrin = "ekoizpenak";
}



$template = 'produits';
include 'view/layout.phtml';