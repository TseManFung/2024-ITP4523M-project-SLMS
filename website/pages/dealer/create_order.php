<?php
session_start();
require_once '../db/dbconnect.php';

// 初始化响应数组
$response = [];

// 获取 JSON 数据
$orderData = file_get_contents('php://input');
$orders = json_decode($orderData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    $response['error'] = "Invalid JSON data: " . json_last_error_msg();
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// 迭代每个订单
foreach ($orders as $order) {
    $deliveryAddress = $order['deliveryAddress'];
    $dealerID = $order['dealerID'];
    $TotalAmount = $order['TotalAmount'];
    $shipCost = $order['shipCost'];
    $time = $order['time'];
    $parts = $order['parts'];

    // 计算 orderItemNumber 为所有零件的 qty 总和
    $orderItemNumber = 0;
    foreach ($parts as $item) {
        $orderItemNumber += $item['qty'];
    }

    // 插入订单
    $sql = sprintf(
        "INSERT INTO `order` (deliveryAddress, orderDateTime, dealerID, orderItemNumber, TotalAmount, shipCost) VALUES ('%s', '%s', %d, %d, %d, %d)",
        $deliveryAddress,
        $time,
        $dealerID,
        $orderItemNumber,
        $TotalAmount,
        $shipCost
    );

    if (mysqli_query($conn, $sql)) {
        $orderID = mysqli_insert_id($conn);
        $response['order'] = "Order inserted successfully";
    } else {
        $response['order'] = "Failed to insert order: " . mysqli_error($conn);
        mysqli_close($conn);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // 插入订单的零件并更新库存和购物车
    foreach ($parts as $item) {
        $sparePartNum = $item['sparePartNum'];
        $orderQty = $item['qty'];
        // 获取零件价格
        $sql = sprintf("SELECT price FROM spare WHERE sparePartNum = '%s'", mysqli_real_escape_string($conn, $sparePartNum));
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $price = $row['price'];
            $sparePartOrderPrice = $price * $orderQty;
        } else {
            $response['price'] = "Failed to get price for spare part: " . mysqli_error($conn);
            mysqli_close($conn);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        $sql = sprintf(
            "INSERT INTO orderSpare (sparePartNum, orderID, orderQty, sparePartOrderPrice) VALUES ('%s', %d, %d, %f)",
            mysqli_real_escape_string($conn, $sparePartNum),
            (int)$orderID,
            (int)$orderQty,
            (float)$sparePartOrderPrice
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
            (int)$orderQty,
            mysqli_real_escape_string($conn, $sparePartNum)
        );

        if (!mysqli_query($conn, $sql)) {
            $response['spareQty'] = "Failed to update spare quantity: " . mysqli_error($conn);
            mysqli_close($conn);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        // 从购物车中扣除相应数量的物品
        $sql = sprintf(
            "UPDATE cart SET qty = qty - %d WHERE userID = %d AND sparePartNum = '%s'",
            (int)$orderQty,
            (int)$_SESSION['userID'],
            mysqli_real_escape_string($conn, $sparePartNum)
        );

        if (!mysqli_query($conn, $sql)) {
            $response['cartUpdate'] = "Failed to update cart quantity: " . mysqli_error($conn);
            mysqli_close($conn);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        // 删除数量为零的物品
        $sql = sprintf(
            "DELETE FROM cart WHERE userID = %d AND sparePartNum = '%s' AND qty <= 0",
            (int)$_SESSION['userID'],
            mysqli_real_escape_string($conn, $sparePartNum)
        );

        if (!mysqli_query($conn, $sql)) {
            $response['cartDelete'] = "Failed to remove zero quantity items from cart: " . mysqli_error($conn);
            mysqli_close($conn);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($response);
?>