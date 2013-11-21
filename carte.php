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

	<!-- FUSION CODE AUDREY -->

	<!-- STEP 1 -->

	<aside id="spot">

		<section id="accueilCarte">

			<header class="logo">
				<img src="img/logo.svg" alt="Logo" />
			</header>

			<div class="rechercheSpot">
				<h2><strong>Rechercher</strong> un spot</h2>
				<input type="text" class="searchSpot" id="searchSpot" placeholder="Vincennes, Ourcq…" />
			</div>

			<div class="marquerSpot">
				<h2><strong>Marquer</strong> un spot</h2>
				<button id="spotStep2" class="btn large">Marquer un spot</button>
				<!-- <a href="placerMarqueur.php"></a> -->
			</div>

			<div class="rechercheSlacker">
				<h2><strong>Rechercher</strong> un slacker</h2>
				<input type="text" class="searchUser" id="searchUser" placeholder="Tapez un nom" />
				<label for='searchUser' class='btn-search'>Rechercher</label>
				<div id="resultUsers"></div>
			</div>

		</section>

		<!-- STEP 2 -->

		<section id="placerMarqueur" class="hidden">
		
			<nav>
				<ul>
					<li><a href="carte.php"><img src="img/precedent.svg" alt="Page précédente" /></a></li>
					<li><a href="#"><img src="img/close.svg" alt="fermer" /></a></li>
				</ul>
			</nav>

			<header class="logo">
				<img src="img/logo.svg" alt="Logo" />
			</header>

			<div class="placerLieu">
				<h2><strong>Placez</strong> votre lieu</h2>
				<p>Sur la carte à l’aide du clic droit ou entrez une adresse</p>
				<form id="addMarker">
	                <fieldset>
	                	<input type="text" class="addSpot" name="addSpot" placeholder="Vincennes, Ourcq…" />
	                	<input type="submit" for="addSpot" class='btn-large'/></input>
	                </fieldset>
	            </form>
			</div>

			<div class="quand">
				<h2><strong>Quand</strong> irez-vous à<br />ce spot ?</h2>
				
				<div class="selectJour">
				<?php nextDays(5); ?>
				</div>
				
				<div class="selectHeureDepart">
					<span>DE : </span>
					<input id="timeStart" data-format="HH:mm"  name="timeStart" type="text">

				</div>
				<div class="selectHeureArrivee">
					<span>À : </span>
					<input id="timeEnd" data-format="HH:mm"  name="timeEnd" type="text">
				</div>
				
				<div class="matos">
				 <label class="switch-button large" for="material">
	                <input type="checkbox" id="material" class="switch" name="material" value="yes" <?php if(isset($_POST['material'])) echo "checked='checked'"; ?> >
	                <span>Matériel           
	                    <span>Non</span>
	                    <span>Oui</span>
	                </span>
	                <a class="btn btn-primary"></a>
	              </label>
				</div>
				
				<div class="initiation">
				 <label class="switch-button large" for="initiation">
	                <input type="checkbox" id="initiation" class="switch" name="initiation" value="yes" <?php if(isset($_POST['initiation'])) echo "checked='checked'"; ?> >
	                <span>Proposer une initiation ? 
	                    <span>Non</span>
	                    <span>Oui</span>
	                </span>
	                <a class="btn btn-primary"></a>
	              </label>
	              <p>(Votre statut deviendra "professeur")</p>
				</div>
			</div>
	        
	        <footer>
	            <button id="spotStep3" class="btn" ><a href="placerMarqueur2.php">Suivant</a></button>
			</footer>
		</section>

		<!-- STEP 3 -->

		<section id="detailSpot" class="hidden">
			<nav>
				<ul>
					<li><a href="carte.php"><img src="img/precedent.svg" alt="Page précédente" /></a></li>
					<li><a href="#"><img src="img/close.svg" alt="fermer" /></a></li>
				</ul>
			</nav>
			
			<header class="lieu">
				<h3>Parc ML Kingk</h3>
				<p>26.10.2013 - 14h30.17h30</p>
			</header>

			<div class="categories">
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
			</div>

			<div class="noteDepart">
				<h2><strong>Note</strong> de départ</h2>
				<div class="etoile">[class="étoile"]</div>
				<p>Votre note : [Note]</p>
			</div>

			<div class="description">
				<h2><strong>Description</strong></h2>
				<textarea placeholder="Quels sont les point positifs de ce spot ?" rows="5" class="descriptionSpot" id="descriptionSpot"></textarea>
			</div>
			
			<footer class="suivant">
				<button name="next" class="">Suivant</button>
			</footer>

		</section>

	</aside>

	
	<div class="reseauxSociaux">
		<ul>
			<li class="fb"><a href="https://www.facebook.com/asso.parislack" target="_blank"></a></li>
			<li class="twitter"><a href="#" target="_blank"></a></li>
			<li class="google"><a href="#" target="_blank"></a></li>
		</ul>
	</div>

	<!-- FIN FUSION CODE AUDREY -->
	
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