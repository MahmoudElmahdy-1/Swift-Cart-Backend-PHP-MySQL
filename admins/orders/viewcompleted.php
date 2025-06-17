<?php

include "../../connect.php" ;

getAllData("ordersview", "orders_status = 4 ORDER BY orders_id DESC") ;