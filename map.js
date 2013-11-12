var map;
var pos;
$("#dialog-form").hide();

// Icone perso
    var iconePerso=new google.maps.MarkerImage("icons/locationNonOccupe.svg",
        // Dimensions
        new google.maps.Size(74,102),
        // Origin
        new google.maps.Point(0,0),
        // Encre
        new google.maps.Point(49.5,75 )
    );

function initialize() {
    // On défini le niveau de zoom, ainsi que la position ou la map sera centrée puis son type
    var mapOptions = {
        zoom: 13,
        center: new google.maps.LatLng(48.856614, 2.352221),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    // Initialisation de la map
    map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

    // Preparation du geocoding
    geocoder = new google.maps.Geocoder();

    // Listener pour l'ajout d'un marker au clic droit
    google.maps.event.addListener(map, 'rightclick',function(event){
        placeMarker(event.latLng,map);
        $( "#dialog-form" ).dialog( "open" );
    });

    // On charge les markers de la BDD sur la carte
    var list_markers=[];
    var i=0;
    li=list_markers.length;
    while(i<li){
        new google.maps.Marker({
        position:new google.maps.LatLng(list_markers[i][0],list_markers[i][1]),
            icon:iconePerso,
            map:map,
            infoWindowIndex:i, 
            title:'Marker '+i
        });
        i++;
    }

    // Ecouteur pour afficher les informations d'un marker
    // google.maps.event.addListener(marker,'click',function(data){
    //     infowindow.setContent('position :'+data.latLng.toUrlValue(5));
    //     infowindow.open(this.getMap(),this);
    // });

    // var infowindow=new google.maps.InfoWindow({
    //     content:content
    // });
}

// function pour placer un marker
function placeMarker(location,map){
    // Récupération des coordonnées
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
            var titre=$('#name').val();
            var description=$("input[name='description']").val();
            // Appel Ajax pour insertion dans la BDD
            var sendAjax=$.ajax({
                url: 'insert.php',
                type: 'POST',
                data: 'latitude='+lat+'&longitude='+lng+'&titre='+titre+'&description='+description,
                success:handleResponse
            })
            function handleResponse(){
                $('#answer').get(0).innerHTML=sendAjax.responseText;
            }
            var marker=new google.maps.Marker({
                icon:iconePerso,
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