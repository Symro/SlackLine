<!DOCTYPE html>
<html>
    <head>
        <title>PariSlack</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <style type="text/css" src="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"></style>
        <style type="text/css">
            html { height: 100% }
            body { height: 100%; margin: 0; padding: 0 }
            #map-canvas { height: 100% }
            label, input { display:block; }
            input.text { margin-bottom:12px; width:95%; padding: .4em; }
            fieldset { padding:0; border:0; margin-top:25px;}
            form{background: #fff;}
            h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 350px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
        </style>

        <?php 
            // Connexion avec la BDD
            $bdd=new PDO('mysql:host=localhost;dbname=parislack','root','');
            // Obtenir la liste des points
            $result=$bdd->query('SELECT latitude,longitude FROM spots ORDER BY id');
            // On récupère la liste des markers dans un tableau
            $listMarkers='';
            while ($row=$result->fetch()) {
                if ($listMarkers!='')$listMarkers.=','; //separation de la longitude et latitude par une virgule
                $listMarkers.='['.$row['latitude'].','.$row['longitude'].']';
            }
            // Fermeture de la connexion
            $result->closeCursor();
        ?>

    </head>

    <body onload="initialize()">
        <button onclick="trouve()">Me localiser</button>
        <div id="answer">Reponse AJAXs :</div>
        <div id="map-canvas">
        </div>

        <div id="dialog-form" title="Ajouter un spot">
            <p class="validateTips">All form fields are required.</p>

            <form>
                <fieldset>
                    <label for="name">Nom du spot : </label>
                    <input type="text" name="name" class="text ui-widget-content ui-corner-all" />
                    <label for="description">Description du spot : </label>
                    <input type="text" name="description" class="text ui-widget-content ui-corner-all" />
                </fieldset>
            </form>
        </div>

        <script language="JavaScript" type="text/javascript">
            var map;
            var pos;

            function initialize() {
                // On défini le niveau de zoom, ainsi que la position ou la map sera centrée puis son type
                var mapOptions = {
                    zoom: 13,
                    center: new google.maps.LatLng(48.856614, 2.352221),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                // Initialisation de la map
                map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

                // Listener pour l'ajout d'un marker au clic droit
                google.maps.event.addListener(map, 'rightclick',function(event){
                    placeMarker(event.latLng,map);
                    $( "#dialog-form" ).dialog( "open" );
                });

                var list_markers=[ <?php echo $listMarkers; ?> ];
                var i=0;
                li=list_markers.length;
                while(i<li){
                    new google.maps.Marker({
                    position:new google.maps.LatLng(list_markers[i][0],list_markers[i][1]),
                        map:map,
                        title:'Marker '+i
                    });
                    i++;
                }
            }

            // function pour placer un marker
            function placeMarker(location,map){
                var lat=location.lat();
                var lng=location.lng();
                console.log('latitude du marker : '+lat);
                console.log('longitude du marker : '+lng);
                
                $("#dialog-form").dialog({
                autoOpen:false,
                height:300,
                width:350,
                modal:true,
                buttons:{
                    "Ajouter le spot":function(){
                        // Appel Ajax pour insertion dans la BDD
                        var sendAjax=$.ajax({
                            url: 'insert.php',
                            type: 'POST',
                            data: 'latitude='+lat+'&longitude='+lng,
                            success:handleResponse
                        })
                        function handleResponse(){
                            $('#answer').get(0).innerHTML=sendAjax.responseText;
                        }
                        var marker=new google.maps.Marker({
                            position:location,
                            map:map
                        });
                        $(this).dialog("close");
                        map.panTo(location);            
                        },
                        Cancel:function(){
                            $(this).dialog("close");
                        }
                },
                close:function(){
                    // allFields.val("").removeClass('ui-state-error');
                    $(this).dialog("close");
                }
            });
            }

            

            // Function de geolocalisation
            function trouve(){
              // Si le navigateur autorise la geoloc
              if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position){
                    // On récupère la position
                    pos=new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                    console.log(pos);
                    map.setCenter(pos);
                    map.setZoom(15);
                    // On place un marker sur l'endroit géolocalisé
                    pos=new google.maps.Marker({
                        position:pos,
                        id:position,
                        map:map,
                        animation:google.maps.Animation.BOUNCE,
                        title:"Vous êtes ici"
                    });
                });
              }
            }

        </script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript"src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBoOm_lPvUSlokpQ8XHfSrGUJOm6vNxLjg&sensor=true"></script>
    </body>
</html>