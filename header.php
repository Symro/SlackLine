<!DOCTYPE html> 
<html xmlns:fb="https://www.facebook.com/2008/fbml">
    <head>
	    <?php
	    /**********Vérification du titre + class *************/
	     
	    if(isset($titre) && trim($titre) != ''):
	    	$titre = $titre.' : '.TITRESITE;
	    else:
	    	$titre = TITRESITE;
		endif;

		if(!isset($custom_class) || empty($custom_class)):
	    	$custom_class = CLASSPAGE;
		endif;
	     
	    /***********Fin vérification titre + class ************/
	    ?>
        

        <meta name="language" content="fr" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Parislack vous permet de trouver les meilleurs endroits pour pratiquer la slackline dans Paris, et d’organiser des rendez-vous avec les slackers." />
        
        <meta property="og:title" content="Parislack" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://prod.florent-grandval.fr/Slackline/" />
		<meta property="og:image" content="http://prod.florent-grandval.fr/Slackline/img/favicon.png"/>
		<meta property="og:site_name" content="Parislack" />
		<meta property="og:description" content="Parislack vous permet de trouver les meilleurs endroits pour pratiquer la slackline dans Paris, et d’organiser des rendez-vous avec les slackers." />

        <link rel="icon" type="image/png" href="img/favicon.png" />
    	<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" /><![endif]-->

        <link href='http://fonts.googleapis.com/css?family=Pacifico|Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>css/bootstrap.css" type="text/css" media="screen" />
        <link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>css/bootstrap-editable.css" type="text/css" media="screen" />
        <link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>css/jquery-ui-1.10.3.custom.css" type="text/css" media="screen" />
		<?php if(isset($custom_class) && $custom_class == 'home'): ?>
        <link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>css/bootstrap-responsive.min.css" type="text/css" media="screen" />
        <link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>css/style_home.css" type="text/css" media="screen" />
    	<?php else: ?>
    	<link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>css/jquery.mCustomScrollbar.css" type="text/css" media="screen" />
		<link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>css/style.css" type="text/css" media="screen" />
		<?php endif; ?>
        

        <title><?php echo $titre; ?></title>

        

    </head>
    <body class="<?php echo $custom_class ?>">