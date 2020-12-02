<?php 

if (!isset($_SESSION)) {
	session_start();
}


if (!isset($_SESSION['panier'])) {
	$_SESSION['panier'] = [];
}
	
$productSum = sizeof($_SESSION['panier']);


function addBasket ($product,$quantity) {
	/*$_SESSION['panier']['id'] = $product;*/
	$_SESSION['panier'][$product] = $quantity;
	//array_push($_SESSION['panier'],[$product],[$quantity]);
	/*$set = $prod['$quantity'];*/
}

function modifyBasket ($product,$quantity) {

	if ($quantity > 0) {

		$_SESSION['panier'][$product] = $quantity;

	} elseif ($quantity == 0) {

		unset($_SESSION['panier'][$product]);

	}

}

function deleteProduct ($product) {
	unset($_SESSION['panier'][$product]);
}