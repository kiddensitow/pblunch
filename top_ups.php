<?php
    /* Template Name: Top Up List */
?>
<?php get_header(); ?>

<?php
global $wpdb;
$user_id = get_current_user_id();


if(isset($_GET["id"])){   
    $wpdb->update( 
            "top_up_record", 
            array( 
                "status" => 1,
                "approved_by" => $user_id
            ), 
            array('id' => $_GET["id"]),
            array( 
                '%d',
                '%d' 
            ), 
            array('%d') 
        );
    $set_url = "Location: /wordpress/top-up-list";
    if (isset($_GET["view"])){
        $set_url .= "?view=all";
    }
    header($set_url);
    die();
}
?>

<div class="container">
    <h2>Top up records</h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th>User</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Authorised by</th>
            <th align ="center">Action</th>
        </tr>
        <?php
            $sql_str = "SELECT * FROM top_up_record";
            if(!isset($_GET["view"])){
                $sql_str .= " WHERE status = 0";
            }
            $sql_str .= " ORDER BY date DESC";
            $results = $wpdb->get_results($sql_str, ARRAY_A);
            foreach ($results as $result) {
                $this_user_id = intval($result["user_id"]);
                $user_info = get_userdata($this_user_id);
                $admin_info = get_userdata($user_id);
                $id = $result["id"];
                $amount = $result["amount"];
                $date = date("d/m/Y H:i:s",mktime($result["date"]));
                $status = $result["status"];
                $statusstring = $result["status"]==0?"Pending":"Charged";
                //$balance = floatval(get_user_meta( $this_user_id, "balance", true )); 
                ?>
                    <tr>
                        <td><?=$user_info->user_nicename?></td>
                        <td><?=$date?></td>
                        <td><?=$amount?></td>
                        <td><?=$statusstring?></td>
                        <td><?=$user_info->user_nicename?></td>
                        <?php
                            $redirect_url = "/wordpress/top-up-list?";
                            if($status == 0){
                                if(isset($_GET["view"])){
                                $redirect_url .= "view=all&";
                                }

                                echo "<td  align ='center'><a class='btn btn-warning btn-xs' href='".$redirect_url."id=".$id."'>APPROVE</a></td>";
                            }
                            else{
                                echo "<td><a></a></td>";
                            }
                        ?>
                    </tr>
                <?php
            }
        ?>
    </table>
        <p>
            <a href="href=/wordpress/top-up-list" class="btn btn-primary">View Pending</a>
            <a href="href=/wordpress/top-up-list?view=all" class="btn btn-primary">View All</a>
        </p>
</div>


<?php get_footer(); ?>