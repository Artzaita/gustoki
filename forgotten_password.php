<?php 

session_start();

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';
include './_alert.php';






$template = 'forgotten_password';
include 'view/layout.phtml';