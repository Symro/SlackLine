<?php 

session_start();
header('Content-type: text/html; charset=utf-8');
include('includes/config.php'); 
include('includes/fonctions.php'); 

$titre = "Paris Slackline - Login";
$custom_class = "logged";

include('header.php');

// Si l'utilisateur est identifié 
if ( isset($_SESSION['membre_logged_in']) && !empty($_SESSION['membre_logged_in']) && $_SESSION['membre_logged_in'] === true ){


	echo "BIENTOT ICI : AFFICHAGE DE LA CARTE <br/>";

	//var_dump($_SESSION);

	echo " <br/> BDD Email  : ".$_SESSION['membre_email'];

	echo " <br/> BDD Identifiant  : ".$_SESSION['membre_id'];

	echo " <br/> BDD Mdp  : ".$_SESSION['membre_mdp']." <br/><br/>";

	?>


	<button id="spotsLists"> Lister les spots </button>

	<button id="favoriteSpots"> Mes spots favoris </button>

	<button id="favoriteSlackers"> Mes slackers favoris </button>

	<button id="profil"> Mon profil </button>

	<a href="#" id="logout">Déconnexion</a>

	<div class="content">

		<input type="text" class="searchUser" id="searchUser" placeholder="Search for people" />&nbsp; &nbsp; Ex: <b><i>Sylvain, Augustin</i></b><br />
		<div id="resultUsers"></div>

	</div>

	<div class="content">

		<input type="text" class="searchSpot" id="searchSpot" placeholder="Search for spots" />&nbsp; &nbsp; Ex: <b><i>Ourcq, Parc</i></b><br />
		<div id="resultSpots"></div>

	</div>
	<div id="slackers">
	
	</div>
	<div id="affichageProfil">

	</div>

<?php
}

// Sinon redirection
else{

	header("Location: ./login.php");
	exit;
	
}


?>



<?php include('footer.php'); ?>