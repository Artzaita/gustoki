<?php 

session_start();

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';

$products = $_SESSION['panier'];

if (!empty($products)) {
	$_SESSION['basket'] = true;
}











$template = 'panier';
include 'view/layout.phtml';
