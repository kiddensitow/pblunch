<?php get_header(); ?>

<?php
global $wpdb;
$due_time = $wpdb->get_var( "SELECT due_time FROM pb_setting");
$uer_id = get_current_user_id();
$is_new = false;

// check order_date from url
// It is GET method.
if ('GET' == $_SERVER['REQUEST_METHOD']) {
    if (isset($_GET['order_date'])) {
        $order_date = $_GET['order_date'];
    } else {
        $order_date = date("Y-m-d");
    }
}

// New or modify order
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    if (!isset($_POST['order_id'])) {
        $is_new = true;
    }
    var_dump($_POST["items"]);
    $str_items = "{";
    $is_first = true;
    $price = 0;
    foreach ($_POST['items'] as $checked) {
        if ($is_first) {
            $is_first = false;
        } else {
            $str_items = $str_items . ', ';
        }
        $kv_data = split(":", $checked);
        $price =$price + intval($kv_data[1]);
        $str_items = $str_items . '"' . $kv_data[0] . '":' . $kv_data[1];
    }
    $str_items = $str_items . '}';
    echo $str_items;
    echo 'User ID:' . get_current_user_id() . "<br />";

    if ($is_new) {
        echo "<br />insert order";
        $result = $wpdb->insert(
            "orders",
            array(
                "uid" => $uer_id,
                "items" => $str_items,
                "price" => $price,
                "order_date" => $_POST['order_date'],
                "due_date" => $_POST['order_date'] . " " . $due_time,
            ),
            array(
                '%d',
                '%s',
                '%f',
                '%s',
                '%s'    
            )
        );
    } else {
        echo "<br /> update order";
        $result = $wpdb->update( 
            'order', 
            array( 
                "items" => $str_items,
                "price" => $price,
            ), 
            array('id' => $_POST['order_id']), 
            array( 
                '%s',
                '%f'
            ), 
            array('%d') 
        );
    }

    #wp_redirect("/" );
    #exit;
}

// Find order from database
echo "<br />Order SQL: " . $wpdb->prepare(
    "SELECT * FROM orders WHERE uid = %d AND order_date = %s", $uer_id, $order_date);
$order = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM orders WHERE uid = %d AND order_date = %s", $uer_id, $order_date));
if ($order == NULL) {
    // It is new order
    $is_new = true;
} 

echo "<br /> Order: ";
var_dump($order);
echo "<br />";

if ($is_new) {
    $due_date = date("Y-m-d ") . $due_time;
    $now_time = date("Y-m-d H:i:s");
    if (strcmp($due_date, $now_time) < 0) {
        echo "time is due";
        if ($is_new) {
            $order_date = date("Y-m-d", strtotime("tomorrow"));
        }
        echo $order_date;
    } else {
       echo "time is ok";
    }
} else {
    // check due time
    $order_date = $order->order_date;
}
$weekday = date("w",strtotime($order_date));
echo "weekday:". $weekday;
// Get items
$items = $wpdb->get_results("SELECT menus.* FROM menus JOIN restaurants WHERE menus.rid = restaurants.id and restaurants.weekday =" . $weekday);

echo "<br /> due?" . strcmp($item->due_time, $now_time)
?>

<!-- Start Centeral Container Creation A php --> 
<div class="container">
    <div class="row">
    <div class="blog-main">
    
    <!--SUBMIT POST-->
    <form id="edit_post" name="edit_post" class="post_work" method="post" enctype="multipart/form-data">
        <h1 class="page-title">Order</h1>
        <p><label for="title">Date:</label><br />
            <input type="text" id="title" class="required" 
                value="<?php echo $order_date; ?>" tabindex="1" size="20" name="order_date" required />
        </p>
        <?php
            foreach ($items as $item) {
        ?>
        <input type="checkbox" name="items[]" value="<?php echo $item->id .":". $item->price; ?>" />
            <?php echo $item->name . " Price: ". $item->price; ?><img src="<?php echo $item->image; ?>" alt="image"><br />
        <?php } ?>

        <?php if (!$is_new) { ?>
            <input type="hidden" name="order_id" id="order_id" value="<?php echo $order->id ?>" />
        <?php } else { ?>
            <input type="hidden" name="item_id" id="item_id" value="<?php echo $_GET['id'] ?>" />
        <?php } ?>

        <p align="right">
            <?php if ($is_new) {?>
            <input type="submit" value="Order" tabindex="6" id="submit" name="submit" />
            <?php } else if (strcmp($item->due_time, $now_time) > 0) {?>
            <input type="submit" value="Modify" tabindex="6" id="submit" name="submit" />
            <?php }?>
        </p>

        <?php wp_nonce_field( 'new-post' ); ?>
    </form>
<!--SUBMIT POST END-->


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