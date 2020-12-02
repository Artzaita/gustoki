<?php 



// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include '../model/db_connect.php';
include '../model/db_management.php';

// connexion à la classe phpspeadsheet

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$actualWeek = date('W');

$date = date_create();

date_timestamp_set($date, strtotime('last tuesday'));

$lastTuesday = date_format($date, 'Y-m-d');

$parameter = [$lastTuesday];


$request = 'SELECT *
			FROM `gus_manorder`
			INNER JOIN gus_newDelivery ON gus_manorder.ManOrder_Delivery_Id = gus_newDelivery.Delivery_Id
			INNER JOIN gus_cust ON gus_manorder.ManOrder_Cust_Number = gus_cust.Cust_Number
			INNER JOIN gus_product ON gus_manorder.ManOrder_Product_Id = gus_product.Product_Id
			WHERE gus_manorder.ManOrder_Date > ?
			ORDER BY `ManOrder_Product` ASC';

$orders = fetchAllData($bdd,$request,$parameter);

$request = 'SELECT *, SUM(`ManOrder_Quantity`) AS Total
			FROM `gus_manorder`
			INNER JOIN gus_product ON gus_manorder.ManOrder_Product_Id = gus_product.Product_Id
			WHERE gus_manorder.ManOrder_Date > ?
			GROUP BY `ManOrder_Product`
			ORDER BY `ManOrder_Product` ASC';

$products = fetchAllData($bdd,$request,$parameter);



$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Listing commandes');
$sheet->setCellValue('A1', 'Référence')
		->setCellValue('B1', 'produit')
		->setCellValue('C1', 'quantité')
		->setCellValue('D1', 'nom du client')
		->setCellValue('E1', 'date de commande')
		->setCellValue('F1', 'numéro de commande')
		->setCellValue('G1', 'numéro client')
		->setCellValue('H1', 'point de livraison');

$line = 2;

foreach ($orders as $order) {
	$sheet->setCellValue('A'.$line, $order['ManOrder_Product_Id'])
			->setCellValue('B'.$line, $order['Title'].' / '. $order['Izenburua'])
			->setCellValue('C'.$line, $order['ManOrder_Quantity'])
			->setCellValue('D'.$line, $order['Cust_Name'].' '.$order['Cust_FirstName'])
			->setCellValue('E'.$line, $order['ManOrder_Date'])
			->setCellValue('F'.$line, $order['ManOrder_Order_Number'])
			->setCellValue('G'.$line, $order['ManOrder_Cust_Number'])
			->setCellValue('H'.$line, $order['Delivery_Name']);
	$line++;
};

$sheet2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Listing Produits');
$spreadsheet->addSheet($sheet2, 1);
$sheet2->setCellValue('A1', 'Référence')
		->setCellValue('B1', 'Produits')
		->setCellValue('C1', 'Quantité');

$line = 2;

foreach ($products as $product) {
	$sheet2->setCellValue('A'.$line, $product['ManOrder_Product_Id'])
			->setCellValue('B'.$line, $product['Title'].' / '. $product['Izenburua'])
			->setCellValue('C'.$line, $product['Total']);
	$line++;
};


$writer = new Xlsx($spreadsheet);
$writer->save('export/listing_S'.$actualWeek.'.xlsx');







/*$file = fopen("export/listing_S$actualWeek.csv", 'w+');

$header = [
	'numéro de commande',
	'numéro client',
	'nom du client',
	'Produit',
	'Quantité',
	'date de la commande',
	'point de livraison'
];

fputcsv($file, $header, ";");

foreach ($orders as $order) {
	if ($order['ManOrder_Week'] == $actualWeek) {
			$inProgressOrders = [
				$order['ManOrder_Order_Number'],
				$order['ManOrder_Cust_Number'],
				$order['Cust_Name'].' '.$order['Cust_FirstName'],
				$order['ManOrder_Product'],
				$order['ManOrder_Quantity'],
				$order['ManOrder_Date'],
				$order['Delivery_Name']
			];

			fputcsv($file, $inProgressOrders, ";");
	}
}

fclose($file);*/



//$parameter = [$actualWeek];

$request = 'SELECT `Order_Number`,`Order_Cust_Number`,`Order_Contents`,`Order_Total`,`Order_Date`,gus_newDelivery.Delivery_Name
			FROM `gus_orders`
			INNER JOIN gus_newDelivery ON gus_orders.Order_Delivery_Id = gus_newDelivery.Delivery_Id
			/*WHERE `Order_Week`=?*/';

$oldOrders = fetchAllData($bdd,$request,$parameter);
















$template = 'orders';
include 'view/layout.phtml';