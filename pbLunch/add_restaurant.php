<?php
    /* Template Name: Restaurant Creation */
?>
<?php
// Check if the form was submitted
global $wpdb;
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] )) {
    echo "add restaurant post";
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    // Do some minor form validation to make sure there is content
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

    if ($result) {
        echo "Add restaurant successfully";
        $id = $wpdb->insert_id;
       // wp_redirect( get_permalink( $post_id ).'?success=yes' );
    } else {
        echo "Insert fail";
    }
} else {
    echo "add restaurant get";
}
?>
<?php get_header() ?>
<div id="container">
<div id="content" role="main">
<?php if (is_user_logged_in()) { ?>
    <!--SUBMIT POST-->
	<form id="new_post" name="new_post" class="post_work" method="post" enctype="multipart/form-data">
		<h1 class="page-title">Add New Restaurant</h1>
		<p><label for="title">Name:</label><br />
			<input type="text" id="name" class="required" value="" tabindex="1" size="20" name="r_name" />
        </p>
        <p><label for="phone">Phone:</label><br />
			<input type="text" id="phone" class="required" value="" tabindex="1" size="20" name="phone" />
        </p>
        <p><label for="address">Address:</label><br />
			<input type="text" id="address" class="required" value="" tabindex="1" size="20" name="address" />
        </p>
        <p><label for="weekday">weekday:</label><br />
            <select id="weekday" name="weekday">
                <option value="8">none</option>
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wendesday</option>
                <option value="4">Thusday</option>
                <option value="5">Friday</option>
            </select>
        </p>
        <p><label for="comment">commnet:</label><br />
			<input type="text" id="comment" class="required" value="" tabindex="1" size="20" name="comment" />
		</p>
        <input type="hidden" name="post_type" id="post_type" value="domande" />
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
