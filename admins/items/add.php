<?php

include "../../connect.php";

$nameEn     = filterRequest("nameen");
$nameAr     = filterRequest("namear");
$descEn     = filterRequest("descen");
$descAr     = filterRequest("descar");
$quantity   = filterRequest("quantity");
$price      = filterRequest("price");
$discount   = filterRequest("discount");
$datetime   = filterRequest("datetime");
$categoryId = filterRequest("categoryid");

$imageName = imageUpload("../../upload/items", "files");

$data = array(
  "items_name_en"        => $nameEn,
  "items_name_ar"        => $nameAr,
  "items_description_en" => $descEn ,
  "items_description_ar" => $descAr ,
  "items_quantity"       => $quantity,
  "items_active"         => "1",
  "items_price"          => $price,
  "items_discount"       => $discount,
  "items_datetime"       => $datetime,
  "items_categories"    => $categoryId,
  "items_image"          => $imageName
);

insertData("items", $data);
