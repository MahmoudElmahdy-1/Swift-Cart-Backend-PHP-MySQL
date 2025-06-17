<?php

// date_default_timezone_set("Africa/Cairo"); // make the date and time set to cairo

// this is a constant and Global value (Example: const var MB = 1048576) but we write it like this in php
define('MB', 1048576); // this is the size of 1 MB so we can convert it later if we want

////////////////////////////////////////////////////////////////////////////////////////////

// function for sending requests (Add, Edit, Delete, Read)
function filterRequest($requestname) { //the (isset) function is to check if the request is set or not (empty or null)
    return htmlspecialchars(strip_tags(isset($_POST[$requestname]) //if it is not set it will go to left value and if it is not set it will go to right value
    ? $_POST[$requestname] : $_POST[$requestname . '_'])); 
} // (htmlspecialchars and strip_tags) functions are only going to be applied to the value if it exists, and if not, 
  // the value with the underscore is used and then the functions are going to be applied. and they are for more security
  
// this checks if the request parameter $requestname exists in the $_POST superglobal array. 
// If it does, the expression returns the value of $_POST[$requestname]. 
// If it doesn't, the expression returns the value of $_POST[$requestname . '_'].
// In other words, if the request parameter $requestname is not present in the $_POST array, 
// the function will look for a parameter with the same name but with an underscore  (_).

////////////////////////////////////////////////////////////////////////////////////////////

function getAllData($table, $where = null, $values = null, $json = true)
{
    global $con;
    $data = array();
    if ($where == null) {
        $stmt = $con->prepare("SELECT * FROM $table");
    } else {
        $stmt = $con->prepare("SELECT * FROM $table WHERE $where");
    }  
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();

    if ($json == true){
        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    } else {
        if ($count > 0){
            return array("status" => "success", "data" => $data) ;
        } else {
            return array("status" => "failure");
        }
    }
}

////////////////////////////////////////////////////////////////////////////////////////////

function getData($table, $where = null, $values = null, $json = true)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($json == true){
    if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }}else {
        return $count;

    }
}

////////////////////////////////////////////////////////////////////////////////////////////

// function for inserting data
function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
  }
    return $count;
}

////////////////////////////////////////////////////////////////////////////////////////////

// function for updating data
function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;
}

///////////////////////////////////////////////////////////////////////////////////////////

// function for deleting data
function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

///////////////////////////////////////////////////////////////////////////////////////////

// function for uploading images and files
function imageUpload($dir ,$imageRequest){
    Global $msgError ; // this is a global key so we can use it anywhere
    if(isset($_FILES[$imageRequest])){ // o check if there is an image uploaded or not
    $imageName  = rand(1000 , 10000) . $_FILES[$imageRequest]['name'];    // for file name & the metohd rand() is for generating a random number between the two numbers we enter cuz the images or files cant have the same name
    $imageTmp   = $_FILES[$imageRequest]['tmp_name']; // for file path
    $imageSize  = $_FILES[$imageRequest]['size'];    // for file size
    $allowExt   = array('jpg', 'png', 'gif', 'jpeg', 'pdf', 'mp3', 'mp4', 'svg');
    $strToArray = explode('.', $imageName);  // to seperate the words with (.) in the file name
    $ext        = end($strToArray);  // to get the last word
    $ext        = strtolower($ext);  // to make the word lowerCase cuz it might be uperCase 
    if(!empty($imageName) && !in_array($ext, $allowExt)){  // to check if the file is empty and has the correct ext or not
        $msgError[] = 'ext ERROR' ;
    }
    if($imageSize >= 2 * MB){  // to check if the file is bigger then 2 MB or not
        $msgError[] = 'size ERROR' ;
    }
    if(empty($msgError)){  // to check if there is no error and the $msgError is empty
        move_uploaded_file($imageTmp , $dir . "/" . $imageName) ; // to move the file form its original path to a chosen folder with the file name
        return $imageName ;
    }else{
        return "Fail" ;  // if the file or image didnt uploaded it will return 'Fail'
    }
    }else {
        return "empty" ;
    }
    
}

////////////////////////////////////////////////////////////////////////////////////////////

// function for deleting images and files
function deleteFile($dir , $imageName){
    if(file_exists($dir . '/' . $imageName)){ //to check if the file exisits or not
        unlink($dir . '/' . $imageName); //to delete the file if its exisits
    }
}

