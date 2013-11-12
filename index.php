<!DOCTYPE html>
<html>
    <head>
        <title>PariSlack</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <style type="text/css" src="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"></style>
        <link rel="stylesheet" href="mapstyle.css">
        <?php 
            // Connexion avec la BDD
            $bdd=new PDO('mysql:host=localhost;dbname=parislack','root','');
            // Obtenir la liste des points
            $result=$bdd->query('SELECT latitude,longitude,titre,description,adresse,materiel,note,categorie FROM spots');
            // On récupère la liste des markers dans un tableau
            $markers=json_encode($result->fetchAll(PDO::FETCH_ASSOC));
            // Fermeture de la connexion
            $result->closeCursor();
            // On crée un fichier JSON
            $createJson=fopen("markers.json", 'w+');
            // On écrit dans le fichier JSON les markers enregistrés dans la BDD
            fputs($createJson,$markers);
        ?>
    </head>

    <body>
        <button id="maPosition">Me localiser</button>
        <div id="answer">
        </div>
        <div id="map">
        </div>

        <div id="dialog-form" title="Ajouter un spot">
            <p class="validateTips">All form fields are required.</p>

            <form>
                <fieldset>
                    <label for="name">Nom du spot : </label>
                    <input type="text" name="name" class="text ui-widget-content ui-corner-all" id="name" />
                    <label for="description">Description du spot : </label>
                    <input type="text" name="description" class="text ui-widget-content ui-corner-all" />
                    <!-- <input type="checkbox" name="categorie" value="shortline"><label>shortline</label>
                    <input type="checkbox" name="categorie" value="longline"><label>longline</label> -->
                </fieldset>
            </form>
        </div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript"src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBoOm_lPvUSlokpQ8XHfSrGUJOm6vNxLjg&sensor=true"></script>
        <script type="text/javascript" src="mapoo.js"></script>      
        <script type="text/javascript" src="mapuser.js"></script>      
    </body>
</html>