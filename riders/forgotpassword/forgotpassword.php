<?php

include "../../connect.php" ;

$email = filterRequest("email") ;
$verifyemail = rand(10000 , 99999) ;

$stmt = $con->prepare("SELECT * FROM riders WHERE riders_email = '$email'") ;
$stmt->execute() ;

$count = $stmt->rowCount() ;

if($count > 0){
    $data = array("riders_verifycode" => $verifyemail) ;
    updateData("riders", $data, "riders_email = '$email'") ;

    sendEmail($email, "Verification Code" , "Hello, Your Verification Code Is: $verifyemail") ;
}else{
    printFailure() ;
}

?>