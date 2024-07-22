<?php
session_start();
require_once '../db/dbconnect.php';

header('Content-Type: application/json'); 

$response = []; 

if (isset($_POST['UserID']) && isset($_POST['Password'])) {
    $userID = intval($_POST['UserID']);
    $password = mysqli_real_escape_string($conn, $_POST['Password']); 

    $sql = "SELECT password FROM user WHERE userID = ? AND password = concat('0',sha2(?,256))";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $userID, $_POST['Password']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

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