////////////////////////////////////////////////////////////////////////////////////////////

// function for authentication using name and password for more security
function checkAuthenticate(){
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "USERNAME" ||  $_SERVER['PHP_AUTH_PW'] != "PASSWORD"){
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
            }
        } else {
            exit;
        }
    }

////////////////////////////////////////////////////////////////////////////////////////////

// function to print failure if there is an error
function printFailure($message = "none"){
    echo json_encode(array("status" => "failure" , "message" => $message));
}

////////////////////////////////////////////////////////////////////////////////////////////

// function to print success
function printSuccess($message = "none"){
    echo json_encode(array("status" => "success" , "message" => $message));
}

////////////////////////////////////////////////////////////////////////////////////////////

// function to send email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require 'vendor/autoload.php';

// the Function
function sendEmail($toEmail, $title, $body) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
       /////////////////// akofuqxkjobvjbfb // Use an App Password From Google account settings (2-step verification must be enabled)
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'EMAIL'; // Your Gmail address
        $mail->Password = 'PASSWORD'; // Your Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender & Recipient
        $mail->setFrom('EMAIL', 'NAME'); // Your Gmail address (Sender)
        $mail->addAddress($toEmail); // Send to this email (Reciever)

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->Body    = $body;

        // Send Email
        $mail->send();

        return true; // Email sent successfully

    } catch (Exception $e) {
        return "Mailer Error: {$mail->ErrorInfo}";
    }
}

////////////////////////////////////////////////////////////////////////////////////////////

require 'vendor/autoload.php';

use Google\Auth\OAuth2;
use Firebase\JWT\JWT;

function sendGCM($title, $body, $topic, $pageid, $pagename)
{
    $projectId = 'FIREBASE PROJECT ID'; // Replace with your Firebase project ID
    $serviceAccountFile = __DIR__ . 'SERVICE ACCOUNT JSON'; // Replace with path to your service account JSON
    // Validate service account
    if (!file_exists($serviceAccountFile)) {
        throw new Exception("Service account file missing");
    }

    // Load the service account JSON
    $jsonKey = json_decode(file_get_contents($serviceAccountFile), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON in service account");
    }

    // Create OAuth2 credentials
    $oauth = new OAuth2([
        'audience' => 'https://oauth2.googleapis.com/token',
        'issuer' => $jsonKey['client_email'],
        'signingAlgorithm' => 'RS256',
        'signingKey' => $jsonKey['private_key'],
        'tokenCredentialUri' => $jsonKey['token_uri'], 
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
    ]);

    // Get access token
    $accessToken = $oauth->fetchAuthToken()['access_token'];

    // Set endpoint
    $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

    // Message payload
    $fields = [
        "message" => [
            "topic" => $topic,
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            "data" => [
                "pageid" => $pageid,
                "pagename" => $pagename,
            ],
            "android" => [
                "priority" => "high",
                "notification" => [
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    "sound" => "default",
                    "channel_id" => "high_importance_channel",
                ]
            ],
            "apns" => [
                "headers" => ["apns-priority" => "10"],
                "payload" => ["aps" => ["sound" => "default"]]
            ]
        ]
    ];

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);

// Get HTTP status BEFORE closing handle
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check for both cURL errors AND HTTP status
if ($result === false) {
    $errorMsg = 'Curl error: ' . curl_error($ch);
    curl_close($ch);
    throw new Exception($errorMsg);
} elseif ($httpCode !== 200) {
    curl_close($ch);
    throw new Exception("FCM failed with HTTP $httpCode. Response: " . $result);
}

curl_close($ch);

// Only successful responses reach here
return $result; 
}

//========================

