<?php
    /* Template Name: List Order */
?>
<?php
// Check if the form was submitted
    global $wpdb;
    if ('GET' == $_SERVER['REQUEST_METHOD'] && !empty($_GET['action']) && $_GET['action'] == "delete") {
        $wpdb->delete("orders", array("id"=>$_GET['id']), array("%d"));
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
		<h1>Order - List<h1>
		<h4>List of Orders<h4>
        <a href="/wordpress/">New Order</a>
		<ul>
	        <?php
                global $wpdb;
                $items = $wpdb->get_results("SELECT * FROM orders WHERE uid=" . get_current_user_id(), OBJECT);
                foreach ($items as $item) {
            ?>
            <li>
                <h4 class="blog-post-title">
                    <?php 
                        echo "ID:" . $item->id . " ";
                        echo "Price: " . $item->price . " ";
                        echo "Order data: ". $item->order_date . " ";
                    ?>
                </h4>
                <a href="/wordpress/orders?action=delete&id=<?php echo $item->id ?>">delete</a>
                <a href="/wordpress/?order_date=<?php echo $item->order_date ?>">Edit</a>
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
