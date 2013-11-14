<?php 

	if (isset($_POST['latitude'])&&isset($_POST['longitude'])) {
		// On assigne aux variables les valeurs récupérée
		$latitude=floatval($_POST['latitude']);
		$longitude=floatval($_POST['longitude']);
		$titre=filter_var($_POST['titre'],FILTER_SANITIZE_STRING);
		$description=filter_var($_POST['description'],FILTER_SANITIZE_STRING);

		// Connexion à la BDD
		$bdd=new PDO('mysql:host=localhost;dbname=parislack','root','');

		// Préparation de la requete puis execution
		$stmt=$bdd->prepare('INSERT INTO spots (latitude,longitude,titre,description) VALUES (:latitude,:longitude,:titre,:description)');
		$stmt->bindParam(':latitude',$latitude);
		$stmt->bindParam(':longitude',$longitude);
		$stmt->bindParam(':titre',$titre);
		$stmt->bindParam(':description',$description);

		$stmt->execute();

		header('Content-type:application/json;charset=UTF-8');

		echo json_encode(
			array(
				"error"=>false,
				"msg"=>"Coordonnées enregistrées"
		));
	}else{
		echo json_encode(
			array(
				"error"=>true,
				"msg"=>"Valeurs entrées incorrectes"
		));
	}

 ?>