function sendGCMRiders($title, $body, $topic, $pageid, $pagename)
{
    $projectId = 'FIREBASE PROJECT ID'; // Replace with your Firebase project ID
    $serviceAccountFile = __DIR__ . 'SERVICE ACCOUNT JSON'; // Replace with path to your service account JSON
    // Validate service account
    if (!file_exists($serviceAccountFile)) {
        throw new Exception("Service account file missing");
    }

    // Load the service account JSON
    $jsonKey = json_decode(file_get_contents($serviceAccountFile), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON in service account");
    }

    // Create OAuth2 credentials
    $oauth = new OAuth2([
        'audience' => 'https://oauth2.googleapis.com/token',
        'issuer' => $jsonKey['client_email'],
        'signingAlgorithm' => 'RS256',
        'signingKey' => $jsonKey['private_key'],
        'tokenCredentialUri' => $jsonKey['token_uri'], 
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
    ]);

    // Get access token
    $accessToken = $oauth->fetchAuthToken()['access_token'];

    // Set endpoint
    $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

    // Message payload
    $fields = [
        "message" => [
            "topic" => $topic,
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            "data" => [
                "pageid" => $pageid,
                "pagename" => $pagename,
            ],
            "android" => [
                "priority" => "high",
                "notification" => [
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    "sound" => "default",
                    "channel_id" => "high_importance_channel",
                ]
            ],
            "apns" => [
                "headers" => ["apns-priority" => "10"],
                "payload" => ["aps" => ["sound" => "default"]]
            ]
        ]
    ];

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);

// Get HTTP status BEFORE closing handle
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check for both cURL errors AND HTTP status
if ($result === false) {
    $errorMsg = 'Curl error: ' . curl_error($ch);
    curl_close($ch);
    throw new Exception($errorMsg);
} elseif ($httpCode !== 200) {
    curl_close($ch);
    throw new Exception("FCM failed with HTTP $httpCode. Response: " . $result);
}

curl_close($ch);

// Only successful responses reach here
return $result; 
}
//========================

function sendGCMAdmins($title, $body, $topic, $pageid, $pagename)
{
    $projectId = 'Firebase PROJECT ID'; // Replace with your Firebase project ID
    $serviceAccountFile = __DIR__ . 'SERVICE ACCOUNT JSON'; // Replace with path to your service account JSON
    // Validate service account
    if (!file_exists($serviceAccountFile)) {
        throw new Exception("Service account file missing");
    }

    // Load the service account JSON
    $jsonKey = json_decode(file_get_contents($serviceAccountFile), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON in service account");
    }

    // Create OAuth2 credentials
    $oauth = new OAuth2([
        'audience' => 'https://oauth2.googleapis.com/token',
        'issuer' => $jsonKey['client_email'],
        'signingAlgorithm' => 'RS256',
        'signingKey' => $jsonKey['private_key'],
        'tokenCredentialUri' => $jsonKey['token_uri'], 
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
    ]);

    // Get access token
    $accessToken = $oauth->fetchAuthToken()['access_token'];

    // Set endpoint
    $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

    // Message payload
    $fields = [
        "message" => [
            "topic" => $topic,
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            "data" => [
                "pageid" => $pageid,
                "pagename" => $pagename,
            ],
            "android" => [
                "priority" => "high",
                "notification" => [
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                    "sound" => "default",
                    "channel_id" => "high_importance_channel",
                ]
            ],
            "apns" => [
                "headers" => ["apns-priority" => "10"],
                "payload" => ["aps" => ["sound" => "default"]]
            ]
        ]
    ];

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);

// Get HTTP status BEFORE closing handle
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check for both cURL errors AND HTTP status
if ($result === false) {
    $errorMsg = 'Curl error: ' . curl_error($ch);
    curl_close($ch);
    throw new Exception($errorMsg);
} elseif ($httpCode !== 200) {
    curl_close($ch);
    throw new Exception("FCM failed with HTTP $httpCode. Response: " . $result);
}

curl_close($ch);

// Only successful responses reach here
return $result; 
}

////////////////////////////////////////////////////////////////////////////////////////////////////

function insertNotification($title, $body, $topic, $pageid, $pagename, $usersid) 
{
    global $con;

    try {
        $stmt = $con->prepare("INSERT INTO `notifications`(`notifications_title`, `notifications_body`, `notifications_usersid`) VALUES (?, ?, ?)");
        $success = $stmt->execute([$title, $body, $usersid]);

        if ($success) {
            // Send GCM and return its result
            $fcmResult = sendGCM($title, $body, $topic, $pageid, $pagename);
            return [
                'db_success' => true,
                'fcm_result' => $fcmResult
            ];
        }
        return ['db_success' => false];

    } catch (PDOException $e) {
        return [
            'error' => 'database',
            'message' => $e->getMessage()
        ];
    } catch (Exception $e) {
        return [
            'error' => 'fcm',
            'message' => $e->getMessage()
        ];
    }
}