$(document).ready(function() {
  $.ajaxSetup({ cache: true });
  $.getScript('//connect.facebook.net/en_US/all.js', function(){
        var button;
        var userInfo;

        FB.init({ 
            appId: '616364058414041', //change the appId to your appId
            status: true, 
            cookie: true,
            xfbml: true,
            oauth: true
        });
       
       function updateButton(response) {
            button       =   document.getElementById('fb-connect');
            userInfo     =   document.getElementById('user-info');
            
            if (response.authResponse) {
                // Utilisateur déjà identifié et connecté
                FB.api('/me', function(info) {
                    login(response, info);
                });
                
                button.onclick = function() {
                    FB.logout(function(response) {
                        logout(response);
                        
                    });
                };
            } else {
                // Utilisateur déconnecté de fb ou de l'appli
                console.log('Utilisateur déconnecté de fb ou de l\'appli');

                button.onclick = function() {
                    FB.login(function(response) {
                        if (response.authResponse) {
                            FB.api('/me', function(info) {
                                login(response, info);
                            });    
                        } else {
                            // l'Utilisateur a annulé l'identification ou a refusé l'accès à ses infos
                            console.log('l\'Utilisateur a annulé l\'identification ou a refusé l\'accès à ses infos');
                        }
                    }, {scope:'email,user_birthday'});   
                }
            }
        }
        
        // run once with current status and whenever the status changes
        FB.getLoginStatus(updateButton);
        FB.Event.subscribe('auth.statusChange', updateButton);  
        //FB.Event.subscribe('auth.logout', updateButton);  


        //$('#loginbutton,#feedbutton').removeAttr('disabled');
        //FB.getLoginStatus(updateStatusCallback);

        function login(response, info){
            if (response.authResponse) {

                console.dir(response);
                console.log(info);
                var accessToken  =  response.authResponse.accessToken;
                
                // $('#user-info').html('<img src="https://graph.facebook.com/' + info.id + '/picture" alt="'+info.name+'"><br/>' + info.name
                //                     + "<br /> Your Access Token: " + accessToken
                //                     + "<br/> Prénom : "+ info.first_name
                //                     + "<br/> Nom : "+ info.last_name
                //                     + "<br/> Email : " + info.email
                //                     + "<br/> Sexe : " + info.gender
                //                     + "<br/> Anniversaire : " + info.birthday
                //                     + "<br/> ID : "+parseInt(info.id)
                //                     );

                
                if($('body').hasClass('inscription')){
                    /*
                    $('#lastname').val(info.last_name).prop('disabled', true);
                    $('#firstname').val(info.first_name).prop('disabled', true);
                    $('#email').val(info.email).prop('disabled', true);
                    */

                    $('#lastname').val(info.last_name).prop("readonly",true).removeClass("erreur");
                    $('#firstname').val(info.first_name).prop("readonly",true).removeClass("erreur");
                    $('#email').val(info.email).prop("readonly",true).removeClass("erreur");
                    $('#birthday').val(convertDate(info.birthday)).prop("readonly",true).removeClass("erreur");

                }

                button.innerHTML = 'Se déconnecter de facebook';

            }
        }


        function logout(response){
            button.innerHTML = 'Compléter avec facebook';
            $('#form-inscription').removeClass('email-error').children('input[type=text], input[type=email]').prop("readonly",false).val("");
            console.log('Déconnecté');
            //location.reload(); 
        }


        function convertDate(date) {
            var d = new Date(date || Date.now()),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [day, month, year].join('/');
        }

  });        
});
