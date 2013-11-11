map.init({
	map:'#map',
	pos:new google.maps.LatLng(48.856614,2.352221),
	// rendered:function(){
	// 	map.render();
	// },

	localized:function(pos){
		map.render(pos);
	}

	// found:function(pos){
	// 	if (pos) {localize.markPos(pos);}
	// }
});

// Affichage de la carte
// map.render();
$(window).load(map.render());

// Geoloc
$('#maPosition').on('click',function(e){
	e.preventDefault();
	map.getUserLocation();
});