<?php 

	header('Content-type:text/html;charset=UTF-8');

	if (isset($_POST['latitude'])&&isset($_POST['longitude'])) {
		// On assigne aux variables les valeurs récupérée
		$latitude=floatval($_POST['latitude']);
		$longitude=floatval($_POST['longitude']);

		// Connexion à la BDD
		$bdd=new PDO('mysql:host=localhost;dbname=parislack','root','');

		// Préparation de la requete puis execution
		$stmt=$bdd->prepare('INSERT INTO spots (latitude,longitude) VALUES (:latitude,:longitude)');
		$stmt->bindParam(':latitude',$latitude);
		$stmt->bindParam(':longitude',$longitude);

		$stmt->execute();

		echo "Coordonnées enregistrées";
	}else{
		echo "Problème sur les valeurs entrées";
	}

 ?>