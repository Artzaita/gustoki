<?php

session_start();

require ('root.php');

// connexion aux modèles de connexion à la BDD et de gestion de la BDD

include './model/db_connect.php';
include './model/db_management.php';
include './_alert.php';




$email = $_POST['email'];

$parameter = [$email];

$request = 'SELECT  gus_quest.Quest_Question, gus_quest.Quest_Galdera, gus_ans.`Ans_Ans`
			FROM `gus_ans`
			INNER JOIN gus_cust ON gus_ans.Ans_Cust_Number=gus_cust.Cust_Number
			INNER JOIN gus_quest ON gus_ans.Ans_Quest_Id=gus_quest.Quest_Id
			WHERE gus_cust.Cust_Mail = ?';

$question = fetchData($bdd,$request,$parameter);


?>

<section>
	<?php if ($langue == 'fr'): ?>
	<h3><?= $question['Quest_Question'] ?></h3>
	<?php else: ?>
	<h3><?= $question['Quest_Galdera'] ?></h3>
	<?php endif; ?>
	<input type="hidden" value='<?= $question['Ans_Ans'] ?>' name='master'>
	<input type="text" name="result">
</section>



