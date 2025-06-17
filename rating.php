<?php

include "connect.php" ;

$ordersid = filterRequest("ordersid") ;
$rating = filterRequest("rating") ;
$commentrating = filterRequest("commentrating") ;

$data = array(
    "orders_rating" => $rating,
    "orders_commentrating" => $commentrating,
) ;

updateData("orders", $data, "orders_id = $ordersid");

