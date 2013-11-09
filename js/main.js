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


    $('#UploadForm').on('submit', function(e) {
        e.preventDefault();
        $('#SubmitButton').attr('disabled', ''); // disable upload button
        //show uploading message
        $("#output").html('<div style="padding:10px"><img src="img/loading.gif" alt="Please Wait"/> <span>Uploading...</span></div>');
        $(this).ajaxSubmit({
            target: '#output',
            success:  afterSuccess //call function after success
        });
    });

    function afterSuccess(data)  { 
        $('#UploadForm').resetForm();  // reset form
        $('#SubmitButton').removeAttr('disabled'); //enable submit button

        if(data.erreur === true){
            // appelle fonction affichage message d'erreur ?
        }
        else{
            // appelle fonction affichage succès !

        }

    } 



    //turn to inline mode
    //$.fn.editable.defaults.mode = 'inline';
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
                url: "includes/searchUser.php",
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

    $('body').on('click', '#getProfil' , function(){

        request.actionGet ( 'getUserProfil' , afficherProfil);

    })


    var afficherProfil = function(data){

        if(data.length == 0){
            $('body').append('Problème d\'affichage du profil <br/>');
        }
        else{

            /*var profil = "<img src="+data[0].picture+" alt=\"Picture\" />";
            profil+= "<p><span> Nom :       </span><span>"+data[0].nom+"</span></p>";
            profil+= "<p><span> Prénom :        </span><span>"+data[0].prenom+"</span></p>";
            profil+= "<p><span> Email :         </span><span>"+data[0].email+"</span></p>";
            profil+= "<p><span> Date naissance :</span><span data-value="+data[0].date_naissance+">"+data[0].date_naissance+"</span></p>";
            profil+= "<p><span> Niveau :        </span><span>"+data[0].niveau+"</span></p>";
            profil+= "<p><span> Technique :     </span><span>"+data[0].technique+"</span></p>";
            profil+= "<p><span> Description :   </span><span>"+data[0].description+"</span></p>";
            profil+= "<p><span> Matériel :      </span><span>"+data[0].materiel+"</span></p>";
            profil+= "<label class=\"switch-button small\" for=\"material\"><input type=\"checkbox\" id=\"material\" name=\"material\" value="+data[0].materiel+"  ><span>Matériel<span>Non</span><span>Oui</span></span><a class=\"btn btn-primary\"></a></label>";
            profil+= "<p><span> Téléphone :     </span><span>"+data[0].telephone+"</span></p>";
            */

            $('#profil .infos img').attr('src', data[0].picture);
            $('#profil .infos figcaption').text( data[0].nom + " " + data[0].prenom );
            $('#profil .infos span:nth-of-type(1)').text ( data[0].date_naissance ).data('value',data[0].date_naissance);
            $('#profil .infos span:nth-of-type(2)').text ( data[0].niveau ).data('value', data[0].niveau );
            $('#profil .infos div:nth-of-type(2)').text( data[0].description ).data('value', data[0].description );

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
            //$('#profil .skills div').html( skills );



            $('#profil').append('<button id="disableEditProfil">Désactiver Modifs</button>');

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


    var afficherSkills = function(data){

        if(data.erreur === false){
            $('.skills > div').isotope({ filter: '.active' });
            //$('body').off('click', 'input[name="editSkills"]');
            $('input[name=editSkills]').toggleClass('hidden');
            $('#profil').toggleClass('edition');
        }

    }




    var edit = function(){

        console.log('enabled');
        $('#profil').toggleClass('edition');
        $('#profil .editable').editable('enable');

        $('.editProfilImage, input[name=editSkills]').toggleClass('hidden');

        // on affiche toutes les catégories pratiquées
        $('.skills > div').isotope({ filter: '*' });

        $('#profil.edition').on('click', '.skill', function(){
            console.log('click');
            $(this).toggleClass('active');
        })



        $('#profil .infos span:nth-of-type(1)').editable({
            name: 'date_naissance',
            type: 'combodate',
            url: './includes/actions.php',
            format: 'YYYY-MM-DD',
            viewformat: 'DD/MM/YYYY',
            template: 'D / MM / YYYY',
            combodate: {
                minYear: 1920,
                maxYear: 2013,
                minuteStep: 1
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
            type: 'textarea',
            rows : 5

        });

        $('#profil p:nth-child(9) span:nth-child(2)').editable({
            name: 'telephone',
            url: './includes/actions.php',
            type: 'tel',

        });

    }

    // Appelle la fonction d'édition du profil
    $('body').on('click', '#editProfil',  edit );

    // Désactive la possibilité de modifier les champs
    $('body').on('click', '#disableEditProfil',  function(){
        $('#profil .editable').editable('disable');


    });

    // 
    $('body').on('click', '#profil .infos img',  function(){

    });

    // Enregistrer les catégories pratiquées
    $('body').on('click', 'input[name="editSkills"]', function(){
        var skills = new Array();
        // on récupère toutes les catégories de slackline actives
        $(".skills .skill.active").each(function(i) {
            skills[i] = $(this).data('type');
        });

        params = {action: 'saveSkills' , skills: skills };
        request.actionPost ( params , afficherSkills );
    })

	
    request.actionGet ( 'getUserProfil' , afficherProfil);



});


