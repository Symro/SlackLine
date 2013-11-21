<?php
	
include "includes/config.php";


if($_POST){

	$id_fb = intval($_POST['id_fb']);

	// Conversion du format facebook (02/19/1988) au format SQL Date (1988-02-19)
    $birthdayDate = DateTime::createFromFormat('m/d/Y', $_POST['birthday']);
    $birthdayFormat = $birthdayDate->format('Y-m-d');

   	// Vérification de la présence du compte fb dans la BDD
	$selectFbId = $PDO->query("SELECT id_fb FROM utilisateurs WHERE id_fb = $id_fb");
	$selectFbId->execute();

	if($selectFbId->rowCount() == 0){

		$response = $PDO->prepare("INSERT INTO utilisateurs VALUES(NULL, :id_fb , '', :nom , :prenom , '' , :email , :date_naissance , :genre , '' , '', '', '') ") or die(print_r($PDO->errorInfo()));

		$response->execute(
			array(
				'id_fb' 			=> $id_fb,
				'nom' 				=> $_POST['last_name'],
				'prenom' 			=> $_POST['first_name'],
				'email' 			=> $_POST['email'],
				'date_naissance' 	=> $birthdayFormat,
				'genre' 			=> $_POST['gender']
			)
		);

		echo json_encode( array( 'adding_data' => true , 'redirect_profile' => false ) );

	}
	else{

		echo json_encode( array( 'adding_data' => false , 'redirect_profile' => false) );

	}



}



?>