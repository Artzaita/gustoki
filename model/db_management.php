<?php


function recordData ($bdd, $request, $parameter = []) {

	$query = $bdd->prepare($request);

	$query->execute($parameter);

}

function fetchAllData ($bdd, $request, $parameter = []) {

	$query = $bdd->prepare($request);

	$query->execute($parameter);

	$showData = $query->fetchAll(PDO::FETCH_ASSOC);

	return $showData;

}

function fetchData ($bdd, $request, $parameter = []) {

	$query = $bdd->prepare($request);

	$query->execute($parameter);

	$showData = $query->fetch(PDO::FETCH_ASSOC);
	return $showData;
}

function updateData ($bdd, $request, $parameter = []) {

	$query = $bdd->prepare($request);

	$query->execute($parameter);
}


function deleteData ($bdd, $request, $parameter = []) {

	$query = $bdd->prepare($request);

	$query->execute($parameter);
}