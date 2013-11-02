<?php

session_start();
//header('Content-type: text/html; charset=utf-8');
header('Content-type: application/json; charset=utf-8');
include('config.php'); 


if ( isset($_SESSION['membre_logged_in']) && !empty($_SESSION['membre_logged_in']) && $_SESSION['membre_logged_in'] === true ){


	/* ____________________ GET ____________________ */
	/* _____________________________________________ */

	if(isset($_GET['action']) && !empty($_GET['action'])) {
	    $action = $_GET['action'];
	    switch($action) {
	        case 'getSpotList' : getSpotList(); break;
	        case 'getFavSpots' : getFavSpots(); break;
	        case 'getFavSlackers' : getFavSlackers(); break;
	        case 'getUserProfil' : getUserProfil(); break;
	        //case 'blah' : blah();break;
	        // ...etc...
	    }
	}



}
else{
	echo json_encode(
		array(
			"erreur" => true,
			"msg" => "Vous n'êtes pas identifié !"
	));
};






	function getSpotList(){
		global $PDO;

		// On selectionne tout
		$reponse = $PDO->query('SELECT * FROM spots');
		 
		// On récupère le resultat
		$donnees = $reponse->fetchAll(PDO::FETCH_ASSOC);

		// On retourne un JSON
		// http://stackoverflow.com/questions/4507366/return-a-json-object-using-php-json-encode-mysql-to-pass-to-jquery-function
		echo json_encode($donnees);
		 
		$reponse->closeCursor();

	}




	function getFavSpots(){
		global $PDO;

		try {

			$reponse = $PDO->prepare('SELECT spots.titre, spots.description, spots.categorie, spots.note
				FROM spots_favoris
				INNER JOIN spots
				ON spots_favoris.id_spot = spots.id
				WHERE spots_favoris.id_utilisateur = :currentUser');

			$reponse->execute(array(
	            ':currentUser' => $_SESSION['membre_id']
	        ));
			 
			if( $reponse ) {
				$donnees = $reponse->fetchAll(PDO::FETCH_ASSOC);
				echo json_encode($donnees);
				$reponse->closeCursor();
			}
			else{
				echo json_encode(
					array(
						"erreur" => true,
						"msg" => "Une erreur est survenue lors de la récupération des données"
				));
			}

		}catch ( Exception $e ) {
			echo "Une erreur est survenue lors de la récupération des données";
		}

	}

	function getFavSlackers(){
		global $PDO;

		try {
			$reponse = $PDO->prepare('SELECT utilisateurs.id, nom, prenom, niveau
							FROM utilisateurs_favoris
							INNER JOIN utilisateurs
							ON utilisateurs_favoris.id_favoris =  utilisateurs.id
							WHERE utilisateurs_favoris.id_utilisateur = :currentUser');

			$reponse->execute(array(
	            ':currentUser' => $_SESSION['membre_id']
	        ));

			if( $reponse ) {
				$donnees = $reponse->fetchAll(PDO::FETCH_ASSOC);

				echo json_encode($donnees);
				$reponse->closeCursor();
			}
			else{
				echo json_encode(
					array(
						"erreur" => true,
						"msg" => "Une erreur est survenue lors de la récupération des données"
				));
			}

		}catch ( Exception $e ) {
			echo "Une erreur est survenue lors de la récupération des données";
		}

	}



	function getUserProfil(){
		global $PDO;

		try {

			$reponse = $PDO->prepare('SELECT nom, prenom, email, date_naissance, niveau, technique, description, materiel, telephone
							FROM utilisateurs
							WHERE id = :currentUser');

			$reponse->execute(array(
	            ':currentUser' => $_SESSION['membre_id']
	        ));

			if( $reponse ) {
				$donnees = $reponse->fetchAll(PDO::FETCH_ASSOC);

				echo json_encode($donnees);
				$reponse->closeCursor();
			}
			else{
				echo json_encode(
					array(
						"erreur" => true,
						"msg" => "Une erreur est survenue lors de la récupération des données"
				));
			}

		}catch ( Exception $e ) {
			echo "Une erreur est survenue lors de la récupération des données";
		}

	}

	/* ____________________ POST ____________________ */
	/* ______________________________________________ */
	

	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];
	    switch($action) {
	        case 'addFavSlacker' : addFavSlacker(); break;
	        case 'removeFavSlacker' : removeFavSlacker(); break;

	        //case 'blah' : blah();break;
	        // ...etc...
	    }
	}

	function addFavSlacker(){
		global $PDO;

		$currentUserId = (int)$_SESSION['membre_id'];

		if(isset($_POST['userId']) && !empty($_POST['userId'])){
			$idFavorite = ((int)$_POST['userId'] == 0 ) ? 0 : (int)$_POST['userId'];
		}
		else{
			echo json_encode(
				array(
					"erreur" => true,
					"msg" => "Une erreur est survenue lors de l'ajout de données"
			));
		}

		if($idFavorite != 0){

			$reponse = $PDO->prepare('SELECT id_utilisateur, id_favoris FROM utilisateurs_favoris WHERE id_utilisateur = :userId AND id_favoris = :idFavorite');
			$reponse->bindValue('userId', $currentUserId);
			$reponse->bindValue('idFavorite', $idFavorite); 
			$reponse->execute();

			if ($reponse->fetchColumn() == 0) {

				$requete = $PDO->prepare("INSERT INTO utilisateurs_favoris (id_utilisateur, id_favoris) VALUES (:id_user, :id_favorite)");
				$requete->execute(array(
					':id_user' 		=> $_SESSION['membre_id'],
					':id_favorite' 	=> $idFavorite
		  		));
		  		$requete->closeCursor();

		  		echo json_encode(array("erreur" => false));

			}

			else{
				echo json_encode(array("erreur" => true));
			}

			$reponse->closeCursor();

		}
	}


	function removeFavSlacker(){
		global $PDO;

		$currentUserId = (int)$_SESSION['membre_id'];

		if(isset($_POST['userId']) && !empty($_POST['userId'])){
			$idFavorite = ((int)$_POST['userId'] == 0 ) ? 0 : (int)$_POST['userId'];
		}
		else{
			echo json_encode(
				array(
					"erreur" => true,
					"msg" => "Une erreur est survenue lors de la suppression de données"
			));
		}

		if($idFavorite != 0){

			$reponse = $PDO->prepare('SELECT id_utilisateur, id_favoris FROM utilisateurs_favoris WHERE id_utilisateur = :userId AND id_favoris = :idFavorite');
			$reponse->bindValue('userId', $currentUserId);
			$reponse->bindValue('idFavorite', $idFavorite); 
			$reponse->execute();

			if ($reponse->fetchColumn() > 0) {

				$requete = $PDO->prepare("DELETE FROM utilisateurs_favoris WHERE id_utilisateur = :userId AND id_favoris = :idFavorite");
				$requete->execute(array(
					':userId' 		=> $currentUserId,
					':idFavorite' 	=> $idFavorite
		  		));
		  		$requete->closeCursor();

		  		echo json_encode(array("erreur" => false, "removedId" => $idFavorite));
			}

			else{
				echo json_encode(array("erreur" => true));
			}

			$reponse->closeCursor();

		}
	}











?>