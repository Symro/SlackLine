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

                button.onclick = function() {
                    FB.login(function(response) {
                        if (response.authResponse) {
                            FB.api('/me', function(info) {
                                login(response, info);
                            });    
                        } else {
                            // l'Utilisateur a annulé l'identification ou a refusé l'accès à ses infos
                        }
                    }, {scope:'email,user_birthday'});   
                }
            }
        }
        
        FB.getLoginStatus(updateButton);
        FB.Event.subscribe('auth.statusChange', updateButton);  

        function login(response, info){
            if (response.authResponse) {

                var accessToken  =  response.authResponse.accessToken;
                
                
                if($('body').hasClass('inscription')){

                    $('#lastname').val(info.last_name).prop("readonly",true).removeClass("erreur");
                    $('#firstname').val(info.first_name).prop("readonly",true).removeClass("erreur");
                    $('#email').val(info.email).prop("readonly",true).removeClass("erreur");
                    $('#birthday').val(convertDate(info.birthday)).prop("readonly",true).removeClass("erreur");
                    
                    $('input[name=fb-picture]').val(info.id);
                }

                button.innerHTML = 'Se déconnecter de facebook';

            }
        }


        function logout(response){
            button.innerHTML = 'Compléter avec facebook';
            $('#form-inscription').removeClass('email-error').children('input[type=text], input[type=email]').prop("readonly",false).val("");
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

    // Affichage calendrier jQuery UI en Francais
    $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );

    $("#birthday:not([readonly='readonly'])").datepicker({
        dateFormat : "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        yearRange: "-90:+0",
    });


});
