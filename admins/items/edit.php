<?php

include "../../connect.php";

$itemsId = filterRequest("itemsid");
$nameEn = filterRequest("nameen");
$nameAr = filterRequest("namear");
$descEn = filterRequest("descen");
$descAr = filterRequest("descar");
$quantity = filterRequest("quantity");
$active = filterRequest("active");
$price = filterRequest("price");
$discount = filterRequest("discount");
$categoryId = filterRequest("categoryid");

$oldImage = filterRequest("oldimage");
$newImage = imageUpload("../../upload/items", "files");

if ($newImage == "empty") {
  $data = array(
  "items_name_en" => $nameEn,
  "items_name_ar" => $nameAr,
  "items_description_en" => $descEn ,
  "items_description_ar" => $descAr ,
  "items_quantity" => $quantity,
  "items_active" => $active,
  "items_price" => $price,
  "items_discount" => $discount,
  "items_categories" => $categoryId,
  );
} else {
  deleteFile("../../upload/items", $oldImage);
  $data = array(
  "items_name_en" => $nameEn,
  "items_name_ar" => $nameAr,
  "items_description_en" => $descEn ,
  "items_description_ar" => $descAr ,
  "items_quantity" => $quantity,
  "items_active" => $active,
  "items_price" => $price,
  "items_discount" => $discount,
  "items_categories" => $categoryId,
  "items_image" => $newImage
  );
}

updateData("items", $data, "items_id = $itemsId");
