<?php 

if (isset($_GET['lang'])) {
	$langue = $_GET['lang'];
} else {
	$langue = 'eus';
}

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$root = './';
} else {
	$root = $_SERVER['DOCUMENT_ROOT'];
}