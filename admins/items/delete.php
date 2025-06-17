<?php

include "../../connect.php";

$itemsId = filterRequest("itemsid");
$imageName = filterRequest("imagename");

deleteFile("../../upload/items", $imageName);

deleteData("items", "items_id = $itemsId");
