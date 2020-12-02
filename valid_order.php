<?php 

session_start();

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';


if (!isset($_POST)) {
	header('location:index.php?lang='.$langue);
}

$idDelivery = $_POST['delivery'];

$parameter = ['$idDelivery'];
$request = 'SELECT * 
			FROM `gus_newDelivery` 
			WHERE `Delivery_Id`=?';
$deliveryPoint = fetchData($bdd,$request,$parameter);
$delivery = $deliveryPoint['Delivery_Name'];


$products = $_SESSION['panier'];

$request = 'SELECT * FROM `gus_last_order_number`';

$lastOrder = fetchData($bdd,$request);

$testOrder = substr($lastOrder['Last_Insertion'], 0, 8);

$mail = $_SESSION['Mail'];
$firstName = $_SESSION['firstName'];
$name = $_SESSION['Name'];
$civility = $_SESSION['Civility'];
$year = date('Y');
$month = date('m');
$day = date('d');
$orderRoot = $year.$month.$day;

if ($orderRoot == $testOrder) {
	$orderNumber = $lastOrder['Last_Insertion'] + 1;
} else {
	$orderNumber = $orderRoot.'001';
}

$content = "";

$to = $mail;

switch ($langue) {
	case 'fr':
		$_SESSION['info'] = "Votre commande ".$orderNumber." a bien été prise en compte. Merci.";
		$subject = 'Votre commande sur le site Gustoki';

		$body = "Bonjour, ".$civility." ".$name.", nous vous remercions de votre commande numéro ".$orderNumber." dont vous trouverez le récapitulatif ci-après. \r\n";
		$body .= "Le prix final de votre facture pourra varier en fonction du poids des produits ou de leur indisponibilité.\r\n";
		$body .= "<br>\r\n";
		$body .= "<table id='basket'>\r\n";
		$body .= "<thead>\r\n";
		$body .= "<tr>\r\n";
		$body .= "<th align='center' style='border:1px solid black;'>produit</th>\r\n";
		$body .= "<th align='center' style='border:1px solid black;'>quantité</th>\r\n";
		$body .= "<th align='center' style='border:1px solid black;'>prix unitaire</th>\r\n";
		$body .= "<th align='center' style='border:1px solid black;'>total</th>\r\n";
		$body .= "</tr>\r\n";
		$body .= "</thead>\r\n";
		$body .= "<tbody>\r\n";
		$total = 0;
		foreach ($products as $product => $quantity) {
			$parameter = [$product];
			$request = "SELECT * FROM `gus_product`WHERE Product_Id = ?";
			$query = fetchData($bdd,$request,$parameter);
			$sum = $quantity * $query['Price'];
			$content .=" ".$query['Title']." ".$quantity."x".$query['Price']."=".$sum."\r\n";
			$content .= '<br>';
			$total += $sum;
			$body .="<tr>\r\n";
			$body .="<td align='center' style='border:1px solid black;'>".$query['Title']."</td>\r\n";
			$body .="<td align='center' style='border:1px solid black;'>".$quantity."</td>\r\n";
			$body .="<td align='center' style='border:1px solid black;'>".$query['Price']."</td>\r\n";
			$body .="<td class='sum' align='center' style='border:1px solid black;'>".$sum."</td>\r\n";
			$body .="</tr>\r\n";
		}
		$body .= "</tbody>\r\n";
		$body .= "<tfoot>\r\n";
		$body .= "<tr>\r\n";
		$body .= "<th colspan='3' align='center' style='border:1px solid black;'>Total</th>\r\n";
		$body .= "<th id='grandTotal' align='center' style='border:1px solid black;'>".$total."</th>\r\n";
		$body .= "</tr>\r\n";
		$body .= "</tfoot>\r\n";
		$body .= "</table>\r\n";
		$body .= "<br>\r\n";
		$body .= "Vous avez choisi comme lieu de livraison: ".$delivery." .";
		$body .= "Merci de votre confiance.\r\n";
		$body .= "A bientôt sur Gustoki.\r\n";
		break;
	
	default:
		$_SESSION['info'] = "Zure eskaera ".$orderNumber." kontuan hartu da. Milesker.";
		$subject = 'Zure eskaera Gustoki gunean';

		$body = "Egun on, ".$name." ".$civility.", eskerrik asko zure eskaeragatik zenbakia".$orderNumber." behean aurkituko duzuen laburpena. \r\n";
		$body .= "Zure fakturaren azken prezioa aldatu egin daiteke produktuen pisuaren edo erabilgarri ez dagoen arabera.\r\n";
		$body .= "<br>\r\n";
		$body .= "<table id='basket'>\r\n";
		$body .= "<thead>\r\n";
		$body .= "<tr>\r\n";
		$body .= "<th align='center' style='border:1px solid black;'>produktu</th>\r\n";
		$body .= "<th align='center' style='border:1px solid black;'>kantate</th>\r\n";
		$body .= "<th align='center' style='border:1px solid black;'>prezio unitarioa</th>\r\n";
		$body .= "<th align='center' style='border:1px solid black;'>guztira</th>\r\n";
		$body .= "</tr>\r\n";
		$body .= "</thead>\r\n";
		$body .= "<tbody>\r\n";
		$total = 0;
		foreach ($products as $product => $quantity) {
			$parameter = [$product];
			$request = "SELECT * FROM `gus_product`WHERE Product_Id = ?";
			$query = fetchData($bdd,$request,$parameter);
			$sum = $quantity * $query['Price'];
			$content .=" ".$query['Izenburua']." ".$quantity."x".$query['Price']."=".$sum."\r\n";
			$content .= "<br>\r\n";
			$total += $sum;
			$body .="<tr>\r\n";
			$body .="<td align='center' style='border:1px solid black;'>".$query['Izenburua']."</td>\r\n";
			$body .="<td align='center' style='border:1px solid black;'>".$quantity."</td>\r\n";
			$body .="<td align='center' style='border:1px solid black;'>".$query['Price']."</td>\r\n";
			$body .="<td class='sum' align='center' style='border:1px solid black;'>".$sum."</td>\r\n";
			$body .="</tr>\r\n";
		}
		$body .= "</tbody>\r\n";
		$body .= "<tfoot>\r\n";
		$body .= "<tr>\r\n";
		$body .= "<th colspan='3' align='center' style='border:1px solid black;'>Guztira</th>\r\n";
		$body .= "<th id='grandTotal' align='center' style='border:1px solid black;'>".$total."</th>\r\n";
		$body .= "</tr>\r\n";
		$body .= "</tfoot>\r\n";
		$body .= "</table>\r\n";
		$body .= "<br>\r\n";
		$body .= "Bidalketaren kokapena aukeratu duzu: ".$delivery." .";
		$body .= "Eskerrik asko zure konfiantzagatik.\r\n";
		$body .= "Laster arte Gustokian.\r\n";
		break;
}



