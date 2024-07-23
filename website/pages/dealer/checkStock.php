<?php
session_start();
require_once '../db/dbconnect.php';

header('Content-Type: application/json');

$response = [];

$orderData = file_get_contents('php://input');
$orders = json_decode($orderData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    $response['success'] = false;
    echo json_encode($response);
    exit;
}

// Used to store total requirements per part
$totalPartsDemand = [];

foreach ($orders as $order) {
    $parts = $order['parts'];

    // Calculate the quantity required for each part
    foreach ($parts as $item) {
        $sparePartNum = $item['sparePartNum'];
        $orderQty = (int)$item['qty'];

        if (!isset($totalPartsDemand[$sparePartNum])) {
            $totalPartsDemand[$sparePartNum] = 0;
        }

        $totalPartsDemand[$sparePartNum] += $orderQty;
    }
}

// Check that the total requirement for each part is met from stock
foreach ($totalPartsDemand as $sparePartNum => $totalQty) {
    // Checking the adequacy of stock
    $sql = sprintf("SELECT stockItemQty FROM spareQty WHERE sparePartNum = '%s'", $sparePartNum);
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['stockItemQty'] < $totalQty) {
            $response['success'] = false;
            echo json_encode($response);
            mysqli_close($conn);
            exit;
        }
    } else {
        $response['success'] = false;
        echo json_encode($response);
        mysqli_close($conn);
        exit;
    }
}

$response['success'] = true; 
echo json_encode($response);
mysqli_close($conn);
?>