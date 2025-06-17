<?php

include "connect.php" ;

$alldata = array() ;

$alldata['status'] = "success" ;

$categories = getAllData("categories", null, null, false) ;
$alldata['categories'] = $categories ;

$itemsdiscount = getAllData("itemsview", "items_discount != 0", null, false) ;
$alldata['itemsdiscount'] = $itemsdiscount ;

$items = getAllData("topsellingview", "1 = 1 ORDER BY countitems DESC", null, false) ;
$alldata['items'] = $items ;

echo json_encode($alldata) ;

?>