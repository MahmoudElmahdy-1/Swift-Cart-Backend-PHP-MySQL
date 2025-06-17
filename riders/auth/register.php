<?php

include "../../connect.php" ;

$name = filterRequest("username") ;
$email = filterRequest("email") ;
$phone = filterRequest("phone") ;
$password = sha1($_POST['password']) ;
$verifyemail = rand(10000 , 99999) ;


$stmt = $con->prepare("SELECT * FROM riders WHERE `riders_email` = ? OR `riders_phone` = ?") ;
$stmt->execute(array($email, $phone)) ;
$count = $stmt->rowCount() ;
if($count > 0) {
  printFailure("Email Or Phone Already Exists") ;
}else{
    $data = array(
        "riders_name" => $name ,
        "riders_email" => $email ,
        "riders_phone" => $phone ,
        "riders_password" => $password ,
        "riders_verifycode" => $verifyemail ,
    );

    sendEmail($email, "Verification Code" , "Welcome $name, Your Verification Code Is: $verifyemail") ;
    insertData("riders", $data);
}