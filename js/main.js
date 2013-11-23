$( document ).ready(function() {

    // Affichage calendrier jQuery UI en Francais
    $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );

    $("#birthday:not([readonly='readonly'])").datepicker({
        dateFormat : "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        yearRange: "-90:+0",
    });

    /* Trad FR Moment.js */

    moment.lang('fr', {
        months : "janvier_février_mars_avril_mai_juin_juillet_août_septembre_octobre_novembre_décembre".split("_"),
        monthsShort : "janv._févr._mars_avr._mai_juin_juil._août_sept._oct._nov._déc.".split("_"),
        weekdays : "dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi".split("_"),
        weekdaysShort : "dim._lun._mar._mer._jeu._ven._sam.".split("_"),
        weekdaysMin : "Di_Lu_Ma_Me_Je_Ve_Sa".split("_"),
        longDateFormat : {
            LT : "HH:mm",
            L : "DD/MM/YYYY",
            LL : "D MMMM YYYY",
            LLL : "D MMMM YYYY LT",
            LLLL : "dddd D MMMM YYYY LT"
        },
        calendar : {
            sameDay: "[Aujourd'hui à] LT",
            nextDay: '[Demain à] LT',
            nextWeek: 'dddd [à] LT',
            lastDay: '[Hier à] LT',
            lastWeek: 'dddd [dernier à] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : "dans %s",
            past : "il y a %s",
            s : "quelques secondes",
            m : "une minute",
            mm : "%d minutes",
            h : "une heure",
            hh : "%d heures",
            d : "un jour",
            dd : "%d jours",
            M : "un mois",
            MM : "%d mois",
            y : "une année",
            yy : "%d années"
        },
        ordinal : function (number) {
            return number + (number === 1 ? 'er' : 'ème');
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });

    moment.lang('fr');

    $('#timeStart, #timeEnd').combodate({
        firstItem: 'name', //show 'hour' and 'minute' string at first item of dropdown
        minuteStep: 15,
        template: "<b> HH </b><i>h</i><b> mm </b>",
        firstItem:"empty"
    }); 


    $('body').on('click', '#profil.edition .infos img', function(){
        console.log("clicked");
        $('#uploadForm input[type=file]').trigger('click');

    });
    $('body').on('change', '#profil.edition input[type=file]', function(){
        if($(this).length == 1){
            $('#uploadForm #submitButton').trigger('click');
        }
    });

    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        $('#submitButton').attr('disabled', ''); // disable upload button
        //show uploading message
        $("#profil figure img").after('<span class="loader"></span>');
        $(this).ajaxSubmit({
            success:  afterSuccess //call function after success
        });
    });

    function afterSuccess(data)  { 
        $('#uploadForm').resetForm();  // reset form
        $('#submitButton').removeAttr('disabled'); //enable submit button
        $('.loader').remove();

        if(data.erreur === true){
            // erreur 
            var msg = '<p class="text-error">'+data.msg+'</p>';
            $("#profil .infos img").after( msg );
        }
        else{
            // succès !
            $('.text-error').slideUp(1000 , function(){
                $(this).remove();
            });

            d = new Date();
            $("#profil .infos img").attr("src", siteUrl+"upload/"+id+".jpg?"+ new Date().getTime() );
        }

    } 



    // Valeur par défaut pour X-Editable
    $.fn.editable.defaults.params = { action : "editProfil" };
    $.fn.editable.defaults.pk = id;

	
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

        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: "form_traitement.php",
            data: {
                first_name: info.first_name,
                last_name: info.last_name,
                email: info.email,
                birthday: info.birthday,
                id_fb : info.id
            },

            success: function( data ){
                console.log("return : "+data);
            }


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


    var afficherSpotsFavoris = function(data){
        $resultSpots = $('.spotsFav .result');

        if(data.length != 0){
            
            $resultSpots.empty();

            $.each(data, function( key, value ) {

                var wrap    = $('<div>').addClass('show');
                var button  = $('<button>').addClass('removeFavSpot animate').attr('data-id', value.id_spot).html('Supprimer des spots favoris');
                //value.note_moyenne_utilisateurs
                var span1   = $('<span>').html( value.titre +" - ");
                var span2   = $('<span>').html( value.adresse );
                var note    = '<div class="rateit-rated" min="0" max="5" data-rateit-value="'+value.note_moyenne_utilisateurs+'" data-rateit-ispreset="true" data-rateit-readonly="true"></div>';


                wrap.append( button, span1, span2, note);
                $resultSpots.append( wrap );

                $('div.rateit-rated').rateit();

            });
            
            $resultSpots.mCustomScrollbar({
                advanced:{
                    updateOnContentResize: true
                }
            });
        }

        else{
            var msg = $('<div>').addClass('show').html('Vous n\'avez aucun spot en favoris');
            $resultSpots.empty().append( msg );
        }
    };

    /* Afficher les Slackers Favoris */

    $('#favoriteSlackers').on('click', function(){

        request.actionGet( 'getFavSlackers' ,  afficherSlackersFavoris );

    });

    var afficherSlackersFavoris = function(data){

        $resultSlackers = $('.result.user');

        if(data.length != 0){
            
            $resultSlackers.empty();

            $.each(data, function( key, value ) {

                var photo_default = siteUrl+'upload/default.jpg';
                var photo   =  $('<img>').attr('src', siteUrl+'upload/'+value.id+'.jpg');
                photo.error(function(){
                    $(this).attr('src', photo_default);
                });

                var wrap    = $('<div>').addClass('show complet');
                var button  = $('<button>').addClass('removeFavSlacker animate').attr('data-id', value.id).html('Supprimer des slackers favoris');
                var span1   = $('<span>').html( value.prenom + " "+ value.nom.substring(0,1) + "." );
                var span2   = $('<span>').html( value.niveau );

                wrap.append( button, photo , span1, span2 );
                $resultSlackers.append( wrap );



            });

            $resultSlackers.mCustomScrollbar({
                advanced:{
                    updateOnContentResize: true
                }
            });
        }

        else{
            var msg = $('<div>').addClass('show').html('Vous n\'avez aucun slackers en favoris');
            $resultSlackers.empty().append( msg );
        }

    };


    /* Rrecherche + Affichage des résultats */

    $.fn.search = function(options) {

        var params = {

            result: "",             // jQuery Container of search results
            rate: false,            // display Rating ?
            url: "",                // url to file
            simpleSearch: false,    // affichage simple ou complexe (ajout/retrait favoris)
            onSuccess: null,
            onEmptySearch: null
        }

        var property = $.extend(this.params,options);
        var _this = $(this);

        return this.each(function()
        {
            var searchid = $(this).val();
            var dataString = 'search='+ searchid;
            if(property.simpleSearch){
                dataString+= '&simpleSearch=true';
            }

            if(searchid!=''){
                $.ajax({
                    type: "POST",
                    url: property.url,
                    data: dataString,
                    cache: false,
                    success: function(data) {
                        // paramètres : Résultat Recherche + jQuery Object du Container
                        property.onSuccess.call(this, data, property.result);
                        if(property.rate){
                            $('.rateit-rated').rateit();
                        }
                    }
                });
            }
            else{
                property.onEmptySearch.call(this);
            }   
        });

    };

    $("#searchSpotInProfil").keyup(function() { 
        $this = $(this);
        $this.search({
            result: $this.siblings('.result'),
            rate: true,
            url: "includes/searchSpot.php",
            onSuccess: function(data, container){
                $(container).html(data).show().mCustomScrollbar();
            },
            onEmptySearch: function(){
                console.log("#searchSpotInProfil OnEmptySearch");
                request.actionGet('getFavSpots', afficherSpotsFavoris );
            }
        });
    });

    $("#searchUserInProfil").keyup(function() { 
        $this = $(this);
        $(this).search({
            result: $this.siblings('.result'),
            url: "includes/searchUser.php",
            onSuccess: function(data, container){
                $(container).html(data).show().mCustomScrollbar();
            },
            onEmptySearch: function(){
                console.log("#searchUserInProfil OnEmptySearch");
                request.actionGet('getFavSlackers', afficherSlackersFavoris );
            }
        });
    });

    $("#searchUser").keyup(function() { 
        $this = $(this);
        $(this).search({
            result: $this.siblings('.result'),
            url: "includes/searchUser.php",
            simpleSearch: true,

            onSuccess: function(data, container){
                $(container).html(data).slideDown('slow', function(){ $(this).mCustomScrollbar(); });
            },
            onEmptySearch: function(){
                $this.siblings('.result').slideUp();
                
            }
        });
    });

    $("#searchSpot").keyup(function() { 
        $this = $(this);
        $(this).search({
            result: $this.siblings('.result'),
            url: "includes/searchSpot.php",
            simpleSearch: true,
            rate: true,
            onSuccess: function(data, container){
                $(container).html(data).slideDown('slow', function(){ $(this).mCustomScrollbar(); });
            },
            onEmptySearch: function(){
                $this.siblings('.result').slideUp();
                
            }
        });
    });




/*

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
                    $('#resultSpots').mCustomScrollbar();
                    $('.rateit-rated').rateit();
                }
            });
        }
        else{
            request.actionGet('getFavSpots', afficherSpotsFavoris );
        }

    });

    $("#resultSpots").on("click",function(e){ 
        var $clicked = $(e.target);
        var $name = $clicked.find('.name').html();
        var decoded = $("<div/>").html($name).text();
        $('#searchid').val(decoded);
    });

    $('#searchid').click(function(){
        $("#resultSpots").fadeIn();
    });



*/



    /* AJOUTER / SUPPRIMER SLACKER DES FAVORIS */



    $('body').on('click', '.removeFavSlacker', function(){

        params = {action: 'removeFavSlacker' , userId: $(this).data('id')};
        request.actionPost ( params , afficherSlackers );

    });

    $('body').on('click', '.addFavSlacker', function(){

        params = {action: 'addFavSlacker' , userId: $(this).data('id')};
        request.actionPost ( params , afficherSlackers);
    });
	
    var afficherSlackers = function(data){
        var res = $('.slackersFav .result.user button');

        if(res.hasClass('animate')){
            res.filter('[data-id='+data.id+']').parents('.show').slideUp(600, function(){
                $(this).remove();
                if($('.result.user .mCSB_container').is(':empty')){
                    request.actionGet ( 'getFavSlackers', afficherSlackersFavoris );
                }
            });
        }
        else{
            res.filter('[data-id='+data.id+']').toggleClass('addFavSlacker removeFavSlacker');
        }
        
    }

    function getAge(dateString) {
      var today = new Date();
      var birthDate = new Date(dateString);
      var age = today.getFullYear() - birthDate.getFullYear();
      var m = today.getMonth() - birthDate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      return age;
    }




    $('body').on('click', '#getProfil' , function(){

        request.actionGet ( 'getUserProfil' , afficherProfil);

    })


    var afficherProfil = function(data){

        if(data.length == 0){
            $('body').append('Problème d\'affichage du profil <br/>');
        }
        else{

            $('#profil .infos img').attr('src', data[0].picture);
            $('#profil .infos figcaption').text( data[0].nom + " " + data[0].prenom );
            $('#profil .infos span:nth-of-type(1)').text ( getAge(data[0].date_naissance)+" ANS" ).data('value',data[0].date_naissance);
            $('#profil .infos span:nth-of-type(2)').text ( data[0].niveau ).data('value', data[0].niveau );
            $('#profil .infos div:nth-of-type(2)').html( data[0].description ).data('value', data[0].description );
            $('#profil .infos input[name=phone]').val( data[0].telephone ).data('value', data[0].telephone );
            $('#profil .infos input[name=email]').val( data[0].email );

            // Boucle sur les catégories pratiquées

            var technique_formated = data[0].technique.replace(/\s/g,'');
            technique_formated = technique_formated.split(",");

            var skills = "";
            for (var i=0; i<technique_formated.length; i++) {

                if(technique_formated[i].length > 1){

                    $(".skill").each(function() {
                        var type = $(this).data("type");

                        if(type == technique_formated[i]){
                            $(this).addClass('active');
                        }

                    });
                }
            }

            $('.skills > div').isotope({ filter: '.active' });


            if(parseInt(data[0].materiel) == 1){
                $('#material').prop('checked','checked');
            }

        }

    };

    $('.skills > div').isotope({
      // options
      itemSelector : '.skill',
      layoutMode : 'fitRows'

    });

    $('body').on('click', '#profil.edition .skill', function(){
        $(this).toggleClass('active');
    })

    $('body').on('click', '#profilDisplay' , function(){
        $(this).fadeOut('slow');
        $('#profil').fadeTo('slow',1);
    })

    var edition = function(){

        console.log('enabled');
        $('#profil').toggleClass('edition');
        $('#profil .editable').editable('enable');

        $('button[name=editSkills]').toggleClass('hidden');

        // on affiche toutes les catégories pratiquées
        $('.skills > div').isotope({ filter: '*' });

        $('#profil .infos input[type=tel]').prop('disabled',false).prop('readonly', true);
        $('#editProfil').text('Enregistrer mes modifications');

        $('#profil .infos span:nth-of-type(1)').editable({
            name: 'date_naissance',
            type: 'combodate',
            url: './includes/actions.php',
            title: 'Âge : ',
            format: 'YYYY-MM-DD',
            viewformat: 'DD/MM/YYYY',
            template: 'D / MM / YYYY',
            inputclass: 'combodate',
            combodate: {
                minYear: 1920,
                maxYear: 2013,
                minuteStep: 1
            },
            display: function(value) {
                $(this).text(getAge(value)+" ANS");
            } 

        });


         $('#profil .infos span:nth-of-type(2)').editable({
            name: 'niveau',
            url: './includes/actions.php',
            type: 'select',
            title: 'Niveau : ',
            select2: {
                width: 200,
                placeholder: 'Niveau',
                allowClear: false
            },
            source: [
                {value: "debutant", text: 'Débutant'},
                {value: "intermediaire", text: 'Intermédiaire'},
                {value: "confirme", text: 'Confirmé'},
                {value: "expert", text: 'Expert'}
            ]
        });

        $('#profil .infos > div:nth-of-type(2)').editable({
            name : 'description',
            url: './includes/actions.php',
            title: 'Description : ',
            type: 'textarea',
            rows : 5

        });

        $('#profil .infos > input[type=tel]').editable({
            name : 'telephone',
            url: './includes/actions.php',
            title: 'Téléphone : ',
            type: 'text',
            success: function(data) {
                $(this).val(data.value).attr('value', data.value );
            }


        });

        $('#profil p:nth-child(9) span:nth-child(2)').editable({
            name: 'telephone',
            url: './includes/actions.php',
            type: 'tel',

        });

    }
    // Désactive l'édition du profil
    var editionCompleted = function(){
        var skills = new Array();
        // on récupère toutes les catégories de slackline actives
        $(".skills .skill.active").each(function(i) {
            skills[i] = $(this).data('type');
        });

        params = {action: 'saveSkills' , skills: skills };
        request.actionPost ( params , afficherSkills );

        $('#profil').toggleClass('edition');
        $('#profil .editable').editable('disable');
        $('button[name=editSkills]').toggleClass('hidden');
        $('.skills > div').isotope({ filter: '.active' });
        $('#profil .infos input[type=tel]').prop('disabled',true).prop('readonly', false);
        $('.text-error').slideUp('slow', function(){$(this).remove();});
        $('#editProfil').text('Modifier mon profil');

    }

    // Appelle les fonctions d'édition du profil
    $('body').on('click', '#editProfil, button[name="editSkills"]',  function(){
        $this = $(this);
        if($('#profil').hasClass('edition')){
            editionCompleted();
        }
        else{
            edition();
        }
    });



    var afficherSkills = function(data){
        if(data.erreur == true){
            var msg = $('<p>').addClass('text-error').text( data.msg );
            msg.insertBefore('.skills .isotope');
            $('#editProfil').trigger('click');
        }
    }

	// REQUETES GET DE BASE - AFFICHAGE PROFIL 
    request.actionGet ( 'getUserProfil' , afficherProfil);
    request.actionGet ( 'getFavSpots', afficherSpotsFavoris );
    request.actionGet ( 'getFavSlackers', afficherSlackersFavoris );
    request.actionGet ( 'getSpot' , afficherSpots);


    /* AJOUTER / SUPPRIMER SPOTS DES FAVORIS */

    $('body').on('click', '.addFavSpot', function(){

        params = {action: 'addFavSpot' , spotId: $(this).data('id')};
        request.actionPost ( params , afficherSpots);

    });

    $('body').on('click', '.removeFavSpot', function(){

        params = {action: 'removeFavSpot' , spotId: $(this).data('id')};
        request.actionPost ( params , afficherSpots );

    });

    var afficherSpots = function(data){

        var res = $('.spotsFav .result button');
        console.log('This Afficher Spots ');


        if(res.hasClass('animate')){
            res.filter('[data-id='+data.id+']').parents('.show').slideUp(600, function(){
                $(this).remove();
                if($('.spotsFav .result .mCSB_container').is(':empty')){
                    request.actionGet ( 'getFavSpots', afficherSpotsFavoris );
                }
            });
        }
        else{
            res.filter('[data-id='+data.id+']').toggleClass('addFavSpot removeFavSpot');
        }

    }


    /* TEMP */

    $('#profil').prev().trigger("click");


    var afficherSpotsOuverts = function(data){
        // $('.content').html("Spot Ouvert : "+data[0].id_spot+" Id Utilisateur : "+data[0].id_utilisateur+" Fermeture le : "+data[0].date_fermeture);
        //console.log(data);

        $.each(data, function( key, value ) {
            console.log("clé : "+key+" valeur : ID SPOT"+value.id_spot+" USER "+value.id_utilisateur+" DATE FERM. "+value.date_fermeture);
        });

    }

    $('body').on('click', '.temp', function(){

        request.actionGet ( 'getSpotOpen', afficherSpotsOuverts );

    });

    setTimeout(function(){ 
        // récuperer les spots 'ouverts' toutes les 3 minutes
        request.actionGet ( 'getSpotOpen', afficherSpotsOuverts );
    }, 18000);


    $('#spotStep1').on('click', function(){

        $('#accueilCarte, #infoSpot').toggleClass('hidden');

    });

    $('#spotStep2').on('click', function(){

        $('#infoSpot, #catSpot').toggleClass('hidden');

    });

    $('#spotStep3').on('click', function(){

        $('#catSpot, #detailSpot').toggleClass('hidden');

    });


    

});



