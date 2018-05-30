<?php
    /* Template Name: Menu Item Editor */
?>
<?php
// Check if the form was submitted
global $wpdb;
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    // Do some minor form validation to make sure there is content
    
    if (isset ($_POST['item_name'])) { 
        $name =  $_POST['item_name']; 
    } else { 
        echo 'Please enter a menu name </br>';
    }

    $price = "";
    if (isset ($_POST['item_price'])) { 
        $price =  $_POST['item_price']; 
    }

    $comment = "";
    if (isset ($_POST['item_comment'])) { 
        $comment =  $_POST['item_comment']; 
    }

    $item_image = $_FILES["item_image"];
    $upload_overrides = array( 'test_form' => false );

    $move_fle = wp_handle_upload($item_image, $upload_overrides);
    echo "url: " . $move_fle['url'];
    echo "item id:" . $_POST['item_id'];

    if (isset($_POST['item_id'])) {
        echo "update menu";
        $result = $wpdb->update( 
            'menus', 
            array( 
                "name" => $name,
                "price" => $price,
                "comment" => $comment,
                "image" => $move_fle['url']
            ), 
            array('id' => $_POST['item_id']), 
            array( 
                '%s',
                '%f',
                '%s',
                '%s' 
            ), 
            array('%d') 
        );
    } else {
        echo "insert menu";
        if (isset($_POST['res_id'])) { 
            $res_id =  $_POST['res_id']; 
        } else { 
            echo 'No restaurant id </br>';
        }
        $result = $wpdb->insert(
            "menus",
            array(
                "rid" => $res_id,
                "name" => $name,
                "price" => $price,
                "comment" => $comment,
                "image" => $move_fle['url']
            ),
            array(
                '%d',
                '%s',
                '%f',
                '%s',
                '%s'    
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

    $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM menus WHERE id= %d", $_GET['id']));
    echo "id " . $item->id;
    echo "name " . $item->name;
}
?>

<?php get_header() ?>
<div id="container">
<div id="content" role="main">
<?php if (is_user_logged_in()) { ?>
    <!--SUBMIT POST-->
    <form id="edit_post" name="edit_post" class="post_work" method="post" enctype="multipart/form-data">
        <?php if ($item->id == 0) { ?>
        <h1 class="page-title">Add Menu</h1>
        <?php } else { ?>
        <h1 class="page-title">Edit Menu</h1>
        <?php } ?>
            <p><label for="title">Name:</label><br />
                <input type="text" id="title" class="required" 
                    value="<?php echo $item->name; ?>" tabindex="1" size="20" name="item_name" required />
            </p>

            <p><label for="Price">Price:</label><br />
            <input type="text" id="phone" class="required" 
                value="<?php echo $item->price; ?>" tabindex="2" size="20" name="item_price" />
            </p>

            <p><label for="comment">Comment:</label><br />
                <input type="text" id="address" class="required" 
                    value="<?php echo $item->comment; ?>" tabindex="3" size="20" name="item_comment" />
            </p>

            <p><label for="image">Image(Leave empty to not change):</label><br />
                <img src="<?php echo $item->image; ?>" alt="image"> <br />
                <input class="required" name="item_image" type="file" id="image" multiple="false"/>
            </p>
            <?php if (isset($_GET['res_id'])) { ?>
                <input type="hidden" name="res_id" id="res_id" value="<?php echo $_GET['res_id'] ?>" />
            <?php } else { ?>
                <input type="hidden" name="item_id" id="item_id" value="<?php echo $_GET['id'] ?>" />
            <?php } ?>

            <p align="right">
                <input type="submit" value="Modify Funrniture" tabindex="6" id="submit" name="submit" />
            </p>

            <?php wp_nonce_field( 'new-post' ); ?>
    </form>
<!--SUBMIT POST END-->

<?php } else { ?>
<a href="<?php echo wp_login_url(get_permalink()); ?>">Please login to add a new menu item.</a>
<?php } ?></li>
</div><!-- .content -->
</div><!-- #container -->
<?php get_footer(); ?>
