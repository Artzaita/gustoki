<?php 


// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include '../model/db_connect.php';
include '../model/db_management.php';


//récupération des produits
if (isset($_POST['search'])) {
	if (isset($_POST['recherche']) && $_POST['recherche'] != ''){
		$var = "%".$_POST['recherche']."%";
		$request = 'SELECT *
			FROM `gus_product`
			INNER JOIN gus_category ON gus_product.Product_Category_Id = gus_category.Id
			INNER JOIN gus_photo ON gus_product.Product_Photo_Id = gus_photo.Id
			INNER JOIN gus_unity ON gus_product.Unity_Id = gus_unity.Id
			INNER JOIN gus_producer ON gus_product.Producer_Id = gus_producer.Producer_Id
			WHERE `Title` LIKE ?
			ORDER BY `Title` ASC';
	} elseif (isset($_POST['bilaketa']) && $_POST['bilaketa'] != '') {
		$var = "%".$_POST['bilaketa']."%";
		$request = 'SELECT *
			FROM `gus_product`
			INNER JOIN gus_category ON gus_product.Product_Category_Id = gus_category.Id
			INNER JOIN gus_photo ON gus_product.Product_Photo_Id = gus_photo.Id
			INNER JOIN gus_unity ON gus_product.Unity_Id = gus_unity.Id
			INNER JOIN gus_producer ON gus_product.Producer_Id = gus_producer.Producer_Id
			WHERE `Izenburua` LIKE ?
			ORDER BY `Title` ASC';
	}
} else {
	$var = 1;
	$request = 'SELECT *
			FROM `gus_product`
			INNER JOIN gus_category ON gus_product.Product_Category_Id = gus_category.Id
			INNER JOIN gus_photo ON gus_product.Product_Photo_Id = gus_photo.Id
			INNER JOIN gus_unity ON gus_product.Unity_Id = gus_unity.Id
			INNER JOIN gus_producer ON gus_product.Producer_Id = gus_producer.Producer_Id
			WHERE ?
			ORDER BY `Title` ASC';
}

$parameter = [$var];

$products = fetchAllData($bdd, $request, $parameter);

// récupération des catégories de produits
$request = 'SELECT * FROM `gus_category`';
$categories = fetchAllData($bdd, $request);

//récupération des unités de produits
$request = 'SELECT * FROM `gus_unity`';
$unities = fetchAllData($bdd, $request);

//récupération des producteurs
$request = 'SELECT * FROM `gus_producer`';
$producers = fetchAllData($bdd, $request);

//test de l'arrivée de données en POST
if ($_POST){
	/*var_dump($_POST);
	var_dump($_FILES);*/

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
			//si absence image, nom image par défaut
			case 4:
				$image = 'LogoGUSTOKI.png';
				$imageDescription = "logo GUSTOKI";
				$photoId = '1';
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
				break;

			default:
				$_SESSION['info'] = "Erreur lors du téléchargement";
				break;
	}

						/*var_dump($photoId);*/

	$parameter = [$title,$izena,$descriptionLong,$deskribapenLuzea,$photoId,$categoryId,$quantity,$unityId,$weight,$price,$producerId,$idoki,$AB,$AOP,$conversion,$promotion];

	$request = 'INSERT INTO `gus_product`(`Title`, `Izenburua`, `Description_Long`, `Deskribapen_Luzea`, `Product_Photo_Id`, `Product_Category_Id`, `Quantity`, `Unity_Id`, `Weight`, `Price`, `Producer_Id`, `Product_Label_Idoki`, `Product_Label_AOP`, `Product_Label_Bio`, `Product_Label_Conversion`, `Product_Promotion`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

	$query = recordData($bdd,$request,$parameter);


}

$template = 'produit';
include 'view/layout.phtml';