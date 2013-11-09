        
        <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        
        <script src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/minified/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script>
		<script type="text/javascript">
            <?php $userId = (!empty($_SESSION['membre_id'])) ? $_SESSION['membre_id'] : 0 ?>

		    jQuery(function($){ $.datepicker.setDefaults($.datepicker.regional['fr']); });
            
            var id = <?php echo $userId; ?>;
		</script>

        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-editable.min.js"></script>
        <script type="text/javascript" src="js/moment-with-langs.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <script type="text/javascript" src="js/jquery.isotope.min.js"></script>
        <?php if (isset($custom_class) && $custom_class == 'inscription'): ?>
        <script type="text/javascript" src="js/fb_connect.js"></script>
        <?php endif; ?>

        <script type="text/javascript" src="js/main.js"></script>
    </body>
</html>