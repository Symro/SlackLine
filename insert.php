<?php 

	header('Content-type:text/html;charset=UTF-8');

	if (isset($_POST['latitude'])&&isset($_POST['longitude'])) {
		$latitude=floatval($_POST['latitude']);
		$longitude=floatval($_POST['longitude']);

		$bdd=new PDO('mysql:host=localhost;dbname=parislack','root','');

		$stmt=$bdd->prepare('INSERT INTO listemarkers (latitude,longitude) VALUES (:latitude,:longitude)');
		$stmt->bindParam(':latitude',$latitude);
		$stmt->bindParam(':longitude',$longitude);

		$stmt->execute();

		// $result=$bdd->query('INSERT INTO listemarkers (latitude,longitude) VALUES ($latitude,$longitude)');
		echo "Coordonnées enregistrées";
	}else{
		echo "Problème sur les valeurs entrées";
	}

 ?>