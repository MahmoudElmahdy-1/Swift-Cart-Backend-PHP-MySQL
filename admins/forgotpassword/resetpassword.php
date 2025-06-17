<?php 
include "../../connect.php" ;

$email = filterRequest("email") ;
$password = sha1($_POST['password']) ;

$data = array("admins_password" => $password) ;

updateData("admins", $data, "admins_email = '$email'") ;