<?php

include "../connect.php" ;

$usersid = filterRequest("usersid") ;

getAllData("ordersview", "orders_usersid = '$usersid' AND orders_status = 4 ORDER BY orders_id DESC") ;