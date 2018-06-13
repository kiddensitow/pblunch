<!doctype html>
<html>
<head>
<!-- Start Header Creation php--> 
<meta charset="utf ompatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; 
    any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<title>Blog Template for Bootstrap</title>
<!-- Custom styles for this template -->
<link href="<?php echo get_bloginfo('template_directory'); ?>/style.css?v=1.2" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-
            awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<!-- End Header Creation php -->
</head>
<body>

<!-- Start Logo Creation php -->
<div class="blog-masthead">

    <!--moving login and other buttons start-->
	<div style="float: right; padding-top: 40px; padding-right: 40px;">
	    <nav class="blog-nav">
	            <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span>Sign Up</a></li>
            <?php if (is_user_logged_in()) : ?>
                <li><a href="<?php echo wp_logout_url(get_permalink()); ?>"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
            <?php else : ?>
                <li><a href="<?php echo wp_login_url(get_permalink()); ?>"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
            <?php endif;?>
    </ul>
		</nav>
    </div>
	<!--moving login and other buttons end -->
</div>
<!-- End Logo Creation php -->
<div class="navbar navbar-inverse navbar-static-top">
    <div class = "container">
        <a href = "/wordpress" class = "navbar-brand">
            <img src="<?php echo get_bloginfo('template_directory'); ?>/pb-logo2.gif" width="78" height="25" alt="PBLunch">
        </a>
        <button class = "navbar-toggle" data-toggle = "collapse" data-target ="#navHeaderCollapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
            <?php
        wp_nav_menu( array(
            'theme_location'    => 'primary',
            'depth'             => 2,
            'container'         => 'div',
            'container_class'   => 'collapse navbar-collapse',
            'container_id'      => 'navHeaderCollapse',
            'menu_class'        => 'nav navbar-nav nav-pills',
            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
            'walker'            => new WP_Bootstrap_Navwalker(),
        ) );
        ?>
    </div>
</div>
<!-- End Bar Creation php -->
