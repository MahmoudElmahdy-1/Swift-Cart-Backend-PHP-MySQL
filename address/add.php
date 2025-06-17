<?php

include "../connect.php" ;

$usersid   = filterRequest("usersid") ;
$name      = filterRequest("name") ;
$city      = filterRequest("city") ;
$street    = filterRequest("street") ;
$building  = filterRequest("building") ;
$optional  = filterRequest("optional") ;
$latitude  = filterRequest("latitude") ;
$longitude = filterRequest("longitude") ;


$data = array(
    "address_usersid"   => $usersid ,
    "address_name"      => $name ,
    "address_city"      => $city ,
    "address_street"    => $street ,
    "address_building"  => $building ,
    "address_optional"  => $optional ,
    "address_latitude"  => $latitude ,
    "address_longitude" => $longitude ,
);

insertData("address", $data) ;

