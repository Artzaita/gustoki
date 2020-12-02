<?php 


// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include '../model/db_connect.php';
include '../model/db_management.php';




$action = $_SERVER['QUERY_STRING'];


// récupération des catégories de produits
$request = 'SELECT * FROM `gus_category`';
$categories = fetchAllData($bdd, $request);

//récupération des unités de produits
$request = 'SELECT * FROM `gus_unity`';
$unities = fetchAllData($bdd, $request);

//récupération des producteurs
$request = 'SELECT * FROM `gus_producer`';
$producers = fetchAllData($bdd, $request);


if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	$id = $_GET['id'];

	if ($_POST) {

		if (isset($_GET["type"]) && $_GET["type"]=="product") {

			if (isset($_POST['modify'])) {

				$parameter = [$_GET["id"]];
				$request = 'SELECT * 
						FROM `gus_product`
						INNER JOIN `gus_category` ON gus_product.Product_Category_Id = gus_category.Id
						INNER JOIN gus_producer ON gus_product.Producer_Id = gus_producer.Producer_Id
						INNER JOIN gus_unity ON gus_product.Unity_Id = gus_unity.Id
						WHERE `Product_Id`=?';
				$product = fetchData($bdd,$request,$parameter);

			}

			if (isset($_POST['modifyQuantity'])) {
				var_dump($_POST);
				$parameter = [$_POST['Quantity_Product'],$_POST['id_Product']];
				$request = 'UPDATE `gus_product`
							SET `Quantity`=?
							WHERE `Product_Id`=?';
				$product = updateData($bdd,$request,$parameter);
				header('Location: produit.php#'.$id);

			}

			if (isset($_POST['modifyPrice'])) {
				var_dump($_POST);
				$parameter = [$_POST['Price_Product'],$_POST['id_Product']];
				$request = 'UPDATE `gus_product`
							SET `Price`=?
							WHERE `Product_Id`=?';
				$product = updateData($bdd,$request,$parameter);
				header('Location: produit.php#'.$id);

			}

			if (isset($_POST['delete'])) {
				$parameter = [$_GET["id"]];
				$request = 'DELETE
						FROM `gus_product`
						WHERE `Product_Id`=?';
				$product = deleteData($bdd,$request,$parameter);
				header("location: produit.php");
			}

			if (isset($_POST['record'])) {

			//récupération des données du formulaire
				$title = $_POST['title'];
				$izena = $_POST['izena'];
				$descriptionLong = $_POST['description_long'];
				$deskribapenLuzea = $_POST['deskribapen_luzea'];
				$categoryId = $_POST['categoryId'];
				$quantity = $_POST['quantity'];
				$unityId = $_POST['unityId'];
				$weight = $_POST['weight'];
				$price = $_POST['price'];
				$producerId = $_POST['producerId'];
				$idoki = $_POST['Idoki'];
				$AOP = $_POST['AOP'];
				$AB = $_POST['AB'];
				$conversion = $_POST['Conversion'];
				$promotion = $_POST['Promotion'];

			//gestion de l'image
				$file = $_FILES['photo'];

				switch ($file['error']) {
			//si absence image,
					case 4:
						$parameter = [$title,$izena,$descriptionLong,$deskribapenLuzea,$categoryId,$quantity,$unityId,$weight,$price,$producerId,$idoki,$AOP,$AB,$conversion,$promotion,$_GET["id"]];
				
						$request = 'UPDATE `gus_product` 
							SET `Title`=?,`Izenburua`=?,`Description_Long`=?,`Deskribapen_Luzea`=?,`Product_Category_Id`=?,`Quantity`=?,`Unity_Id`=?,`Weight`=?,`Price`=?,`Producer_Id`=?,`Product_Label_Idoki`=?,`Product_Label_AOP`=?,`Product_Label_Bio`=?,`Product_Label_Conversion`=?,`Product_Promotion`=? 
							WHERE `Product_Id`=?';
						$query = updateData($bdd,$request,$parameter);
						header("location: produit.php");
						break;

			//gestion de l'image trop volumineuse
					case 2:
						$_SESSION['info'] = "l'image est trop lourde, veuillez en sélectionner une autre";
					break;

			//si OK
					case 0:
				//validation de l'extension
						$validated_extensions = ['jpg', 'jpeg', 'gif', 'png', 'svg'];
						$extension = strchr($file['name'], '.');
						$uploaded_extension = strtolower(substr($extension, 1));
						if (in_array($uploaded_extension, $validated_extensions)) {
							if ($file['size'] <= $_POST['MAX_FILE_SIZE']) {
						//renommage de l'image
								$name = $title;
								$name = str_replace(' ', '_', $name);
								$image = $name.$extension;
								$imageDescription = $_POST['ImageDescription'];
								$irudiDeskribapen = $_POST['IrudiDeskribapen'];
						//enregistrement de l'image
								$destination = "../img/produit/";
								move_uploaded_file($file['tmp_name'], $destination.$image);

								$parameter = [$image,$imageDescription,$irudiDeskribapen];

								$request = 'INSERT INTO `gus_photo`(`Photo_Name`, `Photo_Description`, `Irudi_Deskribapen`) VALUES (?,?,?)';

								$query = recordData($bdd,$request,$parameter);

								$photoId = $bdd->lastInsertId();


							}
						}
						$parameter = [$title,$izena,$descriptionLong,$deskribapenLuzea,$photoId,$categoryId,$quantity,$unityId,$weight,$price,$producerId,$idoki,$AOP,$AB,$conversion,$promotion,$_GET["id"]];
						$request = 'UPDATE `gus_product` 
							SET `Title`=?,`Izenburua`=?,`Description_Long`=?,`Deskribapen_Luzea`=?,`Product_Photo_Id`=?,`Product_Category_Id`=?,`Quantity`=?,`Unity_Id`=?,`Weight`=?,`Price`=?,`Producer_Id`=?,`Product_Label_Idoki`=?,`Product_Label_AOP`=?,`Product_Label_Bio`=?,`Product_Label_Conversion`=?,`Product_Promotion`=? 
							WHERE `Product_Id`=?';
						$query = updateData($bdd,$request,$parameter);
						header("location: produit.php");
						break;

				}

			}

		}

		if (isset($_GET["type"]) && $_GET["type"]=="producer") {

			if (isset($_POST['modify'])) {
				$parameter = [$_GET["id"]];
				$request = 'SELECT * FROM `gus_producer` WHERE `Producer_Id`=?';
				$producer = fetchData($bdd,$request,$parameter);
			}

			if (isset($_POST['delete'])) {
				$parameter = [$_GET["id"]];
				$request = 'DELETE
						FROM `gus_producer`
						WHERE `Producer_Id`=?';
				$product = deleteData($bdd,$request,$parameter);
				header("location: producteur.php");
			}

			if (isset($_POST['record'])) {

			//récupération des données du formulaire
				$title = $_POST['title'];
				$description = $_POST['description'];
				$deskribapen = $_POST['deskribapen'];
				$village = $_POST['village'];
				$herria = $_POST['herria'];
				$installation = $_POST['installation'];
				$idoki = $_POST['Idoki'];
				$AB = $_POST['AB'];
				$conversion = $_POST['Conversion'];
				$promotion = $_POST['Promotion'];
				//$categoryId = $_POST['categoryId'];

			//gestion de l'image
				$file = $_FILES['photo'];

				switch ($file['error']) {
				//si absence image, nom image par défaut
					case 4:
						$parameter = [$title,$description,$deskribapen,$village,$herria,$installation,$idoki,$AOP,$AB,$conversion,$promotion,$_GET['id']];

						$request = 'UPDATE `gus_producer`
								SET `Producer_Name`=?,`Producer_Description`=?,`Producer_Deskribapen`=?,`Village`=?,`Herria`=?,`Installation`=?,`Producer_Label_Idoki`=?,`Producer_Label_AOP`=?,`Producer_Label_AB`=?,`Producer_Label_Conversion`=?,`Producer_Promotion`=?
									WHERE `Producer_Id`=?';

						$query = recordData($bdd,$request,$parameter);

						header("location: producteur.php");
						break;

				}
			}

		}

		if (isset($_GET["type"]) && $_GET["type"]=="delivery") {

			if (isset($_POST['modify'])) {

				$parameter = [$_GET["id"]];
				$request = 'SELECT * FROM `gus_delivery` WHERE `Delivery_Id`=?';
				$delivery = fetchData($bdd,$request,$parameter);

			}

			if (isset($_POST['delete'])) {
				$parameter = [$_GET["id"]];
				$request = 'DELETE
						FROM `gus_delivery`
						WHERE `Delivery_Id`=?';
				$delivery = deleteData($bdd,$request,$parameter);
				header("location: delivery.php");
			}

			if (isset($_POST['record'])) {

				$name = $_POST['Name'];
				$izena = $_POST['Izenburua'];
				$descr = $_POST['Description'];
				$deskr = $_POST['Deskribapen'];
				$type = $_POST['Type'];

				$parameter = [$name,$izena,$descr,$deskr,$type,$_GET['id']];

				$request = 'UPDATE `gus_delivery` SET `Delivery_Name`=?,`Delivery_Izenburua`=?,`Delivery_Description`=?,`Delivery_Deskribapen`=?,`Delivery_Type`=? WHERE `Delivery_Id`=?';

				$query = updateData($bdd,$request,$parameter);

				header('Location: delivery.php');

			}






		}
	
	} else {
		$request = 'SELECT * FROM gus_product';
		$ids = fetchAllData($bdd,$request);
		$array = [];
		foreach ($ids as $id) {
			array_push($array, $id['Product_Id']);
		}
		if (in_array($_GET['id'], $array)) {
			var_dump('good job');
			$parameter = [$_GET["id"]];
			$request = 'SELECT * 
						FROM `gus_product`
						INNER JOIN `gus_category` ON gus_product.Product_Category_Id = gus_category.Id
						INNER JOIN gus_producer ON gus_product.Producer_Id = gus_producer.Producer_Id
						INNER JOIN gus_unity ON gus_product.Unity_Id = gus_unity.Id
						WHERE `Product_Id`=?';
			$product = fetchData($bdd,$request,$parameter);
		}
	}

}





$template = 'modify';
include 'view/layout.phtml';
