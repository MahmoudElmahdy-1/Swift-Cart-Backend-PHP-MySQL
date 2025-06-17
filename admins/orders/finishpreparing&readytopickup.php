<?php

include "../../connect.php" ;

$ordersid = filterRequest("ordersid") ;
$usersid = filterRequest("usersid") ;
$deliverytype = filterRequest("deliverytype") ;

if($deliverytype == "0"){
    $data = array(
        "orders_status" => 2 // switch to ready to pick up
    ) ;
}else {
    $data = array(
        "orders_status" => 4 // switch to completed
    ) ;
}

$result = updateData("orders" , $data , "orders_id = $ordersid AND orders_status = 1") ;

if ($result > 0) {
    insertNotification(
        "Yaaay!",
        "Order is ready to pick up",
        "users$usersid",
        "none",
        "refreshPendingOrdersPage",
        $usersid
    ); // send to users
    if($deliverytype == "0"){
        sendGCMRiders("Alert!", "There is an order waiting", "riders", "none", "none"); // send to the riders
    }
} else {
    echo json_encode(["status" => "failure", "message" => "Order was already confirmed or does not exist"]);
}