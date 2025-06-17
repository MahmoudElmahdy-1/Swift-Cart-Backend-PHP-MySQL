<?php

include "../../connect.php" ;

$email = filterRequest("email") ;
$verifyemail = rand(10000 , 99999) ;

$stmt = $con->prepare("SELECT * FROM admins WHERE admins_email = '$email'") ;
$stmt->execute() ;

$count = $stmt->rowCount() ;

if($count > 0){
    $data = array("admins_verifycode" => $verifyemail) ;
    updateData("admins", $data, "admins_email = '$email'") ;

    sendEmail($email, "Verification Code" , "Hello, Your Verification Code Is: $verifyemail") ;
}else{
    printFailure() ;
}

?>