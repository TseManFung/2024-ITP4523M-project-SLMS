<?php
session_start();
require_once '../db/dbconnect.php';


$response = [];

$orderData = file_get_contents('php://input');
$orders = json_decode($orderData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    $response['error'] = "Invalid JSON data: " . json_last_error_msg();
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

foreach ($orders as $order) {
    $deliveryAddress = $order['deliveryAddress'];
    $dealerID = $order['dealerID'];
    $TotalAmount = $order['TotalAmount'];
    $shipCost = $order['shipCost'];
    $time = $order['time'];
    $parts = $order['parts'];

    $orderItemNumber = 0;
    foreach ($parts as $item) {
        $orderItemNumber += $item['qty'];
    }

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

    foreach ($parts as $item) {
        $sparePartNum = $item['sparePartNum'];
        $orderQty = $item['qty'];
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

        // update stock record
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

        // Deduct the appropriate number of items from the cart
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

        // Deleting items with 0 quantity
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