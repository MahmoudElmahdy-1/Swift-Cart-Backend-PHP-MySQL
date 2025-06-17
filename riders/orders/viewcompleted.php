<?php

include "../../connect.php" ;

$ridersid = filterRequest("ridersid") ;

getAllData("ordersview", "orders_rider = '$ridersid' AND orders_status = 4 ORDER BY orders_id DESC") ;