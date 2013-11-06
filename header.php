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
        <link href='http://fonts.googleapis.com/css?family=Pacifico|Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>css/bootstrap.css" type="text/css" media="screen" />
        <link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>css/bootstrap-editable.css" type="text/css" media="screen" />
        <link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>css/jquery-ui-1.10.3.custom.css" type="text/css" media="screen" />
        <link rel="stylesheet" title="Design" href="<?php echo ROOTPATH; ?>css/style.css" type="text/css" media="screen" />

        <title><?php echo $titre; ?></title>

        

    </head>
    <body class="<?php echo $custom_class ?>">