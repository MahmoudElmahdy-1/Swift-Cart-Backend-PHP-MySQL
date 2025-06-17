<?php

include "../connect.php" ;

$usersid = filterRequest("usersid") ;

getAllData("favoritesview", "favorite_usersid = $usersid") ;

