<?php

include "../connect.php" ;

$usersid = filterRequest("usersid") ;
$categoryid = filterRequest("categoryid") ;

$stmt = $con->prepare(
"SELECT itemsview.* , 1 as favorite , (items_price - (items_price * items_discount / 100)) as priceafterdiscount FROM itemsview
INNER JOIN favorite ON favorite.favorite_itemsid = itemsview.items_id AND favorite.favorite_usersid= $usersid
WHERE categories_id = $categoryid
UNION ALL
SELECT * , 0 as favorite , (items_price - (items_price * items_discount / 100)) as priceafterdiscount FROM itemsview
WHERE categories_id = $categoryid AND items_id NOT IN (SELECT itemsview.items_id FROM itemsview
INNER JOIN favorite ON favorite.favorite_itemsid = itemsview.items_id AND favorite.favorite_usersid = $usersid)"
) ;

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count  = $stmt->rowCount();

if($count > 0){
    echo json_encode(array("status" => "success", "data" => $data));
}else{
    echo json_encode(array("status" => "failure"));
}


