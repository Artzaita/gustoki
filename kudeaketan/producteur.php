<?php 


// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include '../model/db_connect.php';
include '../model/db_management.php';


// récupération de la liste des producteurs
$request = 'SELECT * FROM `gus_producer`';
$producers = fetchAllData($bdd, $request);


// récupération des catégories de produits
$query = 'SELECT * FROM `gus_category`';
$categories = fetchAllData($bdd, $query);

//test de l'arrivée de données en POST
if ($_POST){
	var_dump($_POST);
	var_dump($_FILES);

	//récupération des données du formulaire
	$title = $_POST['title'];
	$description = $_POST['description'];
	$deskribapen = $_POST['deskribapen'];
	$village = $_POST['village'];
	$herria = $_POST['herria'];
	$installation = $_POST['installation'];
	$idoki = $_POST['Idoki'];
	$aop = $_POST['AOP'];
	$AB = $_POST['AB'];
	$conversion = $_POST['Conversion'];
	$promotion = $_POST['Promotion'];
	$categoryId = $_POST['categoryId'];

	//gestion de l'image
	$file = $_FILES['photo'];

	switch ($file['error']) {
			//si absence image, nom image par défaut
			case 4:
				$image = 'LogoGUSTOKI.png';
				$imageDescription = "logo GUSTOKI";
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
						$destination = "../img/producteur/";
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

	$parameter = [$title,$description,$deskribapen,$village,$herria,$installation,$idoki,$aop,$AB,$conversion,$promotion,$photoId,$categoryId];
	var_dump($parameter);

	$request = 'INSERT INTO `gus_producer`(`Producer_Name`, `Producer_Description`, `Producer_Deskribapen`, `Village`, `Herria`, `Installation`, `Producer_Label_Idoki`, `Producer_LABEL_AOP`, `Producer_Label_AB`, `Producer_Label_Conversion`, `Producer_Promotion`, `Producer_Photo_Id`, `Producer_Category_Id`)
				VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)';

	$query = recordData($bdd,$request,$parameter);



}









$template = 'producteur';
include 'view/layout.phtml';