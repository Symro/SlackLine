<?php 

session_start();
header('Content-type: text/html; charset=utf-8');
include('includes/config.php'); 
include('includes/fonctions.php');


$titre = "Paris Slackline - Accueil";
$custom_class = "inscription";

include('header.php');

include('form_traitement.php');


/*
    Opérateur ternaire :

   echo ( ) ?    :   ;
         ^     ^    ^
        Si   alors sinon

*/

?>


    <div id="fb-root"></div>
        
    

    <aside class="wrap-form-inscription">
        <h2>Inscris-toi</h2>

        <a href="#" id="fb-connect">Compléter avec Facebook</a>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="form-inscription" <?php if( isset($email_error) && $email_error === true ): ?>class="email-error"<?php endif; ?>>

            <input type="text" name="lastname" id="lastname" placeholder="Nom" <?php if(isset($lastname)): ?>value="<?php echo $lastname;?>"<?php elseif(isset($form_error['lastname'])): ?>class="erreur"<?php endif; ?> required>

            <input type="text" name="firstname" id="firstname" placeholder="Prénom" <?php if(isset($firstname)): ?>value="<?php echo $firstname;?>"<?php elseif(isset($form_error['firstname'])): ?>class="erreur"<?php endif; ?> required>

            <input type="email" name="email" id="email" placeholder="Email" <?php if(isset($email)): ?>value="<?php echo $email;?>" <?php elseif(isset($form_error['email'])): ?>class="erreur"<?php endif; ?> required>

            <?php if( isset($email_error) && $email_error === true ): ?>

                <p class="email-error">Cette adresse e-mail est déjà utilisée</p>

            <?php endif; ?>

            <input type="password" name="password" placeholder="Mot de passe" <?php if(isset($form_error['password'])): ?>class="erreur"<?php endif; ?> required>

            <!-- <input type="tel" name="phone" pattern='^[0-9]{10}$' placeholder="Téléphone" id="phone"  <?php if(isset($phone)): ?>value="<?php echo $phone;?>" <?php endif; ?>> -->

            <textarea name="description" placeholder="Description" <?php if(isset($form_error['description'])): echo "class=\"erreur\""; endif; ?> required><?php if(isset($description)): echo $description; endif; ?></textarea>

            

            <input type="text" name="birthday" id="birthday" placeholder="Date de Naissance" <?php if(isset($birthday)): ?>value="<?php echo $birthday;?>" <?php elseif(isset($form_error['birthday'])): ?>class="erreur"<?php endif; ?> required>

            <select name="skill" <?php if(isset($form_error['skill'])): echo "class=\"erreur\""; endif; ?>>
              <option value="niveau" disabled="disabled" <?php if(!isset($skill)): echo "selected"; endif; ?>>NIVEAU :</option>
              <option value="debutant" <?php if(isset($skill) && $skill == "debutant"):             echo "selected"; endif; ?>>Débutant</option>
              <option value="intermediaire" <?php if(isset($skill) && $skill == "intermediaire"):   echo "selected"; endif; ?>>Intermédiaire</option>
              <option value="confirme" <?php if(isset($skill) && $skill == "confirme"):             echo "selected"; endif; ?>>Confirmé</option>
              <option value="expert" <?php if(isset($skill) && $skill == "expert"):                 echo "selected"; endif; ?>>Expert</option>
            </select> 

            <label class="switch-button small" for="material">
                <input type="checkbox" id="material" name="material" value="yes" <?php if(isset($_POST['material'])) echo "checked='checked'"; ?> >
                <span>
                    Matériel
                    <span>Non</span>
                    <span>Oui</span>
                </span>

                <a class="btn btn-primary"></a>
            </label>


            <br>

            <!-- Squared ONE -->
            <div class="chkbox">
                <input type="checkbox" value="shortline" id="form-shortline" name="practice[]" <?php if(isset($practice) && isChecked('practice','shortline')): echo "checked";  endif; ?> />
                <label for="form-shortline">Shortline</label>
            </div>
            <div class="chkbox">
                <input type="checkbox" value="trickline" id="form-trickline" name="practice[]" <?php if(isset($practice) && isChecked('practice','trickline')): echo "checked";  endif; ?> />
                <label for="form-trickline">Trickline</label>
            </div>
            <div class="chkbox">
                <input type="checkbox" value="jumpline" id="form-jumpline" name="practice[]" <?php if(isset($practice) && isChecked('practice','jumpline')): echo "checked";  endif; ?> />
                <label for="form-jumpline">Jumpline</label>
            </div>
            <div class="chkbox">
                <input type="checkbox" value="longline" id="form-longline" name="practice[]" <?php if(isset($practice) && isChecked('practice','longline')): echo "checked";  endif; ?> />
                <label for="form-longline">Longline</label>
            </div>
            <div class="chkbox">
                <input type="checkbox" value="highline" id="form-highline" name="practice[]" <?php if(isset($practice) && isChecked('practice','highline')): echo "checked";  endif; ?> />
                <label for="form-highline">Highline</label>
            </div>
            <div class="chkbox">
                <input type="checkbox" value="waterline" id="form-waterline" name="practice[]" <?php if(isset($practice) && isChecked('practice','waterline')): echo "checked";  endif; ?> />
                <label for="form-waterline">Waterline</label>
            </div>
            <div class="chkbox">
                <input type="checkbox" value="blindline" id="form-blindline" name="practice[]" <?php if(isset($practice) && isChecked('practice','blindline')): echo "checked";  endif; ?> />
                <label for="form-blindline">Blindline</label>
            </div>
            

            <br />
            <input type="submit" name="submit" class="btn-primary btn-submit" value="OK">
        </form>
        <br />

    </aside>
        
    <br />

        

<?php include('footer.php'); ?>        
