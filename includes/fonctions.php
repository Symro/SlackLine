<?php

// Déconnexion basique
if(isset($_GET['logout'])){

    if(isset($_SESSION)){

        $_SESSION = array();
        unset($_SESSION);
        session_destroy();

    }
}


// Fonction de recheche de valeur dans un array d'array
function deep_in_array($needle, $haystack) {
    if(in_array($needle, $haystack)) {
        return true;
    }
    foreach($haystack as $element) {
        if(is_array($element) && deep_in_array($needle, $element))
            return true;
    }
    return false;
}

// Recherche si l'utilisateur a uploadé une image dans son profil

function imageExists($id = null){
    if(isset($_SESSION['membre_id']) && $id == null){
        if (file_exists('./upload/'.$_SESSION['membre_id'].'.jpg')) {
            return ROOTPATH.'upload/'.$_SESSION['membre_id'].'.jpg?';
            }
        else{
            return ROOTPATH.'upload/default.jpg';
        }
    }
    elseif( $id ){
        if (file_exists('./upload/'.intval($id).'.jpg')) {
            return ROOTPATH.'upload/'.intval($id).'.jpg?';
        }
        else{
            return ROOTPATH.'upload/default.jpg';
        }
    }
    else{
        return false;
    }
}

// Regarde si une checkbox était cochée
function isChecked($chkname,$value)
{
    if(!empty($_POST[$chkname]))
    {
        foreach($_POST[$chkname] as $chkval)
        {
            if($chkval == $value)
            {
                return true;
            }
        }
    }
    return false;
}

// Affiche les 5 prochains jours
function nextDays($nb = 5){
    
    echo "<select>";

    for ($i = 0; $i < $nb; $i++){
        
        if($i == 0){ $date = "Aujourd'hui"; }
        elseif($i == 1){ $date = "Demain"; }
        else{ $date = "Le ".date("d/m/Y", time() + 86400 * $i); }

        echo "<option data-date=".date("Y-m-d", time() + 86400 * $i) .">" .$date. "</option>";
    }

    echo "</select>";
}



?>