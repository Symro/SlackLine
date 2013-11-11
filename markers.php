<?php 
    $fileName='markers.json';

    // Connexion avec la BDD
    $bdd=new PDO('mysql:host=localhost;dbname=parislack','root','');
    // Obtenir la liste des points
    $result=$bdd->query('SELECT latitude,longitude,titre FROM spots ORDER BY id');
    // On récupère la liste des markers dans un tableau
    $listMarkers='';
    while ($row=$result->fetch()) {
        // if ($listMarkers!='')$listMarkers.=','; //separation de la longitude et latitude par une virgule
        $listMarkers='['.$row['latitude'].']['.$row['longitude'].']';
    }
    // Fermeture de la connexion
    $result->closeCursor();
    
    echo json_encode($listMarkers)."<br/>";
?>