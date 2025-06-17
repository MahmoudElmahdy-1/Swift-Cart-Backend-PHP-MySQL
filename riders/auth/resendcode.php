<?php

include "../../connect.php" ;

$email = filterRequest("email") ;
$verifyemail = rand(10000 , 99999) ;

$data = array(
 "riders_email" => $email ,
 "riders_verifycode" => $verifyemail ,
);

updateData("riders", $data, "riders_email = '$email'") ;

sendEmail($email, "Verification Code" , "Hi, Your Verification Code Is: $verifyemail") ;
