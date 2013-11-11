<?php

session_start();
header('Content-type: text/html; charset=utf-8');
include('config.php'); 
include('fonctions.php'); 


if($_POST)
{

    global $PDO;

    $q = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['search']);

    $reponse = $PDO->query("SELECT id,latitude, longitude, titre, description, adresse, materiel, note, categorie
        FROM spots
        WHERE titre LIKE '%$q%' 
        OR adresse LIKE '%$q%'
        LIMIT 0 , 10 ") or die( print_r( $PDO->errorInfo() ));

    // Recherche les spots favoris de l'utilisateur connecté
    $fav = $PDO->prepare("SELECT id_spot FROM spots_favoris WHERE id_utilisateur = :userId ");
    $fav->execute(array(
        ':userId' => $_SESSION['membre_id']
    ));
    $favorite = $fav->fetchAll();


    // Message d'erreur si aucun résultat
    $count = $reponse->rowCount();
    if(!$count){ 
        echo "<div class='show'>Aucun résultat</div>";
    }

    // Affichage des résultats
    while($donnee = $reponse->fetch(PDO::FETCH_ASSOC))
    {
        $id         = $donnee['id'];
        $username   = $donnee['titre'];
        $email      = $donnee['adresse'];
        $b_username = '<strong>'.$q.'</strong>';
        $b_email    = '<strong>'.$q.'</strong>';
        $final_username = str_ireplace($q, $b_username, $username);
        $final_email = str_ireplace($q, $b_email, $email);

        // Si le spot est déjà en favoris > classe de suppression
        $fav = deep_in_array( $id , $favorite);
        $class = ($fav)? "removeFavSpot" : "addFavSpot";
        $text  = ($fav)? "Supprimer des spots favoris" : "Ajouter aux spots favoris";


        ?>
            <div class="show">
                <button class="<?php echo $class; ?>" data-id="<?php echo $id; ?>"><?php echo $text; ?></button>
                <span><?php echo $final_username; ?> - </span>
                <span><?php echo $final_email; ?></span>
            </div>
        <?php
    }

}

?>