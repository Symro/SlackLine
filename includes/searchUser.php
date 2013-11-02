<?php

session_start();
header('Content-type: text/html; charset=utf-8');
include('config.php'); 


if($_POST)
{

    global $PDO;

    $q = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['search']);

    $reponse = $PDO->query("SELECT id,nom, prenom, email, niveau, technique, description
        FROM utilisateurs
        WHERE nom LIKE '%$q%' 
        OR email LIKE '%$q%'
        LIMIT 0 , 10 ") or die( print_r( $PDO->errorInfo() ));



    while($donnee = $reponse->fetch(PDO::FETCH_ASSOC))
    {
        $id         = $donnee['id'];
        $username   = $donnee['nom'];
        $email      = $donnee['email'];
        $b_username = '<strong>'.$q.'</strong>';
        $b_email    = '<strong>'.$q.'</strong>';
        $final_username = str_ireplace($q, $b_username, $username);
        $final_email = str_ireplace($q, $b_email, $email);
        ?>
            <div class="show" style="display:block; margin-bottom:10px; width:100%;">
                <button class="addFavSlacker" data-id="<?php echo $id; ?>">Ajouter aux favoris</button>
                <span><?php echo $final_username; ?></span>
                <span><?php echo $final_email; ?></span>
            </div>
        <?php
    }

}

?>