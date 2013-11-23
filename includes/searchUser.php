<?php

session_start();
header('Content-type: text/html; charset=utf-8');
include('config.php'); 
include('fonctions.php'); 


if($_POST)
{

    global $PDO;

    $q = preg_replace("/[^A-Za-z0-9.@]/", " ", $_POST['search']);

    $reponse = $PDO->query("SELECT id,nom, prenom, email, niveau, technique, description, telephone
        FROM utilisateurs
        WHERE nom LIKE '%$q%' 
        OR prenom LIKE '%$q%'
        OR email LIKE '%$q%'
        LIMIT 0 , 10 ") or die( print_r( $PDO->errorInfo() ));

    // Recherche les spots favoris de l'utilisateur connecté
    $fav = $PDO->prepare("SELECT id_favoris FROM utilisateurs_favoris WHERE id_utilisateur = :userId ");
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
        $id         = $donnee['id'];
        $nom        = strtoupper(substr($donnee['nom'], 0, 1));
        $username   = $donnee['prenom'].' '.$nom.'.';
        $email      = $donnee['email'];
        $niveau     = $donnee['niveau'];
        $telephone  = $donnee['telephone'];
        $b_username = '<strong>'.$q.'</strong>';
        $b_email    = '<strong>'.$q.'</strong>';
        $final_username = str_ireplace($q, $b_username, $username);
        $final_email = str_ireplace($q, $b_email, $email);

        // Si le spot est déjà en favoris > classe de suppression
        $fav = deep_in_array( $id , $favorite);
        $class = ($fav)? "removeFavSlacker" : "addFavSlacker";
        $text  = ($fav)? "Supprimer des slackers favoris" : "Ajouter aux slackers favoris";

        // Si l'utilisateur n'a pas de photo, image par défaut
        if (file_exists('../upload/'.$donnee['id'].'.jpg')) {
            $photo = ROOTPATH.'upload/'.$donnee['id'].'.jpg';
        }
        else{
            $photo = ROOTPATH.'upload/default.jpg';
        }

        ?>
            <div class="show <?php echo $class_show; ?>" data-id="<?php echo $id; ?>">
                <?php if($class_show == "complet"){ ?>
                    <button class="<?php echo $class; ?>" data-id="<?php echo $id; ?>"><?php echo $text; ?></button>
                    <img src="<?php echo $photo; ?>" alt="Image utilisateur"/>
                    <span><?php echo $final_username; ?></span>
                    <span><?php echo $niveau; ?></span>
                <?php } else{ ?>
                    <img src="<?php echo $photo; ?>" alt="Image utilisateur"/>
                    <div>
                        <p><?php echo $final_username; ?></p>
                        <p><?php echo $niveau; ?></p>
                        <p><?php echo $telephone; ?></p>
                        <p><?php echo $email; ?></p>
                    </div>
                <?php } ?>
            </div>
        <?php
    }

}

?>