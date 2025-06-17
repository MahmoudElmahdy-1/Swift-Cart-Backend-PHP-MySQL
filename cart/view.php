<?php

include "../connect.php" ;

$usersid = filterRequest("usersid") ;

$datacartview = getAllData("cartview", "cart_usersid = $usersid" , null , false) ;

$stmt = $con->prepare(
    "SELECT SUM(allitemsprice) as totalprice , SUM(allitemscount) as totalitems FROM `cartview`
     WHERE cartview.cart_usersid = $usersid
     GROUP BY cart_usersid") ;
$stmt->execute();

$datatotalitemsandprice = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(array(
    "status" => "success" ,
    "datacart" => $datacartview ,
    "datatotalcountandprice" => $datatotalitemsandprice
  )
) ;

// try {
// } catch (PDOException $e) {
//     echo json_encode([
//         "status" => "failure", 
//         "message" => $e->getMessage()
//     ]);
// }
