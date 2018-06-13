<?php
    /* Template Name: Top Up */
?>
<?php get_header(); ?>

<?php
global $wpdb; 
$user_id = get_current_user_id();
$isExisting = false;


if ('POST' == $_SERVER['REQUEST_METHOD']) {
    if($_POST["amount"] >= 20){


        
        $isExisting = $wpdb->get_results( "SELECT * FROM top_up_record WHERE user_id = ".$user_id." AND status = 0");


 

        if(!$isExisting){

            $result = $wpdb->insert(
                "top_up_record",
                array(
                    "amount" => $_POST["amount"],
                    "date" =>date("d/m/Y H:i:s"),
                    "user_id" => $user_id,
                    "status" => 0
                ),
                array(
                    '%d',
                    '%s',
                    '%d',
                    '%d'
                )
            );
            $balance = floatval(get_user_meta( $user_id, "balance", true )); 

            $total = $balance + floatval($_POST["amount"]);

            update_user_meta( $user_id, "balance", $total);
        }
        else{
            //echo "<a href='#'' class='text-warning'>There is a pending top up. Please contact administrator!</a>";
        }

        
    }
    
}

if(isset($_GET["id"])){
    $amountArray = $wpdb->get_results( "SELECT amount FROM top_up_record WHERE user_id = ".$user_id." AND status = 0", ARRAY_A);
    foreach ($amountArray as $amountItem) {
        $amount = floatval($amountItem["amount"]);
    }
    

    $balance = floatval(get_user_meta( $user_id, "balance", true ));  

    $undoamount = $balance - $amount;

    update_user_meta( $user_id, "balance", $undoamount);

    $wpdb->delete(
        "top_up_record",
        array( 
            'id' => $_GET["id"] 
        )
    );

    
    header("Location: /wordpress/top-up");
    die();
}


?>

<div class="container">
    <h2>Top up records</h2>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
            $results = $wpdb->get_results( "SELECT * FROM top_up_record WHERE user_id = ".$user_id."", ARRAY_A);
            foreach ($results as $result) {
                $id = $result["id"];
                $amount = $result["amount"];
                $date = date("d/m/Y H:i:s",mktime($result["date"]));
                $status = $result["status"];
                $statusstring = $result["status"]==0?"Pending":"Charged";
                ?>
                    <tr>
                        <td><?=$date?></td>
                        <td>$<?=$amount?></td>
                        <td><?=$statusstring?></td>
                        <?php
                            if($status == 0){
                                echo "<td  align ='center'><a class='btn btn-warning btn-xs' href='/wordpress/top-up?id=".$id."'>DELETE</a></td>";
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

    <div class="panel panel-primary">
        <div class="panel-heading"><h4>Top UP</h4></div>
        <div class="panel-body">

            <form action="" class="form-inline" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <h4>Balance: 
                    <?php
                        echo "<span>$".get_user_meta($user_id, "balance", true)."</span>";
                    ?>
                    </h4>
                </div>
                <p></p>
                <div class="form-group">
                    <label for="">Top up amount:</label>
                    <input type="number" name="amount" class="form-control">
                    <?php
                        if(isset($_POST["amount"]) && ($_POST["amount"] < 20)){
                            echo "<span class='label label-warning' style='font-size: 11pt'>Top up amount has to be more than $20.</span>";
                        }
                        else if($isExisting){
                            echo "<span class='label label-warning' style='font-size: 11pt'>There is a pending top up. Please contact administrator!</span>";
                        }
                    ?>
                </div>

                <p>
                    <br>
                    <input type="submit" value="Submit" class="btn btn-primary btn-md">
                </p>
                
            </form>
        </div>
    </div>
</div>

<?php get_footer(); ?>