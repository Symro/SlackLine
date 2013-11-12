map.init({
	map:'#map',
	pos:new google.maps.LatLng(48.856614,2.352221),
	icon:new google.maps.MarkerImage("icons/locationNonOccupe.svg",
	    // Dimensions
	    new google.maps.Size(74,102),
	    // Origine
	    new google.maps.Point(0,0),
	    // Encre
	    new google.maps.Point(49.5,75 )
	),

	// Une fois localisé
	localized:function(pos){
		map.render(pos);
		var latLng=new google.maps.LatLng(pos.latitude,pos.longitude);
		var posMarker=new google.maps.Marker({
            position:latLng,
            map:map.map,
            animation:google.maps.Animation.BOUNCE
        });
	},

	markerAdded:function(pos){
		map.render(pos);
	}
});

// On change le style des markers
var iconePerso=new google.maps.MarkerImage("icons/locationNonOccupe.svg",
    // Dimensions
    new google.maps.Size(74,102),
    // Origine
    new google.maps.Point(0,0),
    // Encre
    new google.maps.Point(49.5,75 )
);

// On appelle l'affichage de la map
$(window).load(map.render());

// Ecouteur pour le boutton de geolocalisation
$('#maPosition').on('click',function(e){
	e.preventDefault();
	map.getUserLocation();
});

// Ecouteur pour l'ajout de marker
google.maps.event.addListener(map.map, 'rightclick',function(event){
    map.addMarker(event.latLng,map.map);
});