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
<link href="<?php echo get_bloginfo('template_directory'); ?>/style.css?v=1.2" 
            rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-
            awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link href=https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css rel="stylesheet">
<!-- End Header Creation php -->

</head>
<body>

<!-- Start Logo Creation php -->
<div class="blog-masthead">

    <!--moving login and other buttons start-->
	<div style="float: right; padding-top: 40px; padding-right: 40px;">
	    <nav class="blog-nav">
	        <?php if (is_user_logged_in()) : ?>
		    <li><a href="<?php echo wp_logout_url(get_permalink()); ?>">Logout</a></li>
			<?php else : ?>
		    <li><a href="<?php echo wp_login_url(get_permalink()); ?>">Login</a></li>
			<?php endif;?>
		</nav>
    </div>
	<!--moving login and other buttons end -->

    <div class="logo-div">
    <a href="/wordpress" title="Home" rel="home" id="logo">
        <img src="<?php echo get_bloginfo('template_directory'); ?>/furniture-logo.gif" alt="Home">
    </a>
    </div>
</div>
<!-- End Logo Creation php -->

<!-- Start Bar Creation php --> 
<div class="container">
	<nav class="blog-nav">
	<div style="text-align: left; float: left;">
        <?php wp_list_pages( '&title_li=' ); ?>
  	</div>
	<div style="text-align: right; float: right;">
        <ul></ul>
    </div>
	</nav>
</div>
<!-- End Bar Creation php -->