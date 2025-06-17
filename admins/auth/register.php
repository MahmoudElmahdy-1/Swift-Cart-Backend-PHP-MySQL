<?php

include "../../connect.php" ;

$name = filterRequest("username") ;
$email = filterRequest("email") ;
$phone = filterRequest("phone") ;
$password = sha1($_POST['password']) ;
$verifyemail = rand(10000 , 99999) ;


$stmt = $con->prepare("SELECT * FROM admins WHERE `admins_email` = ? OR `admins_phone` = ?") ;
$stmt->execute(array($email, $phone)) ;
$count = $stmt->rowCount() ;
if($count > 0) {
  printFailure("Email Or Phone Already Exists") ;
}else{
    $data = array(
        "admins_name" => $name ,
        "admins_email" => $email ,
        "admins_phone" => $phone ,
        "admins_password" => $password ,
        "admins_verifycode" => $verifyemail ,
    );

    sendEmail($email, "Verification Code" , "Welcome $name, Your Verification Code Is: $verifyemail") ;
    insertData("admins", $data);
}