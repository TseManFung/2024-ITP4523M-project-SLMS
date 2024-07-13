<?php
session_start();
require_once '../db/dbconnect.php';

header('Content-Type: application/json'); 

$response = []; 

if (isset($_POST['UserID']) && isset($_POST['Password'])) {
    $userID = intval($_POST['UserID']);
    $password = mysqli_real_escape_string($conn, $_POST['Password']); 

    $sql = sprintf("SELECT password FROM user WHERE userID = %d AND password = '%s'", $userID, $_POST['Password']);
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];

        if ($password) {
            $response['password'] = 'Password matches'; 
        } else {
            $response['error'] = 'Password does not match'; 
        }
    } else {
        $response['error'] = 'Password does not match'; 
    }
} else {
    $response['error'] = 'UserID or Password not set'; 
}

echo json_encode($response); 

mysqli_close($conn); 
?>
