<?php 

if (isset($_SESSION['info'])) {
	$info = ($_SESSION['info']);
	$_SESSION['info']=[];
	unset($_SESSION['info']);
};






