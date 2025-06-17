<?php

include "../../connect.php";

// Upload images
$imageNameEn = imageUpload("../../upload/offers", "filesen");
$imageNameAr = imageUpload("../../upload/offers", "filesar");

// Check for upload failures
if ($imageNameEn === "fail" || $imageNameAr === "fail") {
    echo json_encode([
        "status" => "error",
        "message" => "Image upload failed"
    ]);
    exit;
}

// Prepare data
$data = [
    "offers_image_en" => $imageNameEn,
    "offers_image_ar" => $imageNameAr
];

// Get status from insert (without automatic output)
$result = insertData("offers", $data); 




// include "../../connect.php";

// // Get current offer data (assuming only one offer exists; adjust as needed)
// $stmt = $con->prepare("SELECT * FROM offers ORDER BY offers_id DESC LIMIT 1");
// $stmt->execute();
// $existingOffer = $stmt->fetchAll(PDO::FETCH_ASSOC);

// if ($existingOffer) {
//     // Delete old images
//     deleteFile("../../upload/offers", $existingOffer['offers_image_en']);
//     deleteFile("../../upload/offers", $existingOffer['offers_image_ar']);
// }

// // Upload new images
// $imageNameEn = imageUpload("../../upload/offers", "filesen");
// $imageNameAr = imageUpload("../../upload/offers", "filesar");

// // Check for upload failures
// if ($imageNameEn === "fail" || $imageNameAr === "fail") {
//     echo json_encode([
//         "status" => "error",
//         "message" => "Image upload failed"
//     ]);
//     exit;
// }

// // Prepare new data
// $data = [
//     "offers_image_en" => $imageNameEn,
//     "offers_image_ar" => $imageNameAr
// ];

// // Insert new data
// $result = insertData("offers", $data);





// include "../../connect.php";

// // Function to get all existing offers (to delete later)
// function getAllOffers() {
//     global $con;
//     $stmt = $con->prepare("SELECT offers_id, offers_image_en, offers_image_ar FROM offers");
//     $stmt->execute();
//     return $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

// // Get existing offers before any operations
// $oldOffers = getAllOffers();

// // Upload new images
// $imageNameEn = imageUpload("../../upload/offers", "filesen");
// $imageNameAr = imageUpload("../../upload/offers", "filesar");

// // Check for upload failures
// if ($imageNameEn === "fail" || $imageNameAr === "fail") {
//     echo json_encode([
//         "status" => "error",
//         "message" => "Image upload failed"
//     ]);
//     exit;
// }

// // Prepare data
// $data = [
//     "offers_image_en" => $imageNameEn,
//     "offers_image_ar" => $imageNameAr
// ];

// // Insert new offer (temporarily disable JSON output)
// $result = insertData("offers", $data, false); 

// if ($result > 0) {
//     // New offer inserted successfully - now delete old offers/images
//     foreach ($oldOffers as $offer) {
//         // Delete image files
//         deleteFile('../../upload/offers', $offer['offers_image_en']);
//         deleteFile('../../upload/offers', $offer['offers_image_ar']);
        
//         // Delete database record
//         $deleteStmt = $con->prepare("DELETE FROM offers WHERE id = ?");
//         $deleteStmt->execute([$offer['id']]);
//     }

//     echo json_encode(["status" => "success"]);
// } else {
//     // Insert failed - delete new uploaded images
//     deleteFile('../../upload/offers', $imageNameEn);
//     deleteFile('../../upload/offers', $imageNameAr);
    
//     echo json_encode(["status" => "failure"]);
// }