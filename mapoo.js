var map={
    defaults:{
        map:'',
        zoom:13,
        center:{latitude:48.856614,longitude:2.352221},
        mapTypeId:google.maps.MapTypeId.ROADMAP
    },

    init:function(options){
        this.params=$.extend(this.defaults,options);
    },

    getUserLocation:function(){
        navigator.geolocation.getCurrentPosition(
            function(position){
                map.params.localized.call(this,position.coords);
            },
            function(){
                map.params.localized.call(this,null);
            },
            {enableHighAccuracy:true}
        );
    },

    render:function(pos){
        if(typeof pos==='object'){
                var latLng=new google.maps.LatLng(pos.latitude,pos.longitude);
        }
        else{
            var latLng=new google.maps.LatLng(this.params.center.latitude,this.params.center.longitude);
        }
        var settings={
            zoom:this.params.zoom,
            mapTypeId:google.maps.MapTypeId.ROADMAP,
            center:latLng
        };
        this.map=new google.maps.Map(document.querySelector(this.params.map),settings);
        console.log(latLng);

        // On charge les markers de la BDD sur la carte
        // var list_markers;
        // var i=0;
        // li=list_markers.length;
        // while(i<li){
            // new google.maps.Marker({
            // position:new google.maps.LatLng(list_markers[i][0],list_markers[i][1]),
            //     map:map,
            // });
        //     i++;
        //     console.log(position);
        // }

        $.getJSON("markers.json", function(data){
            $.each(data,function(key,val){
                var latLng=new google.maps.LatLng(val.latitude,val.longitude);
                var marker=new google.maps.Marker({
                    position:latLng,
                    map:this.map,
                });
            });
        });
    }
}