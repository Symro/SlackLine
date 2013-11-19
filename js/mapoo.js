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

    getInstantLoc:function(userLoc){
        navigator.geolocation.getCurrentPosition(
            function(position){
                var userLoc=position.coords;
                return userLoc;
            },
            function(){
                console.log('recup de la geoloc impossible');
            },
            {enableHighAccuracy:true}
        );
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

        // callback
        mapObject.params.rendered.call(this);
    },

    // Ajout d'un marker
    addMarker:function(pos,map){
        var lat=pos.lat();
        var lng=pos.lng();
        // console.log('latitude du marker : '+lat);
        // console.log('longitude du marker : '+lng);
        // var address=pos;
        mapObject.params.geocoder.geocode({'latLng':pos},function(results,status){
            if (status==google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    // var address=results[1].formatted_address;
                    $("input[name='adresse']").val(results[1].formatted_address);
                }else{
                    alert('Adresse non trouvée');
                }
            }else{
                alert('Erreur : '+GeocoderStatuss);
            }
        });

        $("#dialog-form").dialog({
        autoOpen:true,
        height:300,
        width:350,
        modal:true,
        buttons:{
            "Ajouter le spot":function(){
                var titre=$("input[name='titre']").val();
                var description=$("input[name='description']").val();
                var adresse=$("input[name='adresse']").val();   
                // Appel Ajax pour insertion dans la BDD
                var sendAjax=$.ajax({
                    url: 'insert.php',
                    dataType:'json',
                    type: 'POST',
                    data: 'latitude='+lat+'&longitude='+lng+'&titre='+titre+'&description='+description+'&adresse='+adresse,
                    success:handleResponse
                });
                function handleResponse(data){
                    $('#answer').get(0).innerHTML=data.msg;
                    if (data.error==false) {
                        var marker=new google.maps.Marker({
                            position:pos,
                            map:mapObject.map,
                            icon:iconePerso
                        });
                        // Callback
                        mapObject.params.markerAdded.call(this,pos);
                    }
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

    addMarkerByAddress:function(address){
        console.log('Ajout d\'un marker par une adresse : '+address);
        mapObject.params.geocoder.geocode({'address':address},function(results,status){
            if (status==google.maps.GeocoderStatus.OK) {
                console.log(results[0]);
                var lat=results[0].geometry.location.lat();
                var lng=results[0].geometry.location.lng();
                $("input[name='adresse']").val(address);

                $("#dialog-form").dialog({
                    autoOpen:true,
                    height:300,
                    width:350,
                    modal:true,
                    buttons:{
                        "Ajouter le spot":function(){
                            var titre=$("input[name='titre']").val();
                            var description=$("input[name='description']").val();
                            var adresse=$("input[name='adresse']").val();   
                            // Appel Ajax pour insertion dans la BDD
                            var sendAjax=$.ajax({
                                url: 'insert.php',
                                dataType:'json',
                                type: 'POST',
                                data: 'latitude='+lat+'&longitude='+lng+'&titre='+titre+'&description='+description+'&adresse='+adresse,
                                success:handleResponse
                            });
                            function handleResponse(data){
                                $('#answer').get(0).innerHTML=data.msg;
                                if (data.error==false) {
                                    var marker=new google.maps.Marker({
                                        position:results[0].geometry.location,
                                        map:mapObject.map,
                                        icon:iconePerso
                                    });
                                    // Callback
                                    mapObject.params.markerAdded.call(this,results[0].geometry.location);
                                }
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

                var marker=new google.maps.Marker({
                    map:mapObject.map,
                    position:results[0].geometry.location,
                    icon:iconePerso
                }); 
            }else{
                alert('Erreur : '+GeocoderStatuss);
            }
        });
    }
}