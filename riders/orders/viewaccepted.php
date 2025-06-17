<?php

include "../../connect.php" ;

$ridersid = filterRequest("ridersid") ;

getAllData("ordersview", "orders_status = 3 AND orders_rider = '$ridersid' ORDER BY orders_id DESC") ;