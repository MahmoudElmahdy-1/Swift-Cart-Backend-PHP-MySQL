<?php

include "../../connect.php" ;

$ordersid = filterRequest("ordersid") ;
$usersid = filterRequest("usersid") ;

$data = array(
    "orders_status" => 1 // switch to preparing order
) ;

$result = updateData("orders" , $data , "orders_id = $ordersid AND orders_status = 0") ;

if ($result > 0) {
    insertNotification(
        "Yaaay!",
        "Your order has been confirmed successfully and is now being prepared",
        "users$usersid",
        "none",
        "refreshPendingOrdersPage",
        $usersid
    ); // send to users
} else {
    echo json_encode(["status" => "failure", "message" => "Order was already confirmed or does not exist"]);
}