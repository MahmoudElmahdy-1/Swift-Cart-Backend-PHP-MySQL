<?php

include "../../connect.php" ;

$email = filterRequest("email") ;
$verifyemail = rand(10000 , 99999) ;

$data = array(
 "admins_email" => $email ,
 "admins_verifycode" => $verifyemail ,
);

updateData("admins", $data, "admins_email = '$email'") ;

sendEmail($email, "Verification Code" , "Hi, Your Verification Code Is: $verifyemail") ;
