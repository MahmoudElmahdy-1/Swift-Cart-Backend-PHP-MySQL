<?php

include "../../connect.php" ;

$email = filterRequest("email") ;
$verifycode = filterRequest("verifycode") ;

$stmt = $con->prepare("SELECT * FROM riders WHERE riders_email = '$email' AND riders_verifycode = '$verifycode'") ;
$stmt->execute() ;

$count = $stmt->rowCount() ;

if($count > 0){
    printSuccess() ;
}else{
    printFailure("Invalid Verification Code") ;
}

?>