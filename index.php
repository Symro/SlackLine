<?php 

session_start();

header('Content-type: text/html; charset=utf-8');
include('includes/config.php'); 
include('includes/fonctions.php');

$titre = "Paris Slackline - Accueil";
$custom_class = "home";

include('header.php');
include('form_login.php');

?> 

<!-- Section0: Home Page   -->
<div class="header"></div>

<div class="section" id="section0">
  <div class="container">
    <div class="row-fluid">
      <div class="span3 offset7">
        <div class="greyBox">
          <div class="headerBox">
            <h1>Connecte-toi</h1><br/>
          </div>
          <div class="formulaire">
            <form autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="form-inscription" <?php if( isset($email_error) && $email_error === true ): ?>class="email-error"<?php endif; ?>>
              <input type="text" id="email" name="email" placeholder="EMAIL" required>
              <input type="password" id="password" name="password" placeholder="PASSWORD" required>
              <input type="submit" id="login" name="login" value="OK">
            </form>
            <section class="section-right slideLeft">
              <div class="iphone hidden-phone"></div>
            </section>      
            </br>
            <p>Ou se connecter avec:</p>
            <a href="#" id="fb-connect">Completer avec Facebook</a>
            <a href="#" id="google-connect">Completer avec Google+</a>
            <hr></form>
            <button class="btn-slack"><a href="inscription.php">INSCRIS-TOI</a></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a class="arrows-down" href="#secondPage" title="Découvrez la slackline"></a>
</div>
<!-- FIN Section0-->

<!-- Section1: Présentation de la SlackLine  -->
<div class="section" id="section1">
  <div class="container ">      
    <div class="row">
      <div id="owl-section1" class="owl-carousel">
        <div class="item">
          <div class="">
            <img src="img/anim/anim1.png" alt="HighLine">
          </div>
          <p>Parislack est une association créée en 2011 visant à promouvoir l'activité de la slackline sur Paris et toute sa région. Son but est de fédérer les pratiquants, organiser des événements et faire découvrir cette discipline.</p>
        </div>
        <div class="item">
          <div class="">
            <img src="img/anim/anim1.png" alt="HighLine">
          </div>
          <p>Le principe de la slackline est de progresser sur une sangle plate plus ou moins tendue (et placée plus ou moins haut) à la manière d'un funambule. Elle peut être pratiquée un peu partout (parcs, falaises, lacs, étangs, etc...) à moins de respecter certaines consignes de sécurité et d'installation.</p>
        </div>
        <div class="item">
          <div class="">
            <img src="img/anim/anim1.png" alt="HighLine">
          </div>
          <p>La communauté des slackers (les pratiquants) est surtout composée de passionnés qui revendique la convivialité et l'ouverture d'esprit qui caractérise ce sport.</p>
        </div>
        <div class="item">
          <div class="">
            <img src="img/anim/anim1.png" alt="HighLine">
          </div>
          <p>Le but de ce site web est principalement de permettre aux personnes souhaitant pratiquer - ou découvrir - cette discipline de pouvoir se retrouver sur les meilleurs spots de la capitale.</p>
        </div>
        <div class="item">
          <div class="">
            <img src="img/anim/anim1.png" alt="HighLine">
          </div>
          <p>En effet, grâce à un système de localisation et de marquage cartographié, chaque utilisateur peut indiquer à quel moment et quel jour il souhaite se rendre à un spot en particulier.</p>
        </div>
        <div class="item">
          <div class="">
            <img src="img/anim/anim1.png" alt="HighLine">
          </div>
          <p>Ainsi, les autres pratiquants peuvent voir en temps réel quels sont les spots occupés et pour combien de temps et ainsi décider de rejoindre ou non les slackers déjà présents.</p>
        </div>
        <div class="item">
          <div class="">
            <img src="img/anim/anim1.png" alt="HighLine">
          </div>
          <p>Si tu souhaite rejoindre la grande famille des slackers parisiens et découvrir cette discipline, inscris-toi à notre plateforme, trouve un spot et viens vite nous retrouver !</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- FIN Section1-->

