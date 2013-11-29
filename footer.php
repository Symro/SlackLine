        
        <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        
        <script src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/minified/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script>
		<script type="text/javascript">
            <?php $userId = (!empty($_SESSION['membre_id'])) ? $_SESSION['membre_id'] : 0 ?>
            
            var id = <?php echo $userId; ?>;
            var siteUrl = "<?php echo ROOTPATH; ?>";
		</script>

        <?php if (isset($custom_class) && $custom_class == 'logged'): ?>
        
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-editable.min.js"></script>
        <script type="text/javascript" src="js/moment-with-langs.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <script type="text/javascript" src="js/jquery.isotope.min.js"></script>
        <script type="text/javascript" src="js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script type="text/javascript" src="js/jquery.rateit.min.js"></script>

        <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBoOm_lPvUSlokpQ8XHfSrGUJOm6vNxLjg&sensor=true"></script>

        <script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript" src="js/mapoo.js"></script>
        <script type="text/javascript" src="js/mapuser.js"></script>

        <?php elseif (isset($custom_class) && $custom_class == 'inscription'): ?>
        <script type="text/javascript" src="js/fb_connect.js"></script>

        <?php elseif(isset($custom_class) && $custom_class == 'home'): ?>
        <script type="text/javascript" src="js/jquery.fullPage.min.js"></script>
        <script type="text/javascript" src="js/video_jq.js"></script>
        <script type="text/javascript" src="js/owl.carousel.js"></script>
        <script type="text/javascript" src="js/script.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                
                /* Section fullpage.js */
                var current_width = $(window).width();
                if(current_width <770){
                  $.fn.fullpage({
                  verticalCentered: false,
                  autoScrolling: false,
                  });
                }else{
                  $.fn.fullpage({
                  anchors: ['firstPage', 'secondPage', '3rdPage', '4thpage', 'lastPage'],
                  autoScrolling: true,
                  verticalCentered: false,
                  });    
                }  

                /* Carousel */
                $("#owl-section1").owlCarousel({
                    navigation: true,
                    slideSpeed : 1000,
                    paginationSpeed : 4000,
                    singleItem : true,
                    navigationText: [
                    "<i class='icon-chevron-left rescale'></i>",
                    "<i class='icon-chevron-right rescale'></i>"
                    ],
                    afterAction:function(){
                          switch(this.currentItem){
                    case 0:
                        $("#iconeParislack img:nth-child(1)").addClass("anim_parislack");
                      break;
                    case 1:
                        $("#iconeSlackline img:nth-child(1)").addClass("anim_sol");
                        $("#iconeSlackline img:nth-child(2)").addClass("anim_sangle");
                        $("#iconeSlackline img:nth-child(3)").addClass("anim_perso");

                        setTimeout(
                            function() {
                                // Code déclenchement rotation personnage Slackline
                                $("#iconeSlackline img:nth-child(3)").removeClass("anim_perso");
                                $("#iconeSlackline img:nth-child(3)").addClass("rotate_perso");
                            }, 2500);
                      break;
                    case 2:
                        $("#iconeConvivialite img:nth-child(1)").addClass("anim_persoG");
                        $("#iconeConvivialite img:nth-child(2)").addClass("anim_persoD");

                        setTimeout(
                            function() {
                                // Code déclenchement rotation personnage Slackline
                                $("#iconeConvivialite img:nth-child(1)").removeClass("anim_persoG");
                                $("#iconeConvivialite img:nth-child(1)").addClass("rotate_persoG");
                                $("#iconeConvivialite img:nth-child(2)").removeClass("anim_persoD");
                                $("#iconeConvivialite img:nth-child(2)").addClass("rotate_persoD");
                            }, 2500);
                        break;
                    case 3:
                        $("#iconeCarte img:nth-child(1)").addClass("anim_carte");
                        $("#iconeCarte img:nth-child(2)").addClass("anim_spot1");
                        $("#iconeCarte img:nth-child(3)").addClass("anim_spot2");
                        $("#iconeCarte img:nth-child(4)").addClass("anim_spot3");
                        $("#iconeCarte img:nth-child(5)").addClass("anim_spot4");
                        $("#iconeCarte img:nth-child(6)").addClass("anim_spot5");
                        break;
                    case 4:
                        $("#iconeSpot img:nth-child(1)").addClass("anim_bulle");
                        $("#iconeSpot img:nth-child(2)").addClass("anim_spot");
                        $("#iconeSpot img:nth-child(3)").addClass("anim_curseur");

                        setTimeout(
                            function() {
                                // Code déclenchement rotation personnage Slackline
                            $("#iconeSpot img:nth-child(3)").removeClass("anim_curseur");
                            $("#iconeSpot img:nth-child(3)").addClass("clic_curseur_grand");
                            }, 2500);

                        break;
                    case 5:
                        $("#iconeSlacker img:nth-child(1)").addClass("anim_bulle");
                        $("#iconeSlacker img:nth-child(2)").addClass("anim_spot");
                        $("#iconeSlacker img:nth-child(3)").addClass("anim_curseur");

                        setTimeout(
                            function() {
                                // Code déclenchement rotation personnage Slackline
$("#iconeSlacker img:nth-child(3)").removeClass("anim_curseur");
                $("#iconeSlacker img:nth-child(3)").addClass("clic_curseur_petit");;
                            }, 2500);
                        break;                                               
                    }
                        console.log(this.currentItem);
                    }

                    //Call beforeInit callback, elem parameter point to $("#owl-demo")

                });
                $("#owl-section2").owlCarousel({
                    navigation: true,
                    slideSpeed : 1000,
                    paginationSpeed : 4000,
                    singleItem : true,
                    navigationText: [
                    "<i class='icon-chevron-left-white rescale'></i>",
                    "<i class='icon-chevron-right-white rescale'></i>"
                    ],
                    //Call beforeInit callback, elem parameter point to $("#owl-demo")

                });


            });
        </script>
        <?php endif; ?>



    </body>
</html>