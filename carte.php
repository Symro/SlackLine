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

        <div id="itineraryForm" title="Calculer un intinéraire">
            <p class="validateTips">All form fields are required.</p>

            <form>
                <fieldset>
                        <p>Selectionnez votre type de transport : </p>
                        <span id="car">Voiture</span>
                        <span id="walk">A pied</span>
                        <span id="transit">Transports</span>
                        <span id="bike">A bicyclette</span>
                    <label for="depart">Départ : </label>
                    <input type="text" name="depart" class="text ui-widget-content ui-corner-all" id="depart" />
                    <label for="arrivee">Arrivée : </label>
                    <input type="text" name="arrivee" class="text ui-widget-content ui-corner-all" />
                </fieldset>
            </form>
        </div>

        <div id="subscribeSpot" class="hidden">
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
	
	<!-- FIN CODE SYLVAIN FUSION -->

	<!-- FUSION CODE AUDREY -->

	

	<aside id="spot">
		<!-- HOME -->
		<section id="accueilCarte" class="content">

			<header class="logo">
				<img src="img/logo.svg" alt="Logo" />
			</header>

			<div class="rechercheSpot">
				<h2><strong>Rechercher</strong> un spot</h2>
				<input type="text" class="searchSpot" id="searchSpot" placeholder="Vincennes, Ourcq…" />
				<label for='searchSpot' class='btn-search'>Rechercher</label>
				<div class="result" id="resultSpot"></div>
			</div>

			<div class="marquerSpot">
				<h2><strong>Marquer</strong> un spot</h2>
				<a href="#infoSpot" id="newSpot" class="btn large">Marquer un spot</a>
				<!-- <a href="infoSpot.php"></a> -->
			</div>

			<div class="rechercheSlacker">
				<h2><strong>Rechercher</strong> un slacker</h2>
				<input type="text" class="searchUser" id="searchUser" placeholder="Tapez un nom" />
				<label for='searchUser' class='btn-search'>Rechercher</label>
				<div class="result" id="resultUser"></div>
			</div>

		</section>

		<!-- STEP 1 -->
		<section id="infoSpot" class="panel">
		
			<nav>
				<ul>
					<li><a href="#accueilCarte"><img src="img/precedent.svg" alt="Page précédente" /></a></li>
					<li><a href="#accueilCarte"><img src="img/close.svg" alt="fermer" /></a></li>
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
	                	<input type="text" class="addSpot" name="addressAdded" placeholder="Vincennes, Ourcq…" />
	                	<input type="submit" class='btn-large' name="validAddress"/></input>
	                </fieldset>
	            </form>
			</div>

			<form>
                <fieldset>
                    <label for="titre">Nom du spot : </label>
                    <input type="text" name="spotName" id="titre" />
                    <label for="description">Description du spot : </label>
                    <textarea name="description" placeholder="Quels sont les point positifs de ce spot ?" rows="5" class="description" id="description"></textarea>
                    <label for="adresse">Adresse du spot :</label>
                    <input type="text" name="spotAddress" id="adresse" />
                </fieldset>
            </form>
			
			
	        <footer>
	            
	            <a href="#catSpot" class="btn" >Suivant</a>
			</footer>
		</section>

		<!-- STEP 2 -->

		<section id="catSpot" class="panel">
			<nav>
				<ul>
					<li><a href="#infoSpot"><img src="img/precedent.svg" alt="Page précédente" /></a></li>
					<li><a href="#accueilCarte"><img src="img/close.svg" alt="fermer" /></a></li>
				</ul>
			</nav>
			
			<header class="lieu">
				<h3>Parc ML Kingk</h3>
				<p>26.10.2013 - 14h30.17h30</p>
			</header>

			<div class="skills">
				<h2><strong>Catégories</strong> pratiquées</h2>
				<ul class="clearfix">
					<li class="skill shortline" data-type="shortline">Shortline</li>
					<li class="skill trickline" data-type="trickline">Trickline</li>
					<li class="skill jumpline" data-type="jumpline">Jumpline</li>
					<li class="skill longline" data-type="longline">Longline</li>
					<li class="skill highline" data-type="highline">Highline</li>
					<li class="skill blindline" data-type="blindline">Blindline</li>
					<li class="skill waterline" data-type="waterline">Waterline</li>
				</ul>
			</div>

			<footer class="suivant">
				<button id="saveSpot" class="btn large">Valider</button>
				<div class="hidden">
					<a href="#accueilCarte" class="btn" >J'ai terminé</a>
					<a href="#detailSpot" class="btn" >Je m'y rend</a>
				</div>
			</footer>

		</section>

		<!-- STEP 3 -->

		<section id="detailSpot" class="panel">
			<nav>
				<ul>
					<li><a href="#catSpot"><img src="img/precedent.svg" alt="Page précédente" /></a></li>
					<li><a href="#accueilCarte"><img src="img/close.svg" alt="fermer" /></a></li>
				</ul>
			</nav>

			<div>
				<h2><strong>Calculer</strong> l'itinéraire</h2>

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

		</section>

	</aside>

	<div id="slacker" class="close">
		<nav>
			<ul>
				<li><button class="favSlacker" alt="Ajouter ou supprimer des slackers favoris"></button></li>
				<li><a href="#" id="closeSlacker"><img src="img/close.svg" alt="Fermer" /></a></li>
			</ul>
		</nav>

		
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

		</section>

		<section class="skills">
			<h2><strong>Catégories</strong> pratiquées</h2>
			<ul class="clearfix">
				<li class="skill shortline" data-type="shortline">Shortline</li>
				<li class="skill trickline" data-type="trickline">Trickline</li>
				<li class="skill jumpline" data-type="jumpline">Jumpline</li>
				<li class="skill longline" data-type="longline">Longline</li>
				<li class="skill highline" data-type="highline">Highline</li>
				<li class="skill blindline" data-type="blindline">Blindline</li>
				<li class="skill waterline" data-type="waterline">Waterline</li>
			</ul>
		</section>

		<section class="spotsFav">
			<h2><strong>Spots</strong> favoris</h2>
			<div class="result"></div>

		</section>


	</div>

	
	<div class="reseauxSociaux">
		<ul>
			<li class="fb"><a href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=http://alexandreguerard.fr/site/PariSlack/&p[images][0]=&p[title]=Parislack&p[summary]=Parislack%20r%C3%A9f%C3%A9rence%20tous%20les%20meilleurs%20spot%20de%20slackline%20dans%20Paris%20et%20ses%20alentours,%20rejoignez-nous%20!" target="_blank"></a></li>
			<li class="twitter"><a href="http://twitter.com/home?status=Parislack%20r%C3%A9f%C3%A9rence%20les%20meilleurs%20spot%20de%20slackline%20dans%20Paris%20et%20ses%20alentours,%20rejoignez-nous%20!%20http://alexandreguerard.fr/site/PariSlack" target="_blank"></a></li>
			<li class="google"><a href="https://plus.google.com/share?url=http://alexandreguerard.fr/site/PariSlack" target="_blank"></a></li>
		</ul>
	</div>

	<!-- FIN FUSION CODE AUDREY -->
	
	<?php $img_profil = imageExists(); ?>
	<img src="<?php if($img_profil){ echo $img_profil; } ?>" id="profilDisplay" alt="Accéder à mon profil"/>

	<aside id="profil">
		<nav>
			<a href="#" id="profilClose"><img src="img/close.svg" alt="Fermer"/></a>
		</nav>

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
			<ul class="clearfix">
				<li class="skill shortline" data-type="shortline">Shortline</li>
				<li class="skill trickline" data-type="trickline">Trickline</li>
				<li class="skill jumpline" data-type="jumpline">Jumpline</li>
				<li class="skill longline" data-type="longline">Longline</li>
				<li class="skill highline" data-type="highline">Highline</li>
				<li class="skill blindline" data-type="blindline">Blindline</li>
				<li class="skill waterline" data-type="waterline">Waterline</li>
			</ul>
			<button name="editSkills" class="hidden">Enregistrer les modifications</button>
		</section>

		<section class="spotsFav">
			<h2><strong>Spots</strong> favoris</h2>
			<input type="text" class="searchSpot" id="searchSpotInProfil" placeholder="Rechercher des spots" />
			<label for="searchSpotInProfil" class='btn-search'/>Rechercher</label>
			<div class="result"></div>

		</section>

		<section class="slackersFav">
			<h2><strong>Slackers</strong> favoris</h2>

			<input type="text" class="searchUser" id="searchUserInProfil" placeholder="Rechercher des slackers" />
			<label for='searchUserInProfil' class='btn-search'>Rechercher</label>
			<div class="result user"></div>
		</section>

		<a href="#" id="logout">Déconnexion</a>


	</aside>

	<!-- Modal -->
	<div id="spotDisplay" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		</div>
		<div class="modal-body">
			<h2></h2>
			<div class="note"></div>
			
			<section class="description">

			</section>

			<section class="skills">
				<h2><strong>Catégories</strong> pratiquées</h2>
				<ul class="clearfix">
					<li class="skill shortline" data-type="shortline">Shortline</li>
					<li class="skill trickline" data-type="trickline">Trickline</li>
					<li class="skill jumpline" data-type="jumpline">Jumpline</li>
					<li class="skill longline" data-type="longline">Longline</li>
					<li class="skill highline" data-type="highline">Highline</li>
					<li class="skill blindline" data-type="blindline">Blindline</li>
					<li class="skill waterline" data-type="waterline">Waterline</li>
				</ul>
			</section>

			<section class="calendar">
				<h2><strong>Personnes</strong> Présentes</h2>
				<div class="selectJour">
					<?php nextDays(5); ?>
				</div>
				<div id="resultCalendar" class="result"></div>
				<button type="submit" name="validAddress" class="btn large">S'y rendre</button>
			</section>

		</div>

	</div>

	<!-- Modal -->
	<div id="spotInscription" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		</div>
		<div class="modal-body">
			<h2></h2>
			<div class="note"></div>
			
			<section class="description">

			</section>

			<section class="skills">
				<h2><strong>Catégories</strong> pratiquées</h2>
				<ul class="clearfix">
					<li class="skill shortline" data-type="shortline">Shortline</li>
					<li class="skill trickline" data-type="trickline">Trickline</li>
					<li class="skill jumpline" data-type="jumpline">Jumpline</li>
					<li class="skill longline" data-type="longline">Longline</li>
					<li class="skill highline" data-type="highline">Highline</li>
					<li class="skill blindline" data-type="blindline">Blindline</li>
					<li class="skill waterline" data-type="waterline">Waterline</li>
				</ul>
			</section>

			<section class="calendar">
				<h2><strong>Personnes</strong> Présentes</h2>
				<div class="selectJour">
					<?php nextDays(5); ?>
				</div>
				<div id="resultCalendar" class="result"></div>
				<button type="submit" name="validAddress" class="btn large">S'y rendre</button>
			</section>

		</div>

	</div>


<?php
}

// Sinon redirection
else{

	header("Location: ./index.php");
	exit;
	
}


?>



<?php include('footer.php'); ?>