<!-- Section2: Présentation des différentes pratique de la Slack-->
<div class="section" id="section2">
  <div class="container ">      
    <div class="row">
      <div id="owl-section2" class="owl-carousel">
        <div class="item">
          <div class="">
            <img src="img/icons/shortline.svg" alt="HighLine">
          </div>
          <div class="tableau">
            <h1>SHORTLINE</h1>
            <p>La highline (haute corde) nécessite une sangle tendue au-dessus de 5 mètres de hauteur. À une telle hauteur et a fortiori au delà, un équipement de sécurité doit être mis en place afin de ne pas risquer sa vie.</p>
          </div>
        </div>      
        <div class="item">
          <div class="">
            <img src="img/icons/longline.svg" alt="The Last of us">
            </div>
          <div class="tableau">
            <h1>LONGLINE</h1>
            <p>La highline (haute corde) nécessite une sangle tendue au-dessus de 5 mètres de hauteur. À une telle hauteur et a fortiori au delà, un équipement de sécurité doit être mis en place afin de ne pas risquer sa vie.</p>
          </div>
        </div>
        <div class="item">
          <div class="">
            <img src="img/icons/trickline.svg" alt="The Last of us">
          </div>
          <div class="tableau">
            <h1>TRICKLINE</h1>
            <p>La highline (haute corde) nécessite une sangle tendue au-dessus de 5 mètres de hauteur. À une telle hauteur et a fortiori au delà, un équipement de sécurité doit être mis en place afin de ne pas risquer sa vie.</p>
          </div>
        </div>
        <div class="item">
          <div class="">
            <img src="img/icons/jumpline.svg" alt="The Last of us">
          </div>
          <div class="tableau">
            <h1>JUMPLINE</h1>
            <p>La highline (haute corde) nécessite une sangle tendue au-dessus de 5 mètres de hauteur. À une telle hauteur et a fortiori au delà, un équipement de sécurité doit être mis en place afin de ne pas risquer sa vie.</p>
          </div>
        </div>
        <div class="item">
          <div class="">
            <img src="img/icons/highline.svg" alt="The Last of us">
          </div>
          <div class="tableau">
            <h1>HIGHLINE</h1>
            <p>La highline (haute corde) nécessite une sangle tendue au-dessus de 5 mètres de hauteur. À une telle hauteur et a fortiori au delà, un équipement de sécurité doit être mis en place afin de ne pas risquer sa vie.</p>
          </div>
        </div>
        <div class="item">
          <div class="">
            <img src="img/icons/waterline.svg" alt="The Last of us">
          </div>
          <div class="tableau">
            <h1>WATERLINE</h1>
            <p>La highline (haute corde) nécessite une sangle tendue au-dessus de 5 mètres de hauteur. À une telle hauteur et a fortiori au delà, un équipement de sécurité doit être mis en place afin de ne pas risquer sa vie.</p>
          </div>
        </div>
        <div class="item">
          <div class="">
            <img src="img/icons/blindline.svg" alt="The Last of us">
          </div>
          <div class="tableau">
            <h1>BLINDLINE</h1>
            <p>La highline (haute corde) nécessite une sangle tendue au-dessus de 5 mètres de hauteur. À une telle hauteur et a fortiori au delà, un équipement de sécurité doit être mis en place afin de ne pas risquer sa vie.</p>
          </div>
        </div>
      </div>                
    </div>
  </div>
</div>
<!-- FIN Section2-->

<!-- Section3: Video de présentation de la Slackline-->
<div class="section" id="section4">
  <div class="container">
    <div class="row">
       <h1><strong>DECOUVREZ </strong>LA SLACKLINE</h1>
    </div>
  </div>
  <div id="button" class="loading">
    <span></span>
    <span></span>
  </div>

  <video id="video" autoplay="false">
    <source src="assets/pariSlack.mp4" type='video/mp4' >
    <p>Your user agent does not support the HTML5 Video element.</p>
  </video>

  <div id="progressBar">
    <span class="progress"></span>
    <span class="buffer"></span>
  </div>

  <footer class="hidden-desktop">
    <div class="container">
      <div class="row">
        <ul>
          <li><a href="#">Mentions légales</a></li>
          <li><a href="#">Credits</a></li>
          <li><a href="#">Copyright 2013 - PariSlack</a></li>
        </ul>
      </div>
    </div>
  </footer>
</div>
<!-- FIN Section3-->

<!-- Section4: Témoignages-->
<div class="section hidden-phone" id="section3">
  <div class="container">
    <div class="row">
      <h1><strong>CE QU'ILS </strong>EN PENSENT</h1></br></br></br>
     <!--  blockquote -->
      <div class="span4">
        <img class="img-circle" src="img/perso1.png">
        <h2><i class="perso">David Chapin</i></h2>
        <blockquote>
        Je ne connaissais personne qui pratiquait. Ce site m’a donc permis de trouver des experts, qui sont devenus des amis.
      </blockquote>
      </div><!-- /.span4 -->
      <div class="span4">
          <img class="img-circle" src="img/perso2.png">
          <h2><i class="perso">Emilie Jane</i></h2>
          <blockquote>
          Grâce à Parislack, je peux trouver les personnes présentes sur les spots près de chez moi. C’est rapide et pratique.
          </blockquote>
      </div><!-- /.span4 -->
      <div class="span4">
          <img class="img-circle" src="img/perso3.png">
          <h2><i class="perso">Margot Marchand</i></h2>
          <blockquote>
          J’apprécie le fait de rester facilement en contact avec les slackers et de pouvoir se retrouver et s’aider.
        </blockquote>
      </div>
      <!-- Fin Blockquote -->
    </div>
  </div>

  <footer>
    <div class="container">
      <div class="row">
        <ul>
          <li><a href="#">Mention légales</a></li>
          <li><a href="#">Credits</a></li>
         
        </ul>
      </div>
    </div>
    <p>Copyright 2013 - PariSlack</p>
  </footer>

</div>
<!-- FIN Section4-->

<?php include('footer.php'); ?>