<?php

include "connect.php" ;

$usersid = filterRequest("usersid") ;

getAllData("notifications", "notifications_usersid = '$usersid'  ORDER BY notifications_id DESC") ;