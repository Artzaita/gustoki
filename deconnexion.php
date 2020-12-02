<?php 

session_start();

require ('root.php');

session_unset();

session_destroy();



switch ($langue) {
	case 'fr':
		header('location:index.php?lang=fr');
		break;
	
	default:
		header('location:index.php?lang=eus');
		break;
}




