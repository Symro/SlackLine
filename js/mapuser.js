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

                var contentMarker='<div class="markerInfo"><p>Nom : '+val.titre+'<br/>Description : '+val.description+'<br/>Adresse : '+val.adresse+'<p><a href="" class="itineraryButton" data-address="'+val.adresse+'" data-lng="'+val.longitude+'" data-lat="'+val.latitude+'">itinéraire</a></br><a href="#spotDisplay" role="button" data-toggle="modal" data-id="'+val.id+'" class="spotDisplay" >M\'inscrire à ce spot</a></p></div>';

                var marker=new google.maps.Marker({
                    position:posMarker,
                    map:mapObject.map,
                    icon:iconePerso
                });

                var infowindow=new google.maps.InfoWindow({
                    content:contentMarker
                });
                // Ecouteur affichage infowindow
                google.maps.event.addListener(marker,'click',function(){
                    infowindow.open(mapObject.map,marker);
                });
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

	markerAdded:function(pos){
        console.log('markerAdded');
		console.log(pos);

        $("input[name='validAddress']").prop('disabled',false);
        $("input[name='spotName']").val('');
        $("textarea[name='description']").val('');
        $("input[name='spotAddress']").val('');

        mapObject.map.panTo(pos);
        mapObject.map.setZoom(18);
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
