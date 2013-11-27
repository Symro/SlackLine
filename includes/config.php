<?php

/*************************** CONFIGURATION DE LA BASE ************************************/
define("PARAM_hote",        'localhost'); // le chemin vers le serveur
define("PARAM_nom_bd",      'hetic_slackline'); // le nom de votre base de données
define("PARAM_utilisateur", 'root'); // nom d'utilisateur pour se connecter
define("PARAM_mot_passe",   ''); // mot de passe de l'utilisateur pour se connecter

define('ROOTPATH', 'http://'.$_SERVER['HTTP_HOST'].'/pariSlack/', true);
define('TITRESITE', 'Parislack - Recherche de spot de Slackline sur Paris', true);
define('CLASSPAGE', 'accueil', true);

try
{
	global $PDO;
	$PDO = new PDO('mysql:host='.PARAM_hote.';dbname='.PARAM_nom_bd, PARAM_utilisateur, PARAM_mot_passe);
	$PDO->exec("set names utf8");
}
catch(Exception $e)
{
	echo 'Une erreur est survenue lors de la connexion';
	die();
}
