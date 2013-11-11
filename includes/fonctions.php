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


?>