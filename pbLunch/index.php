<?php get_header(); ?>

<!-- Start Centeral Container Creation A php --> 
<div class="container">
    <div class="row">
    <div class=" blog-main">
    <div class="blog-post centerContent">
	    <h2 class="blog-post-title"><?php the_title(); ?></h2>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; endif; ?>
        <?php 
            global $wpdb;
            $myrows = $wpdb->get_results("SELECT * FROM restaurants", OBJECT);

            echo $myrows[0]->id;
            foreach ($myrows as $row) { echo $row->name; echo "</ br>"; }
        ?>
<!-- End Central Container Creation A php -->

<!-- Start Centeral Container Creation B php --> 
</div>
</div>
</div>
</div>
</div>
<!-- End Central Container Creation B php -->

<?php get_footer(); ?>