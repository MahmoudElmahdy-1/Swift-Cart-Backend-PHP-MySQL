<?php

include "../connect.php" ;

$name = filterRequest("username") ;
$email = filterRequest("email") ;
$phone = filterRequest("phone") ;
$password = sha1($_POST['password']) ;
$verifyemail = rand(10000 , 99999) ;


$stmt = $con->prepare("SELECT * FROM users WHERE `users_email` = ? OR `users_phone` = ?") ;
$stmt->execute(array($email, $phone)) ;
$count = $stmt->rowCount() ;
if($count > 0) {
  printFailure("Email Or Phone Already Exists") ;
}else{
    $data = array(
        "users_name" => $name ,
        "users_email" => $email ,
        "users_phone" => $phone ,
        "users_password" => $password ,
        "users_verifycode" => $verifyemail ,
    );

    sendEmail($email, "Verification Code" , "Welcome $name, Your Verification Code Is: $verifyemail") ;
    insertData("users", $data);
}