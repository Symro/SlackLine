$( document ).ready(function() {

    // Affichage calendrier jQuery UI en Francais
    $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );

    $("#birthday:not([readonly='readonly'])").datepicker({
        dateFormat : "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        yearRange: "-90:+0",
    });

    $('#materiel').on('click', function(){
        console.log($(this).is(':checked'));
    });
	
	
	var request = {

        params : {


        },
        init : function(){


        },

        logout : function(){

            $.ajax({
                url: "./logout.php",
                type: "POST",
                dataType: "json",
                success: function(data){
                    window.location.href = "login.php?logout";
                }
            });

        },

        actionPost : function( actionData , callback ){

            $.ajax({
                url: "./includes/actions.php",
                type: "POST",
                dataType: 'json',
                data: actionData,
                success: function(data){

                        if (typeof callback === 'undefined') { console.log(data); }
                        else{ callback(data); };

                        /*
                        if(data.erreur){
                            $("body").append('Déjà en favoris..');
                        }
                        else{
                            $('body').append('Supprimé !');
                        }
                        */
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('body').append('Une erreur s\'est produite.. '+xhr.stat+"   "+thrownError);
                }
            });

        },

        actionGet : function( actionName , callback ){
            $.ajax({
                url: "./includes/actions.php",
                type: "GET",
                dataType: "json",
                data: {
                    action: actionName
                },
                
                success: function(data){

                    if (typeof callback === 'undefined') { console.log(data); }
                    else{ callback(data); };

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('body').append('Une erreur s\'est produite.. '+xhr.stat+"   "+thrownError);
                }
            });
        }


    } /* FIN OBJET REQUEST */


    function callback(data){
        console.log(data);
    }


	$( "#form-inscription" ).on( "submit", function( event ) {


        var ajout_bdd = $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: "form_traitement.php",
            //isLocal:true,
            data: {
                first_name: info.first_name,
                last_name: info.last_name,
                email: info.email,
                birthday: info.birthday,
                id_fb : info.id
            },

            success: function( data ){
                // Redirection vers le profil
                //if(data.redirect_profile){
                //    document.location.href="edit_profile.php";
                //}
                console.log("return : "+data);
            }

		//event.preventDefault();
		//console.log( $( this ).serialize() );

	   });
    });



    /* ________________________________ */ 
    /* _______ MANIPULATION BDD _______ */
    /* ________________________________ */ 


    function formatErrorMessage(jqXHR, exception) {

        if (jqXHR.status === 0) {
            return ('Not connected.\nPlease verify your network connection.');
        } else if (jqXHR.status == 404) {
            return ('The requested page not found. [404]');
        } else if (jqXHR.status == 500) {
            return ('Internal Server Error [500].');
        } else if (exception === 'parsererror') {
            return ('Requested JSON parse failed.');
        } else if (exception === 'timeout') {
            return ('Time out error.');
        } else if (exception === 'abort') {
            return ('Ajax request aborted.');
        } else {
            return ('Uncaught Error.\n' + jqXHR.responseText);
        }
    }

    // Déconnexion de l'utilisateur

    $('#logout').on('click', function(){
        request.logout();
    });

    // Afficher la liste des spots


    $('#spotsLists').on('click', function(){
        request.actionGet( 'getSpotList', afficherSpots );
    });
    
    var afficherSpots = function(data){

        $.each(data, function( key, value ) {

            console.log( "key : "+key+" value : "+value);

            // value.id
            // value.id_utilisateur
            // value.latitude
            // value.longitude
            // value.titre
            // value.description
            // value.adresse
            // value.materiel
            // value.note
            // value.categorie

            // // Afficher toutes les datas
            // $.each(this, function(k, v) {
            //     $('body').append( k + " : " + v + " " );
            // });

        });
    };


    /* Afficher les Spots Favoris */

    $('#favoriteSpots').on('click', function(){

        request.actionGet('getFavSpots', afficherSpotsFavoris )

    });

    var afficherSpotsFavoris = function(data){

        $.each(data, function( key, value ) {

            $('body').append('Spot : '+value.titre+' Note : '+value.note+'<br/>');
            console.log( "key : "+key+" value : "+value);

        });
    };

    /* Afficher les Slackers Favoris */

    $('#favoriteSlackers').on('click', function(){

        request.actionGet( 'getFavSlackers' ,  afficherSlackersFavoris );

    });

    var afficherSlackersFavoris = function(data){

        if(data.length == 0){
            $('body').append('Aucun slackers en favoris <br/>');
        }

        $.each(data, function( key, value ) {

            $('body').append('- <button class="removeFavSlacker" data-id="'+value.id+'"> Supprimer des favoris </button> > '+value.prenom+' '+value.nom+' ----  Niveau : '+value.niveau+' <br/>');

            //console.log( "key : "+key+" value : "+value);

        });
    };


    /* RECHERCHE + Affichage résultats */

    $(".searchUser").keyup(function() { 
        var searchid = $(this).val();
        var dataString = 'search='+ searchid;
        if(searchid!='')
        {
            $.ajax({
                type: "POST",
                url: "includes/search.php",
                data: dataString,
                cache: false,
                success: function(data) {
                    $("#resultUsers").html(data).show();
                }
            });
        }
        return false;    
    });

    $("#resultUsers").on("click",function(e){ 
        var $clicked = $(e.target);
        var $name = $clicked.find('.name').html();
        var decoded = $("<div/>").html($name).text();
        $('#searchUser').val(decoded);
    });

    // $(document).on("click", function(e) { 
    //     var $clicked = $(e.target);
    //     if (! $clicked.hasClass("searchUser")){
    //         $("#resultUsers").fadeOut(); 
    //     }
    // });

    $('#searchUser').click(function(){
        $("#resultUsers").fadeIn();
    });





    $(".searchSpot").keyup(function() { 
        var searchid = $(this).val();
        var dataString = 'search='+ searchid;
        if(searchid!='')
        {
            $.ajax({
                type: "POST",
                url: "includes/searchSpot.php",
                data: dataString,
                cache: false,
                success: function(data) {
                    $("#resultSpots").html(data).show();
                }
            });
        }
        return false;    
    });

    $("#resultSpots").on("click",function(e){ 
        var $clicked = $(e.target);
        var $name = $clicked.find('.name').html();
        var decoded = $("<div/>").html($name).text();
        $('#searchid').val(decoded);
    });

    // $(document).on("click", function(e) { 
    //     var $clicked = $(e.target);
    //     if (! $clicked.hasClass("searchSpot")){
    //         $("#resultSpots").fadeOut(); 
    //     }
    // });

    $('#searchid').click(function(){
        $("#resultSpots").fadeIn();
    });







    /* AJOUTER / SUPPRIMER SLACKER DES FAVORIS */



    $('body').on('click', '.removeFavSlacker', function(){

        params = {action: 'removeFavSlacker' , userId: $(this).data('id')};
        request.actionPost ( params , slackerRemoved );

    });

    $('body').on('click', '.addFavSlacker', function(){

        params = {action: 'addFavSlacker' , userId: $(this).data('id')};
        request.actionPost ( params );
    });
	

    var slackerRemoved = function(data){

        console.log(data);

        if( data.erreur === false){
            console.log("Data  : "+data);
            //$('.removeFavSlacker[data-id="'+data.removedId+'"]').hide('slow');
        }

        if(data.length == 0){
            $('body').append('Aucun slackers en favoris <br/>');
        }

    };

    $('body').on('click', '#profil' , function(){

        request.actionGet ( 'getUserProfil' , afficherProfil);

    })

    var afficherProfil = function(data){

        if(data.length == 0){
            $('body').append('Problème d\'affichage du profil <br/>');
        }
        else{

            var profil = "<br/> Nom :       "+data[0].nom;
            profil+= "<br/> Prénom :        "+data[0].prenom;
            profil+= "<br/> Email :         "+data[0].email;
            profil+= "<br/> Date naissance :"+data[0].date_naissance;
            profil+= "<br/> Niveau :        "+data[0].niveau;
            profil+= "<br/> Technique :     "+data[0].technique;
            profil+= "<br/> Description :   "+data[0].description;
            profil+= "<br/> Matériel :      "+data[0].materiel;
            profil+= "<br/> Téléphone :     "+data[0].telephone;

            $('#affichageProfil').html( profil );

        }

    };
	



});



