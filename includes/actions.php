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
	        case 'editProfil' : editProfil(); break;

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

	function editProfil(){

		global $PDO;

		// Nettoie l'envoie de l'utilisateur (sécurité)
		$column = filter_var($_POST['name'] , FILTER_SANITIZE_STRING);

		// Nettoyage & vérifications mineures des valeurs envoyées
		if($column == "telephone"){
			$value = filter_var($_POST['value'], FILTER_SANITIZE_NUMBER_INT);

			if(strlen($value) != 10){
				header('HTTP/1.1 400 Incorrect value');
		    	die( "Numéro de téléphone incorrect" );
			}
		}
		elseif($column == "niveau"){
			$value = filter_var($_POST['value'], FILTER_SANITIZE_STRING);
			$niveaux = array("debutant","intermediaire","confirme","expert");

			if( ! in_array($value, $niveaux )){
				header('HTTP/1.1 400 Incorrect value');
		    	die( "Valeur incorrect" );
			}
		}
		elseif($column == "materiel"){
			$value = filter_var($_POST['value'], FILTER_SANITIZE_NUMBER_INT);
			if(strlen($value) != 1){
				header('HTTP/1.1 400 Incorrect value');
		    	die( "Valeur incorrect" );
			}
		}
		elseif($column == "date_naissance"){
			$value = filter_var($_POST['value'], FILTER_SANITIZE_STRING);
			if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value)){
				header('HTTP/1.1 400 Incorrect value');
		    	die( "Date de naissance incorrect" );
			}
			else{
				
			}

		}

		else{
			$value = filter_var($_POST['value'], FILTER_SANITIZE_STRING);
		}
		

		$currentUserId = (int)$_SESSION['membre_id'];

		if(isset($_POST['pk']) && !empty($_POST['pk'])){
			$pk = (int)$_POST['pk'];
		}

		// Vérification sur l'utilisateur avant modification des infos de son compte
		if($currentUserId == $pk){
			$reponse = null;

			switch($column)
		    {
		        case "nom":
		            $reponse = $PDO->prepare('UPDATE utilisateurs SET nom = :valeur WHERE id = :currentUserId');
		            break;
		        case "date_naissance":
		            $reponse = $PDO->prepare('UPDATE utilisateurs SET date_naissance = :valeur WHERE id = :currentUserId');
		            break;
		        case "niveau":
		            $reponse = $PDO->prepare('UPDATE utilisateurs SET niveau = :valeur WHERE id = :currentUserId');
		            break;
		        case "technique":
		            $reponse = $PDO->prepare('UPDATE utilisateurs SET technique = :valeur WHERE id = :currentUserId');
		            break;
		        case "description":
		            $reponse = $PDO->prepare('UPDATE utilisateurs SET description = :valeur WHERE id = :currentUserId');
		            break;
		        case "materiel":
		            $reponse = $PDO->prepare('UPDATE utilisateurs SET materiel = :valeur WHERE id = :currentUserId');
		            break;
		        case "telephone":
		            $reponse = $PDO->prepare('UPDATE utilisateurs SET telephone = :valeur WHERE id = :currentUserId');
		            break;
		        
		    }

		    if($reponse){

				$reponse->bindValue(':valeur', $value);
				$reponse->bindValue(':currentUserId', $currentUserId);
				$reponse->execute();

				echo json_encode(array("erreur" => false, 
					"msg" => "Informations modifiées !",
					"value" => $value
				));
		    	
		    }
		    else{

		    	header('HTTP/1.1 400 Bad Request');
		    	die( "Erreur : modification impossible" );

			}

		}
		else{
			echo json_encode(array("erreur" => true, "msg" => "Problème d'identification"));
		}




	}











?>