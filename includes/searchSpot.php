<?php

session_start();
header('Content-type: text/html; charset=utf-8');
include('config.php'); 
include('fonctions.php'); 


if($_POST)
{

    global $PDO;

    $q = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['search']);

    $reponse = $PDO->query("SELECT id,latitude, longitude, titre, description, adresse, materiel, note, categorie,
        (
            SELECT ROUND(AVG(NULLIF(note ,0)) ,1)
            FROM spots_favoris
            WHERE spots_favoris.id_spot = spots.id
        ) note_moyenne_utilisateurs
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

    // Classe CSS pour l'affichage
    $class_show = isset($_POST['simpleSearch']) ? "simple" : "complet";


    // Affichage des résultats
    while($donnee = $reponse->fetch(PDO::FETCH_ASSOC))
    {
        $note       = $donnee['note_moyenne_utilisateurs'];
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
            <div class="show <?php echo $class_show; ?>" data-id="<?php echo $id; ?>">
                <?php if($class_show == "complet"){ ?>
                <button class="<?php echo $class; ?>" data-id="<?php echo $id; ?>"><?php echo $text; ?></button>
                <?php } ?>
                <span><?php echo $final_username; ?> - </span>
                <span><?php echo $final_email; ?></span>
                <div>
                    <div class="rateit-rated" min="0" max="5" data-rateit-value="<?php echo $note; ?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                </div>
            </div>
            
        <?php
    }

}

?>