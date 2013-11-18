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

	//var_dump($_SESSION);
	// echo " <br/> BDD Email  : ".$_SESSION['membre_email'];
	// echo " <br/> BDD Identifiant  : ".$_SESSION['membre_id'];
	// echo " <br/> BDD Mdp  : ".$_SESSION['membre_mdp']." <br/><br/>";

	?>


	<button class="temp"> SPOTS OUVERT </button>

	<!--<button id="getProfil"> Mon profil </button>-->

	<div class="content">

	</div>

	<?php //nextDays(5); ?>

	<div id="content">

	</div>
	<div id="slackers">
	
	</div>
	
	
	<!-- CODE SYLVAIN FUSION -->
	
		<button id="maPosition">Me localiser</button>
        <div id="answer">
        </div>
        <div id="map">
        </div>

        <div id="dialog-form" title="Ajouter un spot">
            <p class="validateTips">All form fields are required.</p>

            <form>
                <fieldset>
                    <label for="titre">Nom du spot : </label>
                    <input type="text" name="titre" class="text ui-widget-content ui-corner-all" id="name" />
                    <label for="description">Description du spot : </label>
                    <input type="text" name="description" class="text ui-widget-content ui-corner-all" />
                    <label for="adresse">Adresse du spot :</label>
                    <input type="text" name="adresse" class="text ui-widget-content ui-corner-all">
                    <!-- <input type="checkbox" name="categorie" value="shortline"><label>shortline</label>
                    <input type="checkbox" name="categorie" value="longline"><label>longline</label> -->
                </fieldset>
            </form>
        </div>
	
	<!-- FIN CODE SYLVAIN FUSION -->
	
	<?php $img_profil = imageExists(); ?>
	<img src="<?php if($img_profil){ echo $img_profil; } ?>" id="profilDisplay" alt="Accéder à mon profil"/>

	<aside id="profil">

		<section class="infos">
			<figure>
				<img src="upload/default.jpg" alt="Photo de profil" />
				<div></div>
				<figcaption>
					
				</figcaption>
			</figure>
			<div>
				<span></span>
				<span></span>
			</div>
			<div></div>
			<label for="phone">Téléphone :</label>
			<input type="tel" name="phone" id="phone" class="uneditable" placeholder="Téléphone" pattern='^[0-9]{10}$' disabled />

			<label for="email">Email :</label>
			<input type="email" name="email" id="email" class="uneditable" disabled />

			<button id="editProfil" class="" >Modifier mon profil</button>

			<div align="center" class="editProfilImage hidden">
				<form action="processupload.php" method="post" enctype="multipart/form-data" id="uploadForm">
					<input name="ImageFile" type="file" />
					<input type="submit"  id="submitButton" value="Upload" />
				</form>
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
				<li class="skill waterline" data-type="waterline">Waterline</li>
			</div>
			<button name="editSkills" class="hidden">Enregistrer les modifications</button>
		</section>

		<section class="spotsFav">
			<h2><strong>Spots</strong> favoris</h2>
			<input type="text" class="searchSpot" id="searchSpot" placeholder="Rechercher des spots" />
			<label for="searchSpot" class='btn-search'/>Rechercher</label>
			<div id="resultSpots"></div>

		</section>

		<section class="slackersFav">
			<h2><strong>Slackers</strong> favoris</h2>

			<input type="text" class="searchUser" id="searchUser" placeholder="Rechercher des slackers" />
			<label for='searchUser' class='btn-search'>Rechercher</label>
			<div id="resultUsers"></div>
		</section>

		<a href="#" id="logout">Déconnexion</a>


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