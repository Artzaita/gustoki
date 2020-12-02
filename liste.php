<?php 

include './model/db_connect.php';
include './model/db_management.php';

$term = $_GET['term'];



if ($_GET['lang'] == 'fr') {

	if ($_GET['search'] == 'CP') {

		$requete = $bdd->prepare('SELECT * 
				FROM `gus_cp` 
				WHERE `CP_CP` LIKE :term'); // j'effectue ma requête SQL grâce au mot-clé LIKE
		$requete->execute(array('term' => '%'.$term.'%'));

		$array = array(); // on créé le tableau

		while($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
		{
  	  	array_push($array, $donnee['CP_CP']); // et on ajoute celles-ci à notre tableau
		}
	}

	if ($_GET['search'] == 'city') {

		$requete = $bdd->prepare('SELECT * 
				FROM `gus_cp` 
				WHERE `CP_City` LIKE :term'); // j'effectue ma requête SQL grâce au mot-clé LIKE
		$requete->execute(array('term' => '%'.$term.'%'));

		$array = array(); // on créé le tableau

		while($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
		{
  	  	array_push($array, $donnee['CP_City']); // et on ajoute celles-ci à notre tableau
		}
	}
}

echo json_encode($array); // il n'y a plus qu'à convertir en JSON