var mapObject={
    defaults:{
        map:'',
        zoom:13,
        center:{latitude:48.856614,longitude:2.352221},
        mapTypeId:google.maps.MapTypeId.ROADMAP,

    },

    init:function(options){
        this.params=$.extend(this.defaults,options);
    },  

    // Recupréation de la position de l'user
    getUserLocation:function(){
        navigator.geolocation.getCurrentPosition(
            function(position){
                console.log('userlocation');
                console.dir(mapObject.params);
                mapObject.params.localized.call(this,position.coords);
            },
            function(){
                mapObject.params.localized.call(this,null);
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
        // On charge les markers de la BDD sur la carte
        $.getJSON("markers.json", function(data){
            $.each(data,function(key,val){
                var posMarker=new google.maps.LatLng(parseFloat(val.latitude),parseFloat(val.longitude));
                console.log(val);
                var contentMarker=val.adresse;
                var marker=new google.maps.Marker({
                    position:posMarker,
                    map:mapObject.map,
                    icon:iconePerso
                });
                var infowindow=new google.maps.InfoWindow({
                    content:contentMarker
                });
                google.maps.event.addListener(marker,'click',function(data){
                    infowindow.open(mapObject.map,marker);
                    console.log('affichage infowindow');
                });
            });
        });
    },

    // Ajout d'un marker
    addMarker:function(pos,map){
        var lat=pos.lat();
        var lng=pos.lng();
        // console.log('latitude du marker : '+lat);
        // console.log('longitude du marker : '+lng);

        $("#dialog-form").dialog({
        autoOpen:true,
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
                    dataType:'json',
                    type: 'POST',
                    data: 'latitude='+lat+'&longitude='+lng+'&titre='+titre+'&description='+description,
                    success:handleResponse
                });
                function handleResponse(data){
                    $('#answer').get(0).innerHTML=data.msg;
                    console.log(data);
                    if (data.error==false) {      
                        var marker=new google.maps.Marker({
                            position:pos,
                            map:mapObject.map,
                            icon:iconePerso
                        });
                        console.dir(marker);
                        mapObject.params.markerAdded.call(this,pos);
                    };
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
    }
}