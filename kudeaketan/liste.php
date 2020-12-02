<?php 

include '../model/db_connect.php';
include '../model/db_management.php';

$term = $_GET['term'];



if ($_GET['lang'] == 'fr') {

	$requete = $bdd->prepare('SELECT * 
				FROM `gus_product` 
				WHERE `Title` LIKE :term'); // j'effectue ma requête SQL grâce au mot-clé LIKE
	$requete->execute(array('term' => '%'.$term.'%'));

	$array = array(); // on créé le tableau

	while($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
	{
    	array_push($array, $donnee['Title']); // et on ajoute celles-ci à notre tableau
	} 
}

if ($_GET['lang'] == 'eus') {

	$requete = $bdd->prepare('SELECT * 
				FROM `gus_product` 
				WHERE `Izenburua` LIKE :term'); // j'effectue ma requête SQL grâce au mot-clé LIKE
	$requete->execute(array('term' => '%'.$term.'%'));

	$array = array(); // on créé le tableau

	while($donnee = $requete->fetch()) // on effectue une boucle pour obtenir les données
	{

		array_push($array, $donnee['Izenburua']);
	}
}

echo json_encode($array); // il n'y a plus qu'à convertir en JSON