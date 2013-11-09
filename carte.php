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





	<button id="getProfil"> Mon profil </button>

	<a href="#" id="logout">Déconnexion</a>

	<div class="content">



	</div>

	<div id="content">

	</div>
	<div id="slackers">
	
	</div>
	<div id="affichageProfil" style="position:absolute; right:10%; top:10%;">

	</div>

	<aside id="profil">

		<section class="infos">
			<figure>
				<img src="upload/default.jpg" alt="Photo de profil" />
				<figcaption>
					
				</figcaption>
			</figure>
			<div>
				<span></span>
				<span></span>
			</div>
			<div></div>

			<button id="editProfil" class=" " >Modifier mon profil</button>

			<div align="center" class="editProfilImage hidden">
				<form action="processupload.php" method="post" enctype="multipart/form-data" id="UploadForm">
					<input name="ImageFile" type="file" />
					<input type="submit"  id="SubmitButton" value="Upload" />
				</form>
				<div id="output"></div>
			</div>

		</section>

		<section class="skills">
			<h2><strong>Catégories</strong> pratiquées</h2>
			<div class="clearfix">
				<li class="skill shortline" data-type="shortline">Shortline</li>
				<li class="skill trickline" data-type="trickline">Trickline</li>
				<li class="skill jumpline" data-type="jumpline">Jumpline</li>
				<li class="skill longline" data-type="longline">Longline</li>
				<li class="skill highline" data-type="highline">Highline</li>
				<li class="skill blindline" data-type="blindline">Blindline</li>
			</div>
			<input type="submit" name="editSkills" class="hidden" value="Enregistrer les modifications" />
		</section>

		<section class="spotsFav">
			<h2><strong>Spots</strong> favoris</h2>
			<input type="text" class="searchSpot" id="searchSpot" placeholder="Search for spots" />&nbsp; &nbsp; Ex: <b><i>Ourcq, Parc</i></b><br />
			<div id="resultSpots"></div>

			<button id="favoriteSpots"> Mes spots favoris </button>

		</section>

		<section class="slackersFav">
			<h2><strong>Slackers</strong> favoris</h2>

			<input type="text" class="searchUser" id="searchUser" placeholder="Search for people" />&nbsp; &nbsp; Ex: <b><i>Sylvain, Augustin</i></b><br />
			<div id="resultUsers"></div>

			<button id="favoriteSlackers"> Mes slackers favoris </button>

		</section>


	</aside>




<?php
}

// Sinon redirection
else{

	header("Location: ./login.php");
	exit;
	
}


?>



<?php include('footer.php'); ?>