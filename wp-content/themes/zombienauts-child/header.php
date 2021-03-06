<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php bloginfo('name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <link rel="shortcut icon" href="<?php echo get_bloginfo('template_directory'); ?>/cositas/favicon.ico" type="image/x-icon">
    <!-- link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" /> -->
    <!-- FAVICON -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- BOOTSTRAP -->


    <link href="https://fonts.googleapis.com/css?family=Sigmar+One" rel="stylesheet">
    <!-- SIGMAR -->
    <link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One" rel="stylesheet">
    <!-- ALFA SLAB -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory'); ?>/cositas/fuentes/stylesheet-telegram.css"/> 
    <!-- TELEGRAM -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory'); ?>/cositas/fuentes/stylesheet-ipixelu.css"/> 
    <!-- I PIXEL U -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory'); ?>/cositas/fuentes/stylesheet-bebasneue.css"/> 
    <!-- BEBAS NEUE -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_bloginfo('template_directory'); ?>/cositas/fuentes/stylesheet-gt-walsheim.css"/> 
    <!-- GT WALSHEIM -->
    <link href="https://use.fontawesome.com/releases/v5.0.3/css/all.css" rel="stylesheet">
    <!-- FONTAWESOME -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- BOOTSTRAP -->

    <link href="<?php echo get_bloginfo('template_directory'); ?>/css/estilo.css" rel="stylesheet">
    <link href="<?php echo get_bloginfo('template_directory'); ?>/css/animate.css" rel="stylesheet">

<?php wp_head(); ?>
</head>

<body>

<header>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo get_bloginfo( 'wpurl' );?>" id="logo">
                <img src="cositas/img/logoprueba.png" alt="" id="avatar">
                <h1 class="sr-only"><?php echo get_bloginfo( 'name' ); ?></h1>
                <p class="sr-only"><?php echo get_bloginfo( 'description' ); ?></p>
              </a>
            </div>
            
            <div id="navbar" class="navbar-collapse collapse">

                <?php wp_nav_menu( array('menu' => 'Main', 'container' => 'nav' )); ?>

            </div>





        </div>
    </nav>    
</header>