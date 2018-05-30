<?php
    /* Template Name: List Menu */
?>
<?php
// Check if the form was submitted
    global $wpdb;
    if ('GET' == $_SERVER['REQUEST_METHOD'] && !empty($_GET['action']) && $_GET['action'] == "delete") {
        $wpdb->delete("menus", array("id"=>$_GET['id']), array("%d"));
    }
?>
<?php get_header(); ?>

<!-- Start Centeral Container Creation A php --> 
<div class="container">
<?php
	if( "yes" == $_GET['added'] ){
        echo "<div class='alert alert-success' >Contact added successfully!</div>";
    }
    echo $_GET['res_id'];
?>
<div class="row">
<div class="blog-main">
<div class="blog-post centerContent">
	<div class="row">
		<h1>Restaurant - List<h1>
		<h4>List of Restaurant<h4>
        <a href="/wordpress/menu-item?res_id=<?php echo $_GET['res_id']; ?>">Add Menu</a>
		<ul>
	        <?php
                global $wpdb;
                $items = $wpdb->get_results("SELECT * FROM menus WHERE rid=" . $_GET['res_id'], OBJECT);
                foreach ($items as $item) {
            ?>
            <li>
                <h4 class="blog-post-title">
                    <?php 
                        echo $item->name . " ";
                        echo $item->price . " ";
                        echo $item->available . " ";
                        echo $item->comment . " ";
                    ?>
                    <br />
                    <img src="<?php echo $item->image; ?>" alt="image">
                </h4>
                <a href="/wordpress/menu-items?action=delete&id=<?php echo $item->id ?>">delete</a>
                <a href="/wordpress/menu-item?id=<?php echo $item->id ?>">Edit</a>
            </li>
            <?php
				}
			?>
		</ul>
		<br>	
	</div>
<!-- End Central Container Creation A php -->
<!-- Start Centeral Container Creation B php --> 

</div>
</div>
</div>
</div>

<!-- End Central Container Creation B php -->
<?php get_footer(); ?>
