<?php

include "../connect.php" ;

$email = filterRequest("email") ;
$verifyemail = rand(10000 , 99999) ;

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = '$email'") ;
$stmt->execute() ;

$count = $stmt->rowCount() ;

if($count > 0){
    $data = array("users_verifycode" => $verifyemail) ;
    updateData("users", $data, "users_email = '$email'") ;

    sendEmail($email, "Verification Code" , "Hello, Your Verification Code Is: $verifyemail") ;
}else{
    printFailure() ;
}

?>