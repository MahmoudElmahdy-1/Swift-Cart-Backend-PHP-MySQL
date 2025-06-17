<?php

include "../../connect.php" ;

getAllData("ordersview", "orders_status = 2 ORDER BY orders_id DESC") ;