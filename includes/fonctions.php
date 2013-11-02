<?php

// Déconnexion basique

if(isset($_GET['logout'])){

    if(isset($_SESSION)){

        $_SESSION = array();
        unset($_SESSION);
        session_destroy();

    }
}

?>