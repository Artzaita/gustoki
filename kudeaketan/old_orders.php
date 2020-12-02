<?php 



// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include '../model/db_connect.php';
include '../model/db_management.php';


$request = 'SELECT *
			FROM `gus_orders`
			INNER JOIN gus_delivery ON gus_orders.Order_Delivery_Id = gus_delivery.Delivery_Id';

$orders = fetchAllData($bdd,$request);

$actualWeek = date('W');


$file = fopen("export/listing_S$actualWeek.csv", 'w+');

$header = [
	'numéro de commande',
	'numéro client',
	'contenu de la commande',
	'montant',
	'date de la commande',
	'point de livraison'
];

fputcsv($file, $header, ";");

foreach ($orders as $order) {

	if ($order['Order_Week'] == $actualWeek) {

		$inProgressOrders = [
			$order['Order_Number'],
			$order['Order_Cust_Number'],
			$content = str_replace('<br>', '', $order['Order_Contents']),
			$order['Order_Total'],
			$order['Order_Date'],
			$order['Delivery_Name']
		];

		fputcsv($file, $inProgressOrders, ";");


	}


}

fclose($file);

















$template = 'orders';
include 'view/layout.phtml';