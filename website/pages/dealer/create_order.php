<?php
session_start();
require_once '../db/dbconnect.php';

$response = [];

// 从购物车中选择所有项目，并获取相应的零件价格
$sql = sprintf(
    "SELECT c.sparePartNum, c.qty, s.price 
     FROM cart c 
     JOIN spare s ON c.sparePartNum = s.sparePartNum 
     WHERE c.userID = %d",
    $_SESSION['userID']
);

$result = mysqli_query($conn, $sql);
if ($result) {
    $cartItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $response['cart'] = "Failed to select items from cart: " . mysqli_error($conn);
    mysqli_close($conn);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// 插入订单
$sql = sprintf(
    "INSERT INTO `order` (deliveryAddress, orderDateTime, dealerID, orderItemNumber, TotalAmount, shipCost) VALUES ('%s', '%s', %d, %d, %f, %f)",
    mysqli_real_escape_string($conn, $_POST['deliveryAddre']),
    mysqli_real_escape_string($conn, $_POST['Time']),
    intval($_POST['dealerID']),
    intval($_POST['orderItemNumber']),
    floatval($_POST['TotalAmount']),
    floatval($_POST['shipCost'])
);

if (mysqli_query($conn, $sql)) {
    $response['order'] = "Order inserted successfully";
    $orderID = mysqli_insert_id($conn);
} else {
    $response['order'] = "Failed to insert order: " . mysqli_error($conn);
    mysqli_close($conn);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// 插入订单的零件
foreach ($cartItems as $item) {
    $sparePartNum = $item['sparePartNum'];
    $orderQty = $item['qty'];
    $sparePartOrderPrice = $item['price'] * $orderQty;

    $sql = sprintf(
        "INSERT INTO orderSpare (sparePartNum, orderID, orderQty, sparePartOrderPrice) VALUES ('%s', %d, %d, %f)",
        mysqli_real_escape_string($conn, $sparePartNum),
        $orderID,
        $orderQty,
        $sparePartOrderPrice
    );

    if (!mysqli_query($conn, $sql)) {
        $response['orderSpare'] = "Failed to insert order spare parts: " . mysqli_error($conn);
        mysqli_close($conn);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // 扣除相应的库存数量
    $sql = sprintf(
        "UPDATE spareQty SET stockItemQty = stockItemQty - %d WHERE sparePartNum = '%s'",
        $orderQty,
        mysqli_real_escape_string($conn, $sparePartNum)
    );

    if (!mysqli_query($conn, $sql)) {
        $response['spareQty'] = "Failed to update spare quantity: " . mysqli_error($conn);
        mysqli_close($conn);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

// 清空购物车
$sql = sprintf("DELETE FROM cart WHERE userID = %d", $_SESSION['userID']);

if (mysqli_query($conn, $sql)) {
    $response['cart'] = "Cart cleared successfully";
} else {
    $response['cart'] = "Failed to clear cart: " . mysqli_error($conn);
}

mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($response);
?>