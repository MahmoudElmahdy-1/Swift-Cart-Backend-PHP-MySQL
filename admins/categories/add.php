<?php

include "../../connect.php";

$nameEn = filterRequest("nameen");
$nameAr = filterRequest("namear");

$imageName = imageUpload("../../upload/categories", "files");

$data = array(
  "categories_name_en" => $nameEn,
  "categories_name_ar" => $nameAr,
  "categories_image" => $imageName
);

insertData("categories", $data);
