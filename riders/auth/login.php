<?php

include "../../connect.php" ;

$email = filterRequest("email") ;
$password = sha1($_POST['password']) ;

getData("riders", "riders_email = ? AND riders_password = ?", array($email, $password)) ;