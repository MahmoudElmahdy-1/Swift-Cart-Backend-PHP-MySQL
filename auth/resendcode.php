<?php

include "../connect.php" ;

$email = filterRequest("email") ;
$verifyemail = rand(10000 , 99999) ;

$data = array(
 "users_email" => $email ,
 "users_verifycode" => $verifyemail ,
);

updateData("users", $data, "users_email = '$email'") ;

sendEmail($email, "Verification Code" , "Hi, Your Verification Code Is: $verifyemail") ;
