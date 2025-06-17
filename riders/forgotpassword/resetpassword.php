<?php 
include "../../connect.php" ;

$email = filterRequest("email") ;
$password = sha1($_POST['password']) ;

$data = array("riders_password" => $password) ;

updateData("riders", $data, "riders_email = '$email'") ;