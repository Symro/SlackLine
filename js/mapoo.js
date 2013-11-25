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
        if(typeof pos==='object'){
                // si on a la position de l'utilisateur on reécupère ses coords
                var latLng=new google.maps.LatLng(pos.latitude,pos.longitude);
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

        console.log(directionsDisplay);

        // callback
        mapObject.params.rendered.call(this);
    },

    // Recupréation de la position de l'user
    getUserLocation:function(){
        navigator.geolocation.getCurrentPosition(
            function(position){
                console.log('userlocation');
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
        console.log('itinerary');

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
                    console.log(selectMode);
                });
                $('#walk').on('click',function(e){
                    selectMode=google.maps.TravelMode.WALKING;
                    console.log(selectMode);
                });
                $('#transit').on('click',function(e){
                    selectMode=google.maps.TravelMode.TRANSIT;
                    console.log(selectMode);
                });
                $('#bike').on('click',function(e){
                    selectMode=google.maps.TravelMode.BICYCLING;
                    console.log(selectMode);
                });

                $("#itineraryForm").dialog({
                    autoOpen:true,
                    height:300,
                    width:350,
                    modal:true,
                    buttons:{
                        "Calculer un itinéraire":function(){
                            // On récupère l'adresse de départ si elle est saisie
                            if ($("input[name='depart']").val()!="Ma position") {
                                console.log('différent');
                                var itineraryRequest={
                                    origin:$("input[name='depart']").val(),
                                    destination:end,
                                    travelMode:selectMode
                                };
                            }else{
                                console.log('ma loc');
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
                console.log('recup de la geoloc impossible');
            },
            {enableHighAccuracy:true}
        );
    },

    // Ajout d'un marker
    addMarker:function(pos,map){
        google.maps.event.clearInstanceListeners(mapObject.map);
        var lat=pos.lat();
        var lng=pos.lng();
        // console.log('latitude du marker : '+lat);
        // console.log('longitude du marker : '+lng);
        // var address=pos;
        mapObject.params.geocoder.geocode({'latLng':pos},function(results,status){
            if (status==google.maps.GeocoderStatus.OK) {
                if (results[1]) {
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
                    mapObject.map.setZoom(15);

                    //Ecouteur pour récupérer les coords après un dragend 
                    google.maps.event.addListener(prevMarker, 'dragend', function(e){
                        console.log('dragend');
                        lat=prevMarker.position.lat();
                        lng=prevMarker.position.lng();
                        console.dir(prevMarker);
                    });

                    // Insertion en bdd après validation
                    $('#saveSpot').on('click',function(e){
                        event.preventDefault();
                        var titre=$("input[name='spotName']").val();
                        var description=$("textarea[name='description']").val();
                        var adresse=$("input[name='spotAddress']").val();

                        var skills = new Array();
                        // on récupère toutes les catégories de slackline actives
                        $("#spot .skills .skill.active").each(function(i) {
                            skills[i] = $(this).data('type');
                        });
                        console.dir(skills);
                        
                        // Appel Ajax pour insertion dans la BDD
                        $.ajax({
                            url: 'insert.php',
                            dataType:'json',
                            type: 'POST',
                            data: 'latitude='+lat+'&longitude='+lng+'&titre='+titre+'&description='+description+'&adresse='+adresse,
                            success:handleResponse
                        });
                    });

                    // Création du marker suite à l'insertion en bdd
                    function handleResponse(data){
                        $('#answer').get(0).innerHTML=data.msg;
                        if (data.error==false) {
                            var marker=new google.maps.Marker({
                                position:prevMarker.position,
                                map:mapObject.map,
                                icon:iconePerso
                            });

                            // On masque le marker de prévisualisation
                            prevMarker.visible=false;

                            // Callback
                            mapObject.params.markerAdded.call(this,marker.position);
                        }
                    }
                }else{
                    alert('Adresse non trouvée');
                }
            }else{
                alert('Erreur : '+GeocoderStatus);
            }
        });

    },

    addMarkerByAddress:function(address){
        console.log('Ajout d\'un marker par une adresse : '+address);

        google.maps.event.clearInstanceListeners(mapObject.map);
        mapObject.params.geocoder.geocode({'address':address},function(results,status){
            if (status==google.maps.GeocoderStatus.OK) {
                console.log(results[0]);
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
                mapObject.map.setZoom(15);

                google.maps.event.addListener(prevMarker, 'dragend', function(e){
                    console.log('dragend');
                    lat=prevMarker.position.lat();
                    lng=prevMarker.position.lng();
                    console.dir(prevMarker);
                });

                $('#saveSpot').on('click',function(e){
                    event.preventDefault();

                    var titre=$("input[name='spotName']").val();
                    var description=$("textarea[name='description']").val();
                    var adresse=$("input[name='spotAddress']").val();

                    console.log(titre);

                    // var skills = new Array();
                    // // on récupère toutes les catégories de slackline actives
                    // $("#spot .skills .skill.active").each(function(i) {
                    //     skills[i] = $(this).data('type');
                    // });
                    // console.dir(skills);

                    // Appel Ajax pour insertion dans la BDD
                    $.ajax({
                        url: 'insert.php',  
                        dataType:'json',
                        type: 'POST',
                        data: 'latitude='+lat+'&longitude='+lng+'&titre='+titre+'&description='+description+'&adresse='+adresse,
                        success:handleResponse
                    });
                });

                function handleResponse(data){
                    $('#answer').get(0).innerHTML=data.msg;
                    console.log('callback');

                    if (data.error==false) {
                        var marker=new google.maps.Marker({
                            position:prevMarker.position,
                            map:mapObject.map,
                            icon:iconePerso
                        });
                        prevMarker.visible=false;
                        // Callback
                        mapObject.params.markerAdded.call(this,results[0].geometry.location);

                        mapObject.map.panTo(marker.position);
                        mapObject.map.setZoom(15);
                    }
                }

            }else{
                alert('Erreur : '+GeocoderStatus);
            }
        });
    }
}