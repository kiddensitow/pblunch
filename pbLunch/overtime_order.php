<?php
    /* Template Name: Overtime Order */
?>
<?php get_header(); ?>

<?php
global $wpdb;
$due_time = $wpdb->get_var( "SELECT due_time FROM pb_setting");
$user_id = get_current_user_id();
$is_new = false;
// Show Order information or Show clear form
if ('GET' == $_SERVER['REQUEST_METHOD']) {
    $query_date = date("Y-m-d");
    if (isset($_GET['plan_date'])) {
        $query_date = $_GET['plan_date'];
    }

    //Check query available
    $query_time = $query_date . date(" H:i:s");
    $due_date = date("Y-m-d ") . $due_time;
    if (strcmp($due_time, $query_time) < 0) {
        echo "<br />It's later, it is out of due time.";
        exit;
    }

    // Check order exist.
    $str_sql = $wpdb->prepare("SELECT * FROM ot_orders WHERE ot_date = %s AND uid=%d", $query_date, $user_id);
    echo "<br />query order sql: " . $str_sql;
    $order = $wpdb->get_row($str_sql);
    echo "<br />order :";
    var_dump($order);
    if ($order == NULL) {
        echo "<br /> no order, will create a new recorder";
        $is_new = true;
    }

    // Get menus
    $str_sql = $wpdb->prepare("SELECT C.* FROM ot_plans as A, restaurants as B, menus as C WHERE A.ot_date = %s AND A.rid = B.id AND B.id = C.rid", $query_date);
    echo "<br />query menus sql: " . $str_sql;
    $items = $wpdb->get_results($str_sql, OBJECT);
    echo "<br />plan :";
    var_dump($items);
    if ($items == NULL) {
        echo "<br /> " . $query_date . " don't have overtime plan.";
        exit;
    }
}

// New or modify order
if ('POST' == $_SERVER['REQUEST_METHOD']) {
    if (!isset($_POST['order_id'])) {
        $is_new = true;
    }
    echo "<br /> items: ";
    var_dump($_POST["items"]);

    // Check orderdate is due time
    // TODO:

    // Create menu items to json string.
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
    echo "<br /> selected menus:" . $str_items;

    if ($is_new) {
        echo "<br />insert overtime order";
        $result = $wpdb->insert(
            "ot_orders",
            array(
                "uid" => $user_id,
                "ot_date" => $_POST['order_date'],
                "items" => $str_items,
                "price" => $price,
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%f'  
            )
        );
        if (!$result) echo "<br /> Insert fail";
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
?>

<!-- Start Centeral Container Creation A php --> 
<div class="container">
    <div class="row">
    <div class="blog-main">
    
    <!--SUBMIT POST-->
    <form id="edit_post" name="edit_post" class="post_work" method="post" enctype="multipart/form-data">
        <h1 class="page-title">Overtime Order</h1>
        <p><label for="title">Order Date:</label><br />
            <input type="text" id="title" class="required" 
                value="<?php echo $query_date; ?>" 
                tabindex="1" size="20" name="order_date" required disable />
        </p>
        <h2>Menus</h2>
        <?php
            foreach ($items as $item) {
        ?>
        <input type="checkbox" name="items[]" value="<?php echo $item->id .":". $item->price; ?>" />
            <?php echo $item->name . " Price: ". $item->price; ?><img src="<?php echo $item->image; ?>" alt="image"><br />
        <?php } ?>

        <?php if (!$is_new) { ?>
            <input type="hidden" name="order_id" id="order_id" value="<?php echo $order->id ?>" />
        <?php } else { ?>
            <input type="hidden" name="res_id" id="res_id" value="<?php echo $_GET['id'] ?>" />
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
<!-- End Central Container Creation A php -->

<!-- Start Centeral Container Creation B php --> 
</div>
</div>
</div>
</div>
</div>
<!-- End Central Container Creation B php -->

<?php get_footer(); ?>