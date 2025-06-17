<?php

include "../../connect.php";

$nameEn = filterRequest("nameen");
$nameAr = filterRequest("namear");
$categoryId = filterRequest("categoryid");
$oldImage = filterRequest("oldimage");


$newImage = imageUpload("../../upload/categories", "files");

if ($newImage == "empty") {
  $data = array(
    "categories_name_en" => $nameEn,
    "categories_name_ar" => $nameAr,
  );
} else {
  deleteFile("../../upload/categories", $oldImage);
  $data = array(
    "categories_name_en" => $nameEn,
    "categories_name_ar" => $nameAr,
    "categories_image" => $newImage
  );
}

updateData("categories", $data, "categories_id = $categoryId");
