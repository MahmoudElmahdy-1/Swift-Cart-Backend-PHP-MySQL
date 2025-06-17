<?php

include "../../connect.php" ;

$ordersid = filterRequest("ordersid") ;
$usersid = filterRequest("usersid") ;

$data = array(
    "orders_status" => 4 // switch to completed
) ;

$result = updateData("orders" , $data , "orders_id = $ordersid AND orders_status = 3") ;

if ($result > 0) {
    insertNotification(
        "Yaaay!",
        "Your order is Delivered Successfully",
        "users$usersid",
        "none",
        "refreshPendingOrdersPage",
        $usersid
    ); // send to users
    sendGCM("Alert!", "Order has been Delivered Successfully", "admins", "none", "none"); // send to the admin
} else {
    echo json_encode(["status" => "failure", "message" => "Order was already confirmed or does not exist"]);
}