mapObject.init({
	map:'#map',
	pos:new google.maps.LatLng(48.856614,2.352221),
	// Une fois localisé
	localized:function(pos){
		mapObject.render(pos);
		var latLng=new google.maps.LatLng(pos.latitude,pos.longitude);
		var posMarker=new google.maps.Marker({
            position:latLng,
            map:mapObject.map,
            animation:google.maps.Animation.BOUNCE,
            icon:iconePerso
        });
	},

	markerAdded:function(pos){
		console.log('markerAdded');
		mapObject.map.panTo(pos);
		// mapObject.map.render(pos);
	}
});

// On change le style des markers
var iconePerso=new google.maps.MarkerImage("icons/locationNonOccupe.svg",
    // Dimensions
    new google.maps.Size(50,50),
    // Origine
	new google.maps.Point(0,0),
    // Encre
    new google.maps.Point(25,40),
    new google.maps.Size(50,50)
);

// On appelle l'affichage de la map
$(window).load(mapObject.render());

// Ecouteur pour le boutton de geolocalisation
$('#maPosition').on('click',function(e){
	e.preventDefault();
	mapObject.getUserLocation();
});

// Ecouteur pour l'ajout de marker
google.maps.event.addListener(mapObject.map, 'rightclick',function(event){
    mapObject.addMarker(event.latLng,mapObject.map);
});