<?php
    include "includes/config.php";

    //$result = $PDO->query('SELECT * FROM rubrique');
    //$allRubriques = $result->fetchall(PDO::FETCH_OBJ);
	
	/* FICHIER TEMPORAIRE */
	
?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<style type="text/css">
    input, select, textarea{
        display:block;
        margin-bottom:10px;
    }


</style>


<form autocomplete="off" method="post" action="edit_profile.php" name="form_profile">
   <fieldset>
    <label for="lastname">Votre nom :</label>
    <input type="text" id="lastname" name="lastname" required />

    <label for="firstname">Votre prénom :</label>
    <input type="text" id="firstname" name="firstname" required />

    <label for="nickname">Votre pseudo :</label>
    <input type="text" id="nickname" name="nickname" />

    <label for="email">Votre email :</label>
    <input type="email" id="email" name="email" required />

    <label for="birthday">Date de naissance :</label>
    <input type="email" id="birthday" name="birthday" required />

    <label for="gender">Sexe :</label>
    <select name="gender" required>
    <option value="gender_male" selected>Homme</option>
    <option value="gender_female">Femme</option>
    </select>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" />

    <label for="skill">Technique :</label>
    <input type="checkbox" name="skill" value="Shortline">Shortline
    <input type="checkbox" name="skill" value="Trickline">Trickline
    <input type="checkbox" name="skill" value="Jumpline">Jumpline
    <input type="checkbox" name="skill" value="Longline">Longline
    <input type="checkbox" name="skill" value="Highline">Highline
    <input type="checkbox" name="skill" value="Waterline">Waterline
    <input type="checkbox" name="skill" value="Blindline">Blindline

    <label for="level">Niveau :</label>
    <select name="level">
    <option value="low">Débutant</option>
    <option value="medium">Intermédiaire/Confirmé</option>
    <option value="high">Expert</option>
    </select>

    <label for="equipment">Matériel :</label>
    <textarea name="equipment" rows="10" cols="30"></textarea>


    <input type="tel" id="tel" name="tel" pattern="[0-9]{10}" title="un numéro à 10 chiffres" placeholder="Téléphone à 10 chiffres" />
    <input type="submit" value="complete" />
    </fieldset>
</form>