<?php 

include './model/basket_management.php';

if ($langue == 'fr') {
	$accueil = 'accueil';
} else {
	$accueil = 'harrera';
}

if (preg_match('/produits/',$_SERVER['PHP_SELF'])) {
	if (isset($_GET['catid'])) {
		$get2 = '&catid='.$_GET['catid'];
	} else {
		$get2 = "";
	}
} else {
	$get2 = "";
}




include ($root.'/view/header.phtml');