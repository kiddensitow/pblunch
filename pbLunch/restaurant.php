<?php
    /* Template Name: Restaurant Editor */
?>
<?php
// Check if the form was submitted
global $wpdb;
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] )) {
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    // Do some minor form validation to make sure there is content
    if (isset ($_POST['res_id'])) { 
        $res_id =  $_POST['res_id']; 
    }

    if (isset ($_POST['r_name'])) { 
        $name =  $_POST['r_name']; 
    } else { 
        echo 'Please enter a restaurant name </br>';
    }

    $phone = "";
    if (isset ($_POST['phone'])) { 
        $phone =  $_POST['phone']; 
    }

    $address = "";
    if (isset ($_POST['address'])) { 
        $address =  $_POST['address']; 
    }

    $comment = "";
    if (isset ($_POST['remark'])) { 
        $comment =  $_POST['remark']; 
    }

    $weekday = 8;
    if (isset($_POST['weekday'])) {
        $weekday = $_POST['weekday'];
        if ($weekday != 8) {
            $day_count = $wpdb->get_var( "SELECT COUNT(*) FROM restaurants WHERE 'weekday' ". $weekday);
            if ($day_count != 0) {
                echo "the weekday already has a restaurant.";
            }
        }
    } else {
        echo 'Please enter a weekday </br>';
    }

    if ($res_id != 0) {
        $result = $wpdb->update( 
            'restaurants', 
            array( 
                "name" => $name,
                "phone" => $phone,
                "address" => $address,
                "comment" => $comment,
                "weekday" => $weekday 
            ), 
            array('id' => $res_id), 
            array( 
                '%s',
                '%s',
                '%s',
                '%s',
                '%d' 
            ), 
            array('%d') 
        );
    } else {
        $result = $wpdb->insert(
            "restaurants",
            array(
                "name" => $name,
                "phone" => $phone,
                "address" => $address,
                "comment" => $comment,
                "weekday" => $weekday
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%d'    
            )
        );
    }

    if ($result) {
        $id = $wpdb->insert_id;
       // wp_redirect( get_permalink( $post_id ).'?success=yes' );
    } else {
        echo "Insert fail";
    }
} 

if ('GET' == $_SERVER['REQUEST_METHOD'] && !empty( $_GET['id'])) {
    echo "get id:" . $_GET['id'];

    $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM restaurants WHERE id= %d", $_GET['id']));
    echo "id " . $item->id;
    echo "name " . $item->name;
}
?>

<?php get_header() ?>
<div id="container">
<div id="content" role="main">
<?php if (is_user_logged_in()) { ?>
    <a href="/wordpress/menu-items?res_id=<?php echo $item->id ?>">Add Menu</a>
    <!--SUBMIT POST-->
    <form id="new_post" name="new_post" class="post_work" method="post" enctype="multipart/form-data">
        <?php if ($item->id == 0) { ?>
        <h1 class="page-title">Add New Restaurant</h1>
        <?php } else { ?>
        <h1 class="page-title">Edit Restaurant</h1>    
        <?php } ?>
		<p><label for="title">Name:</label><br />
            <input type="text" id="name" class="required" 
                value="<?php echo $item->name ?>" tabindex="1" size="20" name="r_name"/>
        </p>
        <p><label for="phone">Phone:</label><br />
            <input type="text" id="phone" class="required" 
                value="<?php echo $item->phone ?>" tabindex="2" size="20" name="phone" />
        </p>
        <p><label for="address">Address:</label><br />
            <input type="text" id="address" class="required" 
                value="<?php echo $item->address ?>" tabindex="3" size="20" name="address" />
        </p>
        <p><label for="weekday">weekday:</label><br />
            <select id="weekday" name="weekday">
                <option value="8" <?php if ($item->weekday == 8) { echo "selected"; } ?>>none</option>
                <option value="1" <?php if ($item->weekday == 1) { echo "selected"; } ?>>Monday</option>
                <option value="2" <?php if ($item->weekday == 2) { echo "selected"; } ?>>Tuesday</option>
                <option value="3" <?php if ($item->weekday == 3) { echo "selected"; } ?>>Wendesday</option>
                <option value="4" <?php if ($item->weekday == 4) { echo "selected"; } ?>>Thusday</option>
                <option value="5" <?php if ($item->weekday == 5) { echo "selected"; } ?>>Friday</option>
            </select>
        </p>
        <p><label for="comment">commnet:</label><br />
            <input type="text" id="comment" class="required" 
                value=""<?php echo $item->comment ?>"" tabindex="1" size="20" name="remark" />
		</p>
        <input type="hidden" name="res_id" id="res_id" value="<?php echo $item->id ?>" />
        <input type="hidden" name="action" value="post" />
        <p align="right"><input type="submit" value="Submit" tabindex="6" id="submit" name="submit" /></p>
        <?php wp_nonce_field( 'new-post' ); ?>
    </form>
<!--SUBMIT POST END-->

 <?php } else { ?>
<a href="<?php echo wp_login_url(get_permalink()); ?>">Please login to add a new furniture.</a>
<?php } ?></li>
</div><!-- .content -->
</div><!-- #container -->
<?php get_footer(); ?>
