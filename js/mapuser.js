mapObject.init({
	map:'#map',
	pos:new google.maps.LatLng(48.856614,2.352221),
	// Une fois la carte affichée
	rendered:function(){
        console.log('rendered')
		$.getJSON(siteUrl+"markers.json", function(data){
            $.each(data,function(key,val){
                var posMarker=new google.maps.LatLng(parseFloat(val.latitude),parseFloat(val.longitude));
                var contentMarker='<div class="markerInfo"><p>Nom : '+val.titre+'<br/>Description : '+val.description+'<br/>Adresse : '+val.adresse+'<p><a href="" class="itineraryButton" data-lng="'+val.longitude+'" data-lat="'+val.latitude+'">itinéraire</a></div>';
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
		mapObject.map.panTo(pos);
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

// On appelle l'affichage de la map
$(window).load(mapObject.render());

// Ecouteur pour le boutton de geolocalisation
$('#maPosition').on('click',function(e){
	event.preventDefault();
	mapObject.getUserLocation();
});
// google.maps.event.addListener(mapObject.map, 'rightclick',function(event){
        //     mapObject.addMarker(event.latLng,mapObject.map);
        // });
// Ecouteur itinéraire
$('#map').on('click','.itineraryButton',function(e){
    event.preventDefault();
    var pos=new google.maps.LatLng(parseFloat($(this).data('lat')),parseFloat($(this).data('lng')));
    mapObject.itinerary(pos);
});
// Ecouteur placer un marker à partir de l'adresse
$('#addMarker').submit(function(e){
    event.preventDefault();
    address=$('input[name=addSpot]').val();
    mapObject.addMarkerByAddress(address);
}); 