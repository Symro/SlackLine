mapObject.init({
	map:'#map',
    zoom:13,
	pos:new google.maps.LatLng(48.856614,2.352221),
	// Une fois la carte affichée
	rendered:function(){
        console.log('rendered')

		mapMarkers = $.getJSON(siteUrl+"markers.json", function(data){
            $.each(data,function(key,val){
                var posMarker=new google.maps.LatLng(parseFloat(val.latitude),parseFloat(val.longitude));

                open=false;
                mapObject.getInfoWindow(val,posMarker,open);

            });
        });
        // Ecouteur pour l'ajout de marker
        google.maps.event.addListener(mapObject.map, 'rightclick',function(event){
            mapObject.addMarker(event.latLng,mapObject.map);
        });
	},
	// Une fois localisé
	localized:function(userLoc){
        console.log('localized');
		mapObject.render(userLoc);
		var latLng=new google.maps.LatLng(userLoc.latitude,userLoc.longitude);
		var posMarker=new google.maps.Marker({
            position:latLng,
            map:mapObject.map,
            animation:google.maps.Animation.BOUNCE,
            icon:iconePerso
        });
	},

	markerAdded:function(){
        console.log('markerAdded');

        $("input[name='validAddress']").prop('disabled',false);
        $("input[name='spotName']").val('');
        $("textarea[name='description']").val('');
        $("input[name='spotAddress']").val('');
        $("input[name='addressAdded']").val('');
	},

    itineraryCalculated:function(request){
        directionsService.route(request,function(response,status){
            console.log(request);
            if (status==google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                directionsDisplay.setMap(mapObject.map);
            }
        });
    }
});
// On change le style des markers
var iconePerso=new google.maps.MarkerImage(siteUrl+"/img/locationNonOccupe.svg",
    // Dimensions
    new google.maps.Size(24.5,50),
    // Origine
	new google.maps.Point(0,0),
    // Encre
    new google.maps.Point(25,40)	
);
var iconeTemp=new google.maps.MarkerImage(siteUrl+"/img/locationTemporaire.svg",
    // Dimensions
    new google.maps.Size(24.5,50),
    // Origine
    new google.maps.Point(0,0),
    // Encre
    new google.maps.Point(25,40)    
);

// On appelle l'affichage de la map
$(window).load(mapObject.render());

// Ecouteur pour le boutton de geolocalisation
$('#maPosition').on('click',function(e){
	e.preventDefault();
	mapObject.getUserLocation();
});

// Ecouteurs itinéraire
$('#map').on('click','.itineraryButton',function(e){
    e.preventDefault();
    var pos=new google.maps.LatLng(parseFloat($(this).data('lat')),parseFloat($(this).data('lng')));
    var address=String($(this).data('address'));
    console.log(address);
    mapObject.itinerary(pos,address);
});

// Ecouteur placer un marker à partir de l'adresse
$('#addMarker').submit(function(e){
    e.preventDefault();
    address=$('input[name=addressAdded]').val();
    mapObject.addMarkerByAddress(address);
});

// Ecouteur pour cibler un marquer lors d'un clic sur les recherches
$('body').on('click','.rechercheSpot .show',function(){
    var id=$(this).data('id');
    mapObject.displaySpot(id);
});