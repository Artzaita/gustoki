<?php 

// connexion à la BDD

try {
	    $bdd = new PDO('mysql:host=5n5g8.myd.infomaniak.com;dbname=5n5g8_gustoki_db', '5n5g8_artzaita', 'Euskadi64#');
	    // Paramétrage de la liaison PHP <-> MySQL, les données sont encodées en UTF-8.
    	$bdd->exec('SET NAMES UTF8');

	  } catch (PDOException $e) {
	  	debug($e->getMessage());
	      die();
	  }

