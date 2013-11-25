<?php
include('includes/config.php'); 
include('includes/fonctions.php'); 


    if (isset($_POST['latitude'])&&!empty($_POST['latitude'])&&isset($_POST['longitude'])&&isset($_POST['latitude'])) {

        // On assigne aux variables les valeurs récupérée
        $latitude=floatval($_POST['latitude']);
        $longitude=floatval($_POST['longitude']);

        if (!empty($_POST['titre'])&&isset($_POST['titre'])) {

            $titre=filter_var($_POST['titre'],FILTER_SANITIZE_STRING);

            if (isset($_POST['description'])&&!empty($_POST['description'])) {

                    $description=filter_var($_POST['description'],FILTER_SANITIZE_STRING);

                    if (isset($_POST['adresse'])&&!empty($_POST['adresse'])) {

                        $adresse=filter_var($_POST['adresse'],FILTER_SANITIZE_STRING);

                        // Préparation de la requete puis execution
                        $stmt=$PDO->prepare('INSERT INTO spots (latitude,longitude,titre,description,adresse) VALUES (:latitude,:longitude,:titre,:description,:adresse)');
                        $stmt->bindParam(':latitude',$latitude);
                        $stmt->bindParam(':longitude',$longitude);
                        $stmt->bindParam(':titre',$titre);
                        $stmt->bindParam(':description',$description);
                        $stmt->bindParam(':adresse',$adresse);

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
                                "msg"=>"adresse incorrecte"
                        ));
                    }
                    
            }else{
                echo json_encode(
                array(
                        "error"=>true,
                        "msg"=>"Description incorrecte"
                ));
            }
                
        }else{
                echo json_encode(
                array(
                        "error"=>true,
                        "msg"=>"Titre incorrect"
                ));
        }
    }else{
        echo json_encode(
                array(
                        "error"=>true,
                        "msg"=>"Latitude et longitude incorrectes"
        ));
    }
?>