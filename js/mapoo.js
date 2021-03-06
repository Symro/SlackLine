var directionsDisplay=new google.maps.DirectionsRenderer();
var directionsService=new google.maps.DirectionsService();

var mapObject={
    defaults:{
        map:'',
        zoom:13,
        center:{latitude:48.856614,longitude:2.352221},
        mapTypeId:google.maps.MapTypeId.ROADMAP,
        geocoder:new google.maps.Geocoder()
    },

    init:function(options){
        this.params=$.extend(this.defaults,options);
    },  

    // Affichage de la carte
    render:function(pos){
        if(pos){
            // si on a la position  on reécupère ses coords
            var latLng=new google.maps.LatLng(pos.lat(),pos.lng());
            this.params.zoom=16;
        }
        else{
            // Sinon on récupère celle par défaut
            var latLng=new google.maps.LatLng(this.params.center.latitude,this.params.center.longitude);
        }
        var settings={
            zoom:this.params.zoom,
            mapTypeId:google.maps.MapTypeId.ROADMAP,
            center:latLng,
        };

        // On crée la carte
        this.map=new google.maps.Map(document.querySelector(this.params.map),settings);

        // callback
        mapObject.params.rendered.call(this);
    },

    // Recupréation de la position de l'user
    getUserLocation:function(){
        navigator.geolocation.getCurrentPosition(
            function(position){
                // Callback
                console.dir(position.coords);
                var userLoc=position.coords;
                mapObject.params.localized.call(this,userLoc);
            },
            function(){
                // Callback
                mapObject.params.localized.call(this,null);
            },
            {enableHighAccuracy:true}
        );
    },

    itinerary:function(pos,address){

        navigator.geolocation.getCurrentPosition(
            function(position){
                var start=new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                $("input[name='depart']").val("Ma position");
                var end=pos;
                $("input[name='arrivee']").val(address);
                console.dir(end);
                console.dir(start);

                // On récupère le type de transport
                var selectMode="TRANSIT";

                $('#car').on('click',function(e){
                    selectMode=google.maps.TravelMode.DRIVING;
                });
                $('#walk').on('click',function(e){
                    selectMode=google.maps.TravelMode.WALKING;
                });
                $('#transit').on('click',function(e){
                    selectMode=google.maps.TravelMode.TRANSIT;
                });
                $('#bike').on('click',function(e){
                    selectMode=google.maps.TravelMode.BICYCLING;
                });

                $("#itineraryForm").dialog({
                    autoOpen:true,
                    height:400,
                    width:350,
                    modal:true,
                    buttons:{
                        "Calculer un itinéraire":function(){
                            // On récupère l'adresse de départ si elle est saisie
                            if ($("input[name='depart']").val()!="Ma position") {
                                var itineraryRequest={
                                    origin:$("input[name='depart']").val(),
                                    destination:end,
                                    travelMode:selectMode
                                };
                            }else{
                                var itineraryRequest={
                                    origin:start,
                                    destination:end,
                                    travelMode:selectMode
                                };
                            }

                            mapObject.params.itineraryCalculated.call(this,itineraryRequest);

                            function handleResponse(data){
                                $('#answer').get(0).innerHTML=data.msg;

                            }
                            $(this).dialog("close");
                        },
                        Cancel:function(){
                            $(this).dialog("close");
                        }
                    },
                    close:function(){
                        $(this).dialog("close");
                    }
                });
            },

            function(){
                
            },
            {enableHighAccuracy:true}
        );
    },

    // Ajout d'un marker
    addMarker:function(pos,map){
        google.maps.event.clearInstanceListeners(mapObject.map);

        var lat=pos.lat();
        var lng=pos.lng();

        mapObject.params.geocoder.geocode({'latLng':pos},function(results,status){

            if (status==google.maps.GeocoderStatus.OK) {
                if (results[1]) {

                    $("input[name='validAddress']").prop('disabled',true);
                    // var address=results[1].formatted_address;
                    $("input[name='spotAddress']").val(results[1].formatted_address);

                    // Création du marker de prévisualisation
                    var prevMarker=new google.maps.Marker({
                        map:mapObject.map,
                        position:pos,
                        icon:iconeTemp,
                        draggable:true,
                    });

                    // Centrage/zoom sur le marker
                    mapObject.map.panTo(prevMarker.position);
                    mapObject.map.setZoom(8);

                    //Ecouteur pour récupérer les coords après un dragend 
                    google.maps.event.addListener(prevMarker, 'dragend', function(e){

                        lat=prevMarker.position.lat();
                        lng=prevMarker.position.lng();
                        console.dir(prevMarker);
                    });

                    // Insertion en bdd après validation
                    $('#saveSpot').on('click',function(event){
                        event.preventDefault();

                        var titre=$("input[name='spotName']").val();
                        var description=$("textarea[name='description']").val();
                        var adresse=$("input[name='spotAddress']").val();

                        var skillsTab = new Array();
                        // on récupère toutes les catégories de slackline actives
                        $("#spot .skills .skill.active").each(function(i) {
                            skillsTab[i] = $(this).data('type');
                        });
                        
                        // Appel Ajax pour insertion dans la BDD
                        $.ajax({
                            url: 'insert.php',
                            dataType:'json',
                            type: 'POST',
                            data: 'latitude='+lat+'&longitude='+lng+'&titre='+titre+'&description='+description+'&adresse='+adresse+'&skills='+skillsTab,
                            success:handleResponse
                        });
                    });

                    // Création du marker suite à l'insertion en bdd
                    function handleResponse(data){
                        $('#answer').get(0).innerHTML=data.msg;
                        if (data.error==false) {

                            // On masque le marker de prévisualisation
                            prevMarker.visible=false;

                            var marker=new google.maps.Marker({
                                position:prevMarker.position,
                                map:mapObject.map,
                                icon:iconePerso
                            });             

                            // Callback
                            mapObject.refreshMarker();
                            mapObject.render(marker.position);
                            mapObject.params.markerAdded.call();
                        }
                    }
                }else{
                    alert('Adresse non trouvée');
                }
            }else{
                alert('Erreur : '+status);
            }
        });

    },

    addMarkerByAddress:function(address){

        google.maps.event.clearInstanceListeners(mapObject.map);

        mapObject.params.geocoder.geocode({'address':address},function(results,status){

            if (status==google.maps.GeocoderStatus.OK) {

                $("input[name='validAddress']").prop('disabled',true);

                var lat=results[0].geometry.location.lat();
                var lng=results[0].geometry.location.lng();

                $("input[name='spotAddress']").val(address);

                var prevMarker=new google.maps.Marker({
                    map:mapObject.map,
                    position:results[0].geometry.location,
                    icon:iconeTemp,
                    draggable:true,
                });

                mapObject.map.panTo(prevMarker.position);
                mapObject.map.setZoom(9);

                google.maps.event.addListener(prevMarker, 'dragend', function(e){
                    lat=prevMarker.position.lat();
                    lng=prevMarker.position.lng();
                    console.dir(prevMarker);
                });

                $('#saveSpot').on('click',function(e){
                    e.preventDefault();

                    var titre=$("input[name='spotName']").val();
                    var description=$("textarea[name='description']").val();
                    var adresse=$("input[name='spotAddress']").val();

                    var skillsTab = new Array();
                    // // on récupère toutes les catégories de slackline actives
                    $("#spot .skills .skill.active").each(function(i) {
                        skillsTab[i] = $(this).data('type');
                    });

                    // Appel Ajax pour insertion dans la BDD
                    $.ajax({
                        url: 'insert.php',  
                        dataType:'json',
                        type: 'POST',
                        data: 'latitude='+lat+'&longitude='+lng+'&titre='+titre+'&description='+description+'&adresse='+adresse+'&skills='+skillsTab,
                        success:handleResponse
                    });
                });

                function handleResponse(data){
                    $('#answer').get(0).innerHTML=data.msg;

                    if (data.error==false) {

                        prevMarker.visible=false;

                        var marker=new google.maps.Marker({
                            position:prevMarker.position,
                            map:mapObject.map,
                            icon:iconePerso
                        });

                        // Callback
                        mapObject.refreshMarker();
                        mapObject.render(marker.position);
                        mapObject.params.markerAdded.call();
                    }
                }

            }else{
                alert('Erreur : '+status);
            }
        });
    },

    refreshMarker:function(){

        $.ajax({
            url: 'includes/actions.php',
            type:"GET",
            data: {
                    action: 'getSpot'
                }
        });
    },

    getInfoWindow:function(val,posMarker,open){

        var contentMarker='<div class="markerInfo"><p>Nom : '+val.titre+'<br/>Description : '+val.description+'<br/>Adresse : '+val.adresse+'<p><a href="" class="itineraryButton" data-address="'+val.adresse+'" data-lng="'+val.longitude+'" data-lat="'+val.latitude+'">itinéraire</a></br><a href="#spotDisplay" role="button" data-toggle="modal" data-id="'+val.id+'" class="spotDisplay" >M\'inscrire à ce spot</a></p></div>';

        var marker=new google.maps.Marker({
            position:posMarker,
            map:mapObject.map,
            icon:iconePerso
        });

        var infowindow=new google.maps.InfoWindow({
            content:contentMarker
        });
        
        if (open===false) {
            google.maps.event.addListener(marker,'click',function(){
                infowindow.open(mapObject.map,marker);
            });            
        }else{
            infowindow.open(mapObject.map,marker);
        }
        
    },

    displaySpot:function(id){
        $.each(mapMarkers.responseJSON ,function(key,val){
            if(val.id == id){
                var pos=new google.maps.LatLng(val.latitude,val.longitude);
                mapObject.map.panTo(pos);
                mapObject.map.setZoom(16);
                open=true;
                mapObject.getInfoWindow(val,pos,open);
            }
        });
    }
}