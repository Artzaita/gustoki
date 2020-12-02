<?php 

session_start();

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';


$request = 'SELECT *
			FROM gus_delivery
			ORDER BY Delivery_Name ASC';

$deliveries = fetchAllData($bdd,$request);

$request = 'SELECT *
			FROM gus_delivery
			ORDER BY Delivery_Izenburua ASC';

$banatzeak = fetchAllData($bdd,$request);




$template = 'livraison';
include 'view/layout.phtml';
