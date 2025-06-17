<?php

include "../../connect.php" ;

$email = filterRequest("email") ;
$password = sha1($_POST['password']) ;

getData("admins", "admins_email = ? AND admins_password = ?", array($email, $password)) ;