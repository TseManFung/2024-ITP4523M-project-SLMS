<?php
session_start();
require_once '../db/dbconnect.php';

header('Content-Type: application/json');

$response = [];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $orderID = $_POST['orderID'];
    if (!isset($orderID)) {
        throw new Exception("Order ID is required");
    }

    $currentDateTime = new DateTime();

    // 使用 printf 格式化 SQL 语句
    $sql = sprintf("SELECT state, deliveryDate FROM `order` WHERE orderID = %d", $orderID);
    error_log($sql);

    if (!$stmt = $conn->prepare($sql)) {
        throw new Exception("Database prepare error: " . $conn->error);
    }

    if (!$stmt->execute()) {
        throw new Exception("Database execute error: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Order not found");
    }

    $order = $result->fetch_assoc();
    $deliveryDateStr = $order['deliveryDate'];
    $state = $order['state'];

    // 如果 state 为 'U'，直接返回
    if ($state === 'U') {
        $response['error'] = 'Order is already cancelled!';
        echo json_encode($response);
        exit();
    }

    // 如果 deliveryDate 为 null，直接更新订单状态为 'U'
    if ($deliveryDateStr === null) {
        $sql = sprintf("UPDATE `order` SET state = 'U' WHERE orderID = %d", $orderID);
        error_log($sql);

        if (!$stmt = $conn->prepare($sql)) {
            throw new Exception("Database prepare error: " . $conn->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Database execute error: " . $stmt->error);
        }

        // 恢复库存数量
        restoreStockQuantity($conn, $orderID);

        $response['success'] = 'Order cancelled due to null delivery date';
        echo json_encode($response);
        exit();
    }

    $deliveryDate = new DateTime($deliveryDateStr);

    // 检查 deliveryDate 是否在未来 48 小时内
    $interval = $deliveryDate->diff($currentDateTime);
    $hoursUntilDelivery = ($interval->days * 24) + $interval->h;

    if ($hoursUntilDelivery <= 48) {
        throw new Exception("Cannot cancel the order as the delivery date is within the next 48 hours");
    } elseif ($state === 'T' || $state === 'F') {
        throw new Exception("Cannot cancel the order as its state is either T or F");
    }

    // 更新订单状态为 'U'（不可用）
    $sql = sprintf("UPDATE `order` SET state = 'U' WHERE orderID = %d", $orderID);
    error_log($sql);

    if (!$stmt = $conn->prepare($sql)) {
        throw new Exception("Database prepare error: " . $conn->error);
    }

    if (!$stmt->execute()) {
        throw new Exception("Database execute error: " . $stmt->error);
    }

    // 恢复库存数量
    restoreStockQuantity($conn, $orderID);

    $response['success'] = 'Order cancelled and stock quantities restored successfully';
    echo json_encode($response);
} catch (Exception $e) {
    error_log($e->getMessage());
    $response['error'] = $e->getMessage();
    echo json_encode($response);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
    exit();
}

/**
 * 恢复库存数量的函数
 *
 * @param mysqli $conn 数据库连接
 * @param int $orderID 订单ID
 * @throws Exception 如果操作失败
 */
function restoreStockQuantity($conn, $orderID) {
    // 开始事务
    $conn->begin_transaction();

    try {
        $sql = sprintf("SELECT sparePartNum, orderQty FROM orderSpare WHERE orderID = %d", $orderID);
        error_log($sql);

        if (!$stmt = $conn->prepare($sql)) {
            throw new Exception("Database prepare error: " . $conn->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Database execute error: " . $stmt->error);
        }

        $result = $stmt->get_result();

        while ($orderSpare = $result->fetch_assoc()) {
            $sparePartNum = $orderSpare['sparePartNum'];
            $orderQty = $orderSpare['orderQty'];

            $sql = sprintf("UPDATE spareQty SET stockItemQty = stockItemQty + %d WHERE sparePartNum = '%s'", $orderQty, $conn->real_escape_string($sparePartNum));
            error_log($sql);

            if (!$stmt = $conn->prepare($sql)) {
                throw new Exception("Database prepare error: " . $conn->error);
            }

            if (!$stmt->execute()) {
                throw new Exception("Database execute error: " . $stmt->error);
            }
        }

        // 提交事务
        $conn->commit();
    } catch (Exception $e) {
        // 回滚事务 Restore the status quo before the event
        $conn->rollback();
        throw $e;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}
?>