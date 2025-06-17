<?php

include "../connect.php" ;

$search = filterRequest("search") ;

// getAllData( "itemsview" , " items_name_en LIKE '%$search%' OR items_name_ar LIKE '%$search%' ") ;

$stmt = $con->prepare("
  SELECT *, (items_price - (items_price * items_discount / 100)) as priceafterdiscount 
  FROM itemsview 
  WHERE items_name_en LIKE '%$search%' OR items_name_ar LIKE '%$search%'
");

$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count  = $stmt->rowCount();

if($count > 0){
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "failure"));
}
?>
