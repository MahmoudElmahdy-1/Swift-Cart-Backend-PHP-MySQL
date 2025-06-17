<?php

include "../../connect.php";

$categoryId = filterRequest("categoryid");
$imageName = filterRequest("imagename");

deleteFile("../../upload/categories", $imageName);

deleteData("categories", "categories_id = $categoryId");
