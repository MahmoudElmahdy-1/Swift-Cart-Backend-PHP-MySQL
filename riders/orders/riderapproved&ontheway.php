<?php

include "../../connect.php" ;

$ordersid = filterRequest("ordersid") ;
$usersid = filterRequest("usersid") ;
$ridersid = filterRequest("ridersid") ;

$data = array(
    "orders_status" => 3 , // switch to On the way
    "orders_rider" => $ridersid  
) ;

$result = updateData("orders" , $data , "orders_id = $ordersid AND orders_status = 2") ;

if ($result > 0) {
    $notifResult = insertNotification(
        "Yaaay!",
        "Your order is on the way",
        "users$usersid",
        "none",
        "refreshPendingOrdersPage",
        $usersid
    );

     $errors = [];

     try {
        sendGCMAdmins("Alert!", "Order has been confirmed by the rider #$ridersid", "admins", "none", "none");
    } catch (Exception $e) {
        $errors[] = "Admin GCM: " . $e->getMessage();
    }

    try {
        sendGCMRiders("Alert!", "Order has been confirmed by the rider #$ridersid", "riders", "none", "none");
    } catch (Exception $e) {
        $errors[] = "Rider GCM: " . $e->getMessage();
    }

       if (!empty($errors)) {
        error_log(implode("\n", $errors));
    }

} else {
    echo json_encode(["status" => "failure", "message" => "Order was already confirmed or does not exist"]);
}
