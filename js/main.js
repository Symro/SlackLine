$( document ).ready(function() {


    /* Valeur par défaut pour X-Editable */
    $.fn.editable.defaults.params = { action : "editProfil" };
    $.fn.editable.defaults.pk = id;

    /* Custom Scrollbar - initialisation */

    $('#profil, #slacker > .spotsFav .result, #spotDisplay').mCustomScrollbar({
        advanced:{ updateOnContentResize: true,autoScrollOnFocus: false }
    });

    /* Combodate - initialisation */
    $('#timeStart, #timeEnd').combodate({
        firstItem: 'name',
        minuteStep: 15,
        template: "<b> HH </b><i>h</i><b> mm </b>",
        firstItem:"empty"
    }); 

    /* Calcul de l'age d'une personne à partir d'un DATE */
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
    /* Ajout de 0 pour les heures ou minutes */
    function addZero(n){return n<10 ? '0'+n : n}



    /* ------------------- EDITON DU PROFIL ------------------- */
    /* -------------------------------------------------------- */

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
        $('#submitButton').attr('disabled', '');
        //show uploading message
        $("#profil figure img").after('<span class="loader"></span>');
        $(this).ajaxSubmit({
            success:  afterSuccess
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
            $("#profil .infos img, #profilDisplay").attr("src", siteUrl+"upload/"+id+".jpg?"+ new Date().getTime() );
        }

    } 

    /* --------------- ENVOI DE REQUETES AJAJ ----------------- */
    /* -------------------------------------------------------- */
	
	var request = {

        logout : function(){

            $.ajax({
                url: "./logout.php",
                type: "POST",
                dataType: "json",
                success: function(data){
                    window.location.href = "index.php?logout";
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


    }

    function callback(data){
        console.log(data);
    }


    /* ------------------ FONCTIONNALITÉS --------------------- */
    /* -------------------------------------------------------- */

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

    // Fonction de callback - Affichage des Spots Favoris de l'utilisateur
    var afficherSpotsFavoris = function(data){
        $resultSpots = $('#profil .spotsFav .result');

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
                    updateOnContentResize: true,
                    autoScrollOnFocus: false
                }
            });
        }

        else{
            var msg = $('<div>').addClass('show').html('Vous n\'avez aucun spot en favoris');
            $resultSpots.empty().append( msg );
        }
    };


    /* ------------------------------------------------------------- */
    /* -- FEATURE : Ajout d'utilisateur en favoris ----------------- */
    /* ------------------------------------------------------------- */
    
    $('#favoriteSlackers').on('click', function(){
        request.actionGet( 'getFavSlackers' ,  afficherSlackersFavoris );
    });

    // Fonction de callback - Affichage des Spots Favoris de l'utilisateur
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
                    updateOnContentResize: true,
                    autoScrollOnFocus: false
                }
            });
        }

        else{
            var msg = $('<div>').addClass('show').html('Vous n\'avez aucun slackers en favoris');
            $resultSlackers.empty().append( msg );
        }

    };


    /* ------------------------------------------------------------- */
    /* -- FEATURE : Plugin de recherche + Affichage des résultats    */
    /* ------------------------------------------------------------- */

    $.fn.search = function(options) {

        var params = {

            result: "",             // Objet jQuery pour afficher le résultat
            rate: false,            // Affichage de la notation
            url: "",                // URL de l'appel AJAJ
            simpleSearch: false,    // Affichage simple ou complexe > (ajout/retrait favoris)
            onSuccess: null,        // Fonction de callback - affichage
            onEmptySearch: null     // Fonction de callback - champ vide
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


    /* ------------------------------------------------------------- */
    /* -- FEATURE : Ajouter / Supprimer des SLACKERS de ses favoris  */
    /* ------------------------------------------------------------- */

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


    $('body').on('click', '#getProfil' , function(){
        request.actionGet ( 'getUserProfil' , afficherProfil);
    })

    /* ------------------------------------------------------------- */
    /* -- FEATURE : Ajouter / Supprimer des SPOTS de ses favoris     */
    /* ------------------------------------------------------------- */

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


    /* ------------------------------------------------------------- */
    /* -- FEATURE : Affichage du profil de l'utilisateur connecté    */
    /* ------------------------------------------------------------- */

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

                    $("#profil .skill").each(function() {
                        var type = $(this).data("type");

                        if(type == technique_formated[i]){
                            $(this).addClass('active');
                        }

                    });
                }
            }

            $('#profil .skills > ul').isotope({ filter: '.active' });

            if(parseInt(data[0].materiel) == 1){
                $('#material').prop('checked','checked');
            }

        }

    };

    $('#profil .skills > ul').isotope({
      // options
      itemSelector : '.skill',
      layoutMode : 'fitRows'

    });

    $('body').on('click', '#profilDisplay' , function(){
        $(this).fadeOut('slow');
        $('#profil').fadeTo('slow',1);
    });
    $('body').on('click', '#profilClose', function(){
        $('#profilDisplay').fadeIn('slow');
        $('#profil').fadeTo('slow',0);
    });


    /* ------------------------------------------------------------- */
    /* -- FEATURE : Edition du profil                                */
    /* ------------------------------------------------------------- */


    // Appelle les fonctions d'édition du profil
    $('body').on('click', '#editProfil, button[name="editSkills"]',  function(){
        if($('#profil').hasClass('edition')){
            editionProfilCompleted();
        }
        else{
            editionProfil();
        }
    });

    $('body').on('click', '#profil.edition .skill', function(){
        $(this).toggleClass('active');
    });

    var editionProfil = function(){

        $('#profil').toggleClass('edition');
        $('#profil .editable').editable('enable');

        $('button[name=editSkills]').toggleClass('hidden');

        // on affiche toutes les catégories pratiquées
        $('#profil .skills > ul').isotope({ filter: '*' });

        $('#profil .infos input[type=tel]').prop('disabled',false).prop('readonly', true);
        $('#editProfil').text('Enregistrer mes modifications');

        // Edition des champs avec x-editable
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
            type: 'tel'
        });

    }

    // Désactive l'édition du profil
    var editionProfilCompleted = function(){
        var skills = new Array();
        // on récupère toutes les catégories de slackline actives
        $("#profil .skills .skill.active").each(function(i) {
            skills[i] = $(this).data('type');
        });

        params = {action: 'saveSkills' , skills: skills };
        request.actionPost ( params , afficherSkillsProfil );

        $('#profil').toggleClass('edition');
        $('#profil .editable').editable('disable');
        $('button[name=editSkills]').toggleClass('hidden');
        $('#profil .skills > ul').isotope({ filter: '.active' });
        $('#profil .infos input[type=tel]').prop('disabled',true).prop('readonly', false);
        $('.text-error').slideUp('slow', function(){$(this).remove();});
        $('#editProfil').text('Modifier mon profil');

    }

    // Callback si l'utilisateur n'a pas renseigné de catégorie pratiqué dans son profil
    var afficherSkillsProfil = function(data){
        if(data.erreur == true){
            var msg = $('<p>').addClass('text-error').text( data.msg );
            msg.insertBefore('#profil .skills .isotope');
            $('#editProfil').trigger('click');
        }
    }

	// REQUETES GET DE BASE - AFFICHAGE PROFIL 
    request.actionGet ( 'getUserProfil',    afficherProfil);
    request.actionGet ( 'getFavSpots',      afficherSpotsFavoris);
    request.actionGet ( 'getFavSlackers',   afficherSlackersFavoris);
    request.actionGet ( 'getSpot',          afficherSpots);


    /* ------------------------------------------------------------- */
    /* -- FEATURE : Création d'un Spot                               */
    /* ------------------------------------------------------------- */

    var spotCreation = function(){
        $('#saveSpot').text('Nouveau spot ajouté !').prop('disabled',true).next().removeClass('hidden');

        var skills = new Array();
        // on récupère toutes les catégories de slackline actives
        $("#spot .skills .skill.active").each(function(i) {
            skills[i] = $(this).data('type');
        });

        $('#spot .skills > ul').isotope({ filter: '.active' });

        $('#spot').removeClass('edition');

    }

    var spotCreationCompleted = function(){
        $('#saveSpot').text('Valider').prop('disabled',false).next().addClass('hidden');

        $('#spot').removeClass('edition');
        $('#spot .skills > ul').isotope({ filter: '*' }).children('li').removeClass('active');
    }

    $('body').on('click', '#spot.edition .skill', function(){
        $(this).toggleClass('active');
    });

    // Clic sur marquer un spot > passage en mode edition
    $('#spot').on('click', '#newSpot', function(){
        $('#spot').addClass('edition');
    });

    // Clic sur croix > fermeture mode edition
    $('body').on('click', 'a[href=#accueilCarte]', spotCreationCompleted);

    // Clic sur valider > enregistrement en BDD
    $('#saveSpot').on('click', spotCreation);


    /* ------------------------------------------------------------- */
    /* -- FEATURE : Consulter le profil d'un utilisateur (slacker)   */
    /* ------------------------------------------------------------- */

    $('body').on('click', '.rechercheSlacker .show.simple, #resultCalendar .show.simple' , function(){

        var m = $("#spotDisplay");
        if(m.hasClass('in')){ m.modal('hide');}
m
        params = {action: 'getSlackerProfil' , userId: $(this).data('id')};
        request.actionPost ( params , afficherProfilSlacker);

    });

    var afficherProfilSlacker = function(data){

        if(data.length == 0){
            $('body').append('Problème d\'affichage du profil <br/>');
        }
        else{

            // Affichage des infos du profil

            $('#slacker .infos img').attr('src', data[0].picture);
            $('#slacker .infos figcaption').text( data[0].nom + " " + data[0].prenom );
            $('#slacker .infos span:nth-of-type(1)').text ( getAge(data[0].date_naissance)+" ANS" );
            $('#slacker .infos span:nth-of-type(2)').text ( data[0].niveau );
            $('#slacker .infos div:nth-of-type(2)').html( data[0].description );
            $('#slacker .infos input[name=phone]').val( data[0].telephone );
            $('#slacker .infos input[name=email]').val( data[0].email );
            $("#slacker .skill").removeClass('active');
            $('#slacker .favSlacker').attr('data-id', data[0].id).removeClass('removeFavSlacker addFavSlacker').addClass( data[0].favoris_class );

            // Boucle sur les catégories pratiquées
            
            var slacker_skills = data[0].technique.replace(/\s/g,'');
            slacker_skills = slacker_skills.split(",");

            var skills = "";
            for (var i=0; i<slacker_skills.length; i++) {

                if(slacker_skills[i].length > 1){

                    $("#slacker .skill").each(function() {
                        var type = $(this).data("type");

                        if(type == slacker_skills[i]){
                            $(this).addClass('active');
                        }

                    });
                }
            }

            $('#slacker .skills > ul').isotope({ filter: '.active' });


            if(parseInt(data[0].materiel) == 1){
                $('#material').prop('checked','checked');
            }

            // Boucle sur les spots favoris 

            $resultSpots = $('#slacker .spotsFav .result').empty();

            if(data[1]){

                $.each(data[1], function(i, data) {

                        var wrap    = $('<div>').addClass('show').data('spotid', data.id_spot);
                        var icon    = $('<span>').addClass('img');
                        var span1   = $('<span>').html( data.titre +" - ");
                        var span2   = $('<span>').html( data.adresse );
                        var note    = '<div class="rateit-rated" min="0" max="5" data-rateit-value="'+data.note_moyenne_utilisateurs+'" data-rateit-ispreset="true" data-rateit-readonly="true"></div>';

                        wrap.append( icon, span1, span2, note);
                        $resultSpots.append( wrap );

                });

                $('div.rateit-rated').rateit();
            }
            else{
                var wrap    = $('<div>').addClass('show').text('Aucun Favoris');
                $resultSpots.append( wrap );
            }

            $('#slacker').addClass('open').removeClass('close');

        }

    }

    $('#closeSlacker').on('click', function(){
        $('#slacker').addClass('close').removeClass('open');
    });


    /* TODO :
    revoir ajout suppression slacker */

    $('#slacker').on('click', '.favSlacker', function(){
        $(this).toggleClass('addFavSlacker removeFavSlacker');
    });


    /* ------------------------------------------------------------- */
    /* -- FEATURE : S'inscrire sur un spot                           */
    /* ------------------------------------------------------------- */

    $('body').on('click', '.spotDisplay', function(){

        var id = $(this).data('id');
        spotDisplay(id);

    });

    var spotDisplay = function(spotId){

        $.each(mapMarkers.responseJSON ,function(key,val){
            if(val.id == spotId){
                currentSpot = mapMarkers.responseJSON[key];
                var note    = '<div class="rateit-rated" min="0" max="5" data-rateit-value="'+currentSpot.note+'" data-rateit-ispreset="true" data-rateit-readonly="true"></div>';
                var modal   = $('#spotDisplay');

                modal.find('.modal-body h2:first').text( currentSpot.titre );
                modal.find('.description').text( currentSpot.description );
                modal.find(".skill").removeClass('active');
                //modal.find('.modal-body div:first').html( note ).rateit();


                // Boucle sur les catégories pratiquées
            
                var slacker_skills = currentSpot.categorie.replace(/\s/g,'');
                slacker_skills = slacker_skills.split(",");

                var skills = "";
                for (var i=0; i<slacker_skills.length; i++) {
                    if(slacker_skills[i].length > 1){
                        modal.find(".skill").each(function() {
                            var type = $(this).data("type");
                            if(type == slacker_skills[i]){
                                $(this).addClass('active');
                            }
                        });
                    }
                }

                modal.find('.skills > ul').isotope({ filter: '.active' });

            }
        });

        var date = $('#spotDisplay .selectJour option:first').data('date');
        params = {action: 'getSlackerOnSpot' , date: date , spot: currentSpot.id};
        request.actionPost ( params , afficherSlackerSurSpot);

    }

    // Au changement de date dans la modal
    $('#spotDisplay .calendar select').on('change', function(){

        var date = $(this).children(':selected').data('date');
        params = {action: 'getSlackerOnSpot' , date: date , spot: currentSpot.id};
        request.actionPost ( params , afficherSlackerSurSpot);
        
    });

    var afficherSlackerSurSpot = function(data){
        var $resultSlackerSurSpot = $('#spotDisplay .calendar .result').empty();
        
        if(data.length != 0){

            $.each(data, function(i, value) {
            
                var photo_default = siteUrl+'upload/default.jpg';
                var photo   =  $('<img>').attr('src', siteUrl+'upload/'+value.id+'.jpg');
                photo.error(function(){
                    $(this).attr('src', photo_default);
                });
                var date_ouverture_heure    = addZero(value.date_ouverture_heure);
                var date_ouverture_minute   = addZero(value.date_ouverture_minute);
                var date_fermeture_heure    = addZero(value.date_fermeture_heure);
                var date_fermeture_minute    = addZero(value.date_fermeture_minute);


                var wrap    = $('<div>').addClass('show simple').attr('data-id', value.id);
                var span1   = $('<span>').html( value.prenom + " "+ value.nom.substring(0,1) + "." );
                var span2   = $('<span>').html( value.niveau );
                var span3   = $('<span>').html( "DE : "+date_ouverture_heure+"H"+date_ouverture_minute+" À : "+date_fermeture_heure+"H"+date_fermeture_minute );
                var div     = $('<div>').append( span1, span2 , span3);

                wrap.append( photo , div);

                $resultSlackerSurSpot.append( wrap );

            });

        }
        else{
            var wrap    = $('<p>').addClass('show text-error').html('Personne n\'a prévu de se rendre sur ce spot. Essayez une autre date');
            $resultSlackerSurSpot.append( wrap );
        }



    }








    /* TEMP : FEATURE SPOTS OUVERTS */

    $('#spotDisplay').on('show.bs.modal', function () {
        $('#spotDisplay .modal-content').css('height',$( window ).height()*0.8);
    });

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

    /* FIN TEMP */


});