$headers = "From: gustoki@gustoki.com\r\n";
$headers .= "Content-type: text/html; charset=UTF-8 \r\n";

mail($to, $subject, $body, $headers);

$parameter = [$orderNumber];
$request = 'UPDATE `gus_last_order_number`
			SET `Last_Insertion`= ?
			WHERE `Id`= 1';
$update = updateData($bdd,$request,$parameter);

foreach ($products as $product => $quantity) {
	$parameter = [$product];
	$request = "SELECT `Quantity`,`Title`
				FROM `gus_product`
				WHERE `Product_Id`=?";
	$item = fetchData($bdd,$request,$parameter);
	$backwardQuantity = $item['Quantity'];
	$forwardQuantity = intval($backwardQuantity) - intval($quantity);
	$parameter = [$forwardQuantity,$product];
	$request = "UPDATE `gus_product`
				SET `Quantity`=? 
				WHERE `Product_Id`=?";
	$update = updateData($bdd,$request,$parameter);

	$creationDate = date('Y-m-d');

	$week = date('W');

	$parameter = [$orderNumber,$_SESSION['Customer'],$product,$item['Title'],$quantity,$creationDate,$week,$idDelivery];
	$request= "INSERT INTO `gus_manorder`(`ManOrder_Order_Number`, `ManOrder_Cust_Number`, `ManOrder_Product_Id`, `ManOrder_Product`, `ManOrder_Quantity`, `ManOrder_Date`, `ManOrder_Week`,`ManOrder_Delivery_Id`) VALUES (?,?,?,?,?,?,?,?)";

	$saveOrder = recordData($bdd,$request,$parameter);

}

$parameter = [$orderNumber,$_SESSION['Customer'],$content,$total,$creationDate,$week,$idDelivery];



$request = "INSERT INTO `gus_orders`(`Order_Number`, `Order_Cust_Number`, `Order_Contents`, `Order_Total`, `Order_Date`, `Order_Week`, `Order_Delivery_Id`) VALUES (?,?,?,?,?,?,?)";

$saveOrders = recordData($bdd,$request,$parameter);

$_SESSION['panier']=[];
unset($_SESSION['panier']);

header('location:index.php?lang='.$langue);