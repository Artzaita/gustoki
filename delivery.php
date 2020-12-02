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




$template = 'delivery';
include 'view/layout.phtml';
