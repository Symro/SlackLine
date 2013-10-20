<!DOCTYPE html>
<html>
  <head>
    <title>Paris Slack</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBoOm_lPvUSlokpQ8XHfSrGUJOm6vNxLjg&sensor=true"></script>
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 100% }
    </style>
    <?php 
      // Connexion avec la BDD
      $bdd=new PDO('mysql:host=localhost;dbname=parislack','root','');
      // Obtenir la liste des points
      $result=$bdd->query('SELECT latitude,longitude FROM listemarkers ORDER BY id');
      // On récupère la liste des markers dans un tableau
      $listMarkers='';
      while ($row=$result->fetch()) {
        if ($listMarkers!='')$listMarkers.=','; //separation de la longitude et latitude par une virgule
        $listMarkers.='['.$row['latitude'].','.$row['longitude'].']';
      }
      // Fermeture de la connexion
      $result->closeCursor();
     ?>
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
        // On demande à l'user si il souhaite bien ajouter un marqueur
        var r=confirm("Êtes vous sur de vouloir ajouter un spot ici ?")
        if (r==true) {
          // Si true alors on ajoute le marker
          var lat=location.lat();
          var lng=location.lng();
          console.log('latitude du marker : '+lat);
          console.log('longitude du marker : '+lng);
          var marker=new google.maps.Marker({
            position:location,
            map:map
          });
          map.panTo(location);
        }
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
  </head>
  <body onload="initialize()">
    <button onclick="trouve()">Me localiser</button>
    <div id="map-canvas">
    </div>
  </body>
</html>