<?php

include "../connect.php" ;

$addressid = filterRequest("addressid") ;
$name      = filterRequest("name") ;
$city      = filterRequest("city") ;
$street    = filterRequest("street") ;
$building  = filterRequest("building") ;
$optional  = filterRequest("optional") ;
$latitude  = filterRequest("latitude") ;
$longitude = filterRequest("longitude") ;

$data = array(
    "address_name"      => $name ,
    "address_city"      => $city ,
    "address_street"    => $street ,
    "address_building"  => $building ,
    "address_optional"  => $optional ,
    "address_latitude"  => $latitude ,
    "address_longitude" => $longitude ,
) ;

updateData("address" , $data , "address_id = $addressid") ;