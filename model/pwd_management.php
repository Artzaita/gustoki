<?php 



function createPwd ($numKeys) {

	$keys = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9","!",":",";",",","/",".","%","µ","$","£","ù","?","+","@","ç","è","-","#","é","&"];

	$length = sizeof($keys);
	

		$pwd = "";

	for ($i=0; $i < $numKeys ; $i++) { 
		$index = rand(0, $length - 1);
		var_dump($index);
		$pwd .= $keys[$index];
		//var_dump($pwd);
	}

	return $pwd;
}


function hashPwd ($pwd) {
	$salt = '$2y$11$'.substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);

	return crypt($pwd, $salt);
}

function verifyPwd ($pwd, $hashedPwd) {
	return crypt($pwd, $hashedPwd) == $hashedPwd;
}










