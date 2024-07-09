<?php
session_start();
require_once '../db/dbconnect.php';

header('Content-Type: application/json'); // 设置响应头为 JSON 格式

$response = []; // 初始化响应数组

if (isset($_POST['UserID']) && isset($_POST['Password'])) {
    $userID = intval($_POST['UserID']);
    $password = mysqli_real_escape_string($conn, $_POST['Password']); // 使用 mysqli_real_escape_string 处理用户输入

    $sql = sprintf("SELECT password FROM user WHERE userID = %d AND password = '%s'", $userID, $_POST['Password']);
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];

        if ($password) {
            $response['password'] = 'Password matches'; // 密码匹配
        } else {
            $response['error'] = 'Password does not match'; // 密码不匹配
        }
    } else {
        $response['error'] = 'Password does not match'; // 如果查询失败或没有找到用户，设置错误信息
    }
} else {
    $response['error'] = 'UserID or Password not set'; // 如果没有设置 UserID 或 Password，设置错误信息
}

echo json_encode($response); // 将响应数组转换为 JSON 格式并输出

mysqli_close($conn); // 关闭数据库连接
?>
