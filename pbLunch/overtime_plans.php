<?php
    /* Template Name: List Overtime */
?>
<?php
// Check if the form was submitted
global $wpdb;
if ('GET' == $_SERVER['REQUEST_METHOD'] && !empty($_GET['action']) && $_GET['action'] == "delete") {
    $wpdb->delete("ot_plans", array("id"=>$_GET['id']), array("%d"));
}

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    echo "<br />insert menu";
    // check restaurant id
    if (isset($_POST['res_id'])) { 
        $res_id =  $_POST['res_id']; 
    } else { 
        echo '<br /> No restaurant id';
        exit;
    }

    // check plan date
    if (isset($_POST['ot_date'])) { 
        $ot_date =  $_POST['ot_date']; 
    } else { 
        echo '<br /> No Overtime date';
        exit;
    }

    $result = $wpdb->insert(
        "ot_plans",
        array(
            "rid" => $res_id,
            "ot_date" => $ot_date,
        ),
        array(
            '%d',
            '%s'   
        )
    );

    if (!$result) {
        echo "<br /> Add plan fail!";
    }

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
        
        <!--SUBMIT POST-->
        <form id="edit_post" name="edit_post" class="post_work" method="post" enctype="multipart/form-data">
            <p><label for="title">Date:</label><br />
                <input type="text" id="title" class="required" 
                    value="" tabindex="1" size="20" name="ot_date" required />
            </p>

            <p><label for="weekday">restaurants:</label><br />
                <select id="weekday" name="res_id">
                    <?php 
                    $items = $wpdb->get_results("SELECT * FROM restaurants", OBJECT);
                    foreach ($items as $item) {
                    ?>
                    <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?>                                    </option>
                    <?php } ?>
                </select>
            </p>

            <p align="right">
                <input type="submit" value="Add Plan" tabindex="6" id="submit" name="submit" />
            </p>

            <?php wp_nonce_field( 'new-post' ); ?>
        </form>
        <!--SUBMIT POST END-->

		<ul>
	        <?php
                $plans = $wpdb->get_results("SELECT A.id as id,  A.ot_date as ot_date, B.name as name FROM ot_plans as A, restaurants as B WHERE A.rid = B.id", OBJECT);
                foreach ($plans as $plan) {
            ?>
            <li>
                <h4 class="blog-post-title">
                    <?php 
                        echo "Date:" . $plan->ot_date . " ";
                        echo "restaurant:".$plan->name . " ";
                    ?>
                </h4>
                <a href="/wordpress/overtime-plans?action=delete&id=<?php echo $plan->id ?>">delete</a>
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
