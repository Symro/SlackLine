<?php

session_start();
header('Content-type: application/json; charset=utf-8');
include('config.php'); 
include('fonctions.php'); 


if ( isset($_SESSION['membre_logged_in']) && !empty($_SESSION['membre_logged_in']) && $_SESSION['membre_logged_in'] === true ){


	/* ____________________ GET ____________________ */
	/* _____________________________________________ */

	if(isset($_GET['action']) && !empty($_GET['action'])) {
	    $action = $_GET['action'];
	    switch($action) {
	        case 'getSpotList' 		: getSpotList(); break;
	        case 'getFavSpots' 		: getFavSpots(); break;
	        case 'getFavSlackers' 	: getFavSlackers(); break;
	        case 'getUserProfil' 	: getUserProfil(); break;
	        case 'getSpotOpen' 		: getSpotOpen(); break;
	        case 'getSpot' 			: getSpot(); break;
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

			$reponse = $PDO->prepare('SELECT spots_favoris.id_spot, spots.titre, spots.description, spots.adresse, spots.categorie, spots.note, 
				(
					SELECT ROUND(AVG(NULLIF(note ,0)) ,1)
					FROM spots_favoris
					WHERE spots_favoris.id_spot = spots.id
				) note_moyenne_utilisateurs
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

				if (file_exists('../upload/'.$_SESSION['membre_id'].'.jpg')) {
					$donnees[0]['picture'] = ROOTPATH.'upload/'.$_SESSION['membre_id'].'.jpg?';
				}
				else{
					$donnees[0]['picture'] = ROOTPATH.'upload/default.jpg';
				}

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



	function getSpotOpen(){
		global $PDO;

		try {

			$reponse = $PDO->prepare('SELECT id, id_spot, id_utilisateur, COUNT(id_utilisateur) AS nb_utilisateur, CURRENT_TIMESTAMP AS date_actuelle_ts , UNIX_TIMESTAMP(date_ouverture) AS date_ouverture_ts , UNIX_TIMESTAMP(date_fermeture) as date_fermeture_ts, etat
							FROM spots_ouvert
							WHERE date_ouverture < CURRENT_TIMESTAMP 
							AND date_fermeture > CURRENT_TIMESTAMP');

			$reponse->execute();
			/*
			$reponse->execute(array(
	  		    ':currentUser' => $_SESSION['membre_id']
	  		));
			*/
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

	function getSpot(){

			global $PDO;

		    // Obtenir la liste des points
            $result = $PDO->query('SELECT id,latitude,longitude,titre,description,adresse,materiel,note,categorie FROM spots');
            // On récupère la liste des markers dans un tableau
            $markers=json_encode($result->fetchAll(PDO::FETCH_ASSOC));
            // Fermeture de la connexion
            $result->closeCursor();
            // On crée un fichier JSON
            $createJson=fopen("../markers.json", 'w+');
            // On écrit dans le fichier JSON les markers enregistrés dans la BDD
            fputs($createJson,$markers);

	}





	/* ____________________ POST ____________________ */
	/* ______________________________________________ */
	

	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];
	    switch($action) {
	        case 'addFavSlacker' 	: addFavSlacker(); break;
	        case 'addFavSpot' 		: addFavSpot(); break;
	        case 'removeFavSlacker' : removeFavSlacker(); break;
	        case 'removeFavSpot' 	: removeFavSpot(); break;
	        case 'editProfil' 		: editProfil(); break;
	        case 'saveSkills' 		: saveSkills(); break;

	        case 'getSlackerProfil' : getSlackerProfil(); break;
	        case 'getSlackerOnSpot' : getSlackerOnSpot(); break;

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

		  		echo json_encode(array("erreur" => false, "id" => $idFavorite));

			}

			else{
				echo json_encode(array("erreur" => true ));
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

		  		echo json_encode(array("erreur" => false, "id" => $idFavorite));
			}

			else{
				echo json_encode(array("erreur" => true));
			}

			$reponse->closeCursor();

		}
	}

	function addFavSpot(){
		global $PDO;

		$currentUserId = (int)$_SESSION['membre_id'];

		if(isset($_POST['spotId']) && !empty($_POST['spotId'])){
			$idFavorite = ((int)$_POST['spotId'] == 0 ) ? 0 : (int)$_POST['spotId'];
		}
		else{
			echo json_encode(
				array(
					"erreur" => true,
					"msg" => "Une erreur est survenue lors de l'ajout de données"
			));
		}

		if($idFavorite != 0){

			$reponse = $PDO->prepare('SELECT id_utilisateur, id_spot, note FROM spots_favoris WHERE id_utilisateur = :userId AND id_spot = :idFavorite');
			$reponse->bindValue('userId', $currentUserId);
			$reponse->bindValue('idFavorite', $idFavorite); 
			$reponse->execute();

			if ($reponse->fetchColumn() == 0) {

				$requete = $PDO->prepare("INSERT INTO spots_favoris (id_utilisateur, id_spot) VALUES (:id_user, :id_favorite)");
				$requete->execute(array(
					':id_user' 		=> $_SESSION['membre_id'],
					':id_favorite' 	=> $idFavorite
		  		));
		  		$requete->closeCursor();

		  		echo json_encode(array("erreur" => false, "id" => $idFavorite));

			}

			else{
				echo json_encode(array("erreur" => true));
			}

			$reponse->closeCursor();

		}

	}

	function removeFavSpot(){
		global $PDO;

		$currentUserId = (int)$_SESSION['membre_id'];

		if(isset($_POST['spotId']) && !empty($_POST['spotId'])){
			$idFavorite = ((int)$_POST['spotId'] == 0 ) ? 0 : (int)$_POST['spotId'];
		}
		else{
			echo json_encode(
				array(
					"erreur" => true,
					"msg" => "Une erreur est survenue lors de la suppression de données"
			));
		}

		if($idFavorite != 0){

			$reponse = $PDO->prepare('SELECT id_utilisateur, id_spot FROM spots_favoris WHERE id_utilisateur = :userId AND id_spot = :idFavorite');
			$reponse->bindValue('userId', $currentUserId);
			$reponse->bindValue('idFavorite', $idFavorite); 
			$reponse->execute();

			if ($reponse->fetchColumn() > 0) {

				$requete = $PDO->prepare("DELETE FROM spots_favoris WHERE id_utilisateur = :userId AND id_spot = :idFavorite");
				$requete->execute(array(
					':userId' 		=> $currentUserId,
					':idFavorite' 	=> $idFavorite
		  		));
		  		$requete->closeCursor();

		  		echo json_encode(array("erreur" => false, "id" => $idFavorite));
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

	function saveSkills(){
		global $PDO;

		$currentUserId = (int)$_SESSION['membre_id'];

		if(isset($_POST['skills']) && !empty($_POST['skills'])){

			$real_skills = array("shortline", "trickline", "jumpline", "longline", "highline", "blindline", "waterline");
			$skills = $_POST['skills'];
			// On fait la différence entre les valeurs reçues par l'utilistaur et les 'vraies valeurs'
			$difference = array_intersect($skills, $real_skills);
			$final_skills = implode(", ", $difference);


			$reponse = $PDO->prepare('UPDATE utilisateurs SET technique = :valeur WHERE id = :currentUserId');
			$reponse->bindValue(':valeur', $final_skills);
			$reponse->bindValue(':currentUserId', $currentUserId);
			$reponse->execute();


			echo json_encode(array(
				"erreur" => false, 
				"msg" => "Catégories pratiquées modifiées !"
			));
		}
		else{
			die( json_encode(array("erreur" => true, "msg" => "Veuillez sélectionner au moins une catégorie :" )));
		}


	}



	function getSlackerProfil(){
		global $PDO;

		try {

			if(isset($_POST['userId']) && !empty($_POST['userId'])){
				$userId = ((int)$_POST['userId'] == 0 ) ? 0 : (int)$_POST['userId'];
			}

			$reponseProfil = $PDO->prepare('SELECT id, nom, prenom, email, date_naissance, niveau, technique, description, materiel, telephone
							FROM utilisateurs
							WHERE id = :userId');

			$reponseProfil->execute(array(
	            ':userId' => $userId
	        ));


			$reponseFav = $PDO->prepare('SELECT spots_favoris.id_spot, spots.titre, spots.description, spots.adresse, spots.categorie, spots.note, 
				(
					SELECT ROUND(AVG(NULLIF(note ,0)) ,1)
					FROM spots_favoris
					WHERE spots_favoris.id_spot = spots.id
				) note_moyenne_utilisateurs
				FROM spots_favoris
				INNER JOIN spots
				ON spots_favoris.id_spot = spots.id
				WHERE spots_favoris.id_utilisateur = :currentUser');

			$reponseFav->execute(array(
	            ':currentUser' => $userId
	        ));

	        $reponseInFav = $PDO->prepare('SELECT utilisateurs.id, nom, prenom, niveau
							FROM utilisateurs_favoris
							INNER JOIN utilisateurs
							ON utilisateurs_favoris.id_favoris =  utilisateurs.id
							WHERE utilisateurs_favoris.id_utilisateur = :currentUser
							AND utilisateurs_favoris.id_favoris = :userId');

			$reponseInFav->execute(array(
	            ':currentUser' => $_SESSION['membre_id'],
	            ':userId' => $userId
	        ));


			if( $reponseProfil ) {

				$donneesProfil 	= $reponseProfil->fetchAll(PDO::FETCH_ASSOC);
				$donneesFav 	= $reponseFav->fetchAll(PDO::FETCH_ASSOC);
				$donneesInFav 	= $reponseInFav->fetchAll(PDO::FETCH_ASSOC);

				if($donneesProfil){

					/* $donneesProfil[0]['picture'] = imageExists($userId); */

					if($donneesFav){
						$donneesProfil[1] = $donneesFav;
					}

					$donneesProfil[0]['favoris'] = empty($donneesInFav) ? false : true;
					$donneesProfil[0]['favoris_class'] = empty($donneesInFav) ? 'addFavSlacker' : 'removeFavSlacker';
					
					
					if (file_exists('../upload/'.$userId.'.jpg')) {
						$donneesProfil[0]['picture'] = ROOTPATH.'upload/'.$userId.'.jpg?';
					}
					else{
						$donneesProfil[0]['picture'] = ROOTPATH.'upload/default.jpg';
					}
					

					echo json_encode($donneesProfil);
					$reponseFav->closeCursor();
					$reponseInFav->closeCursor();
					$reponseProfil->closeCursor();
				}
				else{
					echo json_encode(
						array(
							"erreur" => true,
							"msg" => "Ce profil n'existe pas"
					));
				}
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

	function getSlackerOnSpot(){
		global $PDO;

		try {

			$reponse = $PDO->prepare("SELECT utilisateurs.id, nom, prenom, niveau, HOUR(spots_ouvert.date_ouverture), HOUR(spots_ouvert.date_fermeture)
							FROM utilisateurs
							INNER JOIN spots_ouvert
							ON spots_ouvert.id_utilisateur =  utilisateurs.id
							WHERE date_ouverture LIKE CONCAT(:date,'%') 
							AND spots_ouvert.id_spot = :spot");

			$reponse->execute(array(
	            ':date'	=> $_POST['date'],
	            ':spot'	=> $_POST['spot']
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









?>