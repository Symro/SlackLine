        
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
                    "<i class='icon-chevron-left'></i>",
                    "<i class='icon-chevron-right'></i>"
                    ],
                    //Call beforeInit callback, elem parameter point to $("#owl-demo")

                });
                $("#owl-section2").owlCarousel({
                    navigation: true,
                    slideSpeed : 1000,
                    paginationSpeed : 4000,
                    singleItem : true,
                    navigationText: [
                    "<i class='icon-chevron-left-white'></i>",
                    "<i class='icon-chevron-right-white'></i>"
                    ],
                    //Call beforeInit callback, elem parameter point to $("#owl-demo")

                });


            });
        </script>
        <?php endif; ?>



    </body>
</html>