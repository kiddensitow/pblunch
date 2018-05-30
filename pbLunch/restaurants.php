<?php
    /* Template Name: List Restaurants */
?>
<?php
// Check if the form was submitted
    global $wpdb;
    if ('GET' == $_SERVER['REQUEST_METHOD'] && !empty($_GET['action']) && $_GET['action'] == "delete") {
        $wpdb->delete("restaurants", array("id"=>$_GET['id']), array("%d"));
    }
?>
<?php get_header(); ?>

<!-- Start Centeral Container Creation A php --> 
<div class="container">
<?php
	if( "yes" == $_GET['added'] ){
        echo "<div class='alert alert-success' >Contact added successfully!</div>";
    }
?>
<div class="row">
<div class="blog-main">
<div class="blog-post centerContent">
	<div class="row">
		<h1>Restaurant - List<h1>
		<h4>List of Restaurant<h4>
		<ul>
	        <?php
                global $wpdb;
                $restaurants = $wpdb->get_results("SELECT * FROM restaurants", OBJECT);
                foreach ($restaurants as $restaurant) {
            ?>
            <li>
                <h4 class="blog-post-title">
                    <?php 
                        echo $restaurant->name . " ";
                        echo $restaurant->phone . " ";
                        echo $restaurant->address . " ";
                        echo $restaurant->weekday . " ";
                        echo $restaurant->comment . " ";
                    ?>
                </h4>
                <a href="/wordpress/restaurants?action=delete&id=<?php echo $restaurant->id ?>">delete</a>
                <a href="/wordpress/restaurant?id=<?php echo $restaurant->id ?>">Edit</a>
            </li>
            <?php
				}
			?>
		</ul>
		<br>
        <a href="/wordpress/add-restaurant"> Add Restaurant</a>		
	</div>
<!-- End Central Container Creation A php -->
<!-- Start Centeral Container Creation B php --> 

</div>
</div>
</div>
</div>

<!-- End Central Container Creation B php -->
<?php get_footer(); ?>
