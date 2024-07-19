<?php
session_start();
require_once '../db/dbconnect.php';

header('Content-Type: application/json');

$response = [];

    // Ensure the request method is POST
try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $orderID = $_POST['orderID'];
    if (!isset($orderID)) {
        throw new Exception("Order ID is required");
    }
    //Get CurrentTime
    $currentDateTime = new DateTime();

    $sql = sprintf("SELECT state, deliveryDate FROM `order` WHERE orderID = %d", $orderID);
    //error_log($sql);

    if (!$stmt = $conn->prepare($sql)) {
        throw new Exception("Database prepare error: " . $conn->error);
    }

    if (!$stmt->execute()) {
        throw new Exception("Database execute error: " . $stmt->error);
    }
    //like $result = $conn->query($sql); $result = mysqli_query($conn, $sql);
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Order not found");
    }

    //$order = $result->fetch_assoc();
    $order = mysqli_fetch_assoc($result); 

    $deliveryDateStr = $order['deliveryDate'];
    $state = $order['state'];

    if ($state === 'U') {
        $response['error'] = 'Order is already cancelled!';
        echo json_encode($response);
        exit();
    }

    if ($deliveryDateStr === null) {
        //function
        restore($conn, $orderID);
        //function
        deleteOrderAndorderspare($conn, $orderID);
        $response['success'] = 'Order deleted due to null delivery date';
        echo json_encode($response);
        exit();
    }

    $deliveryDate = new DateTime($deliveryDateStr);
    //Calls the diff method of object $deliveryDate, passing one argument $currentDateTime
    //Transfer parameters $interval
    $interval = $deliveryDate->diff($currentDateTime);

    $hoursUntilDelivery = ($interval->days * 24) + $interval->h;

    if ($hoursUntilDelivery <= 48) {
        throw new Exception("Cannot cancel the order as the delivery date is within the next 48 hours");
    } elseif ($state === 'T' || $state === 'F') {
        throw new Exception("Cannot cancel the order as its state is either T or F");
    }

    restore($conn, $orderID);

    deleteOrderAndorderspare($conn, $orderID);

    $response['success'] = 'Order deleted and stock quantities restored successfully';
    echo json_encode($response);
} catch (Exception $e) {
    //Call the getMessage method of the Exception object $e.
    error_log($e->getMessage());
    //Stored in the ‘error’ key of the $response array.
    $response['error'] = $e->getMessage();
    echo json_encode($response);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
    exit();
}


function restore($conn, $orderID) {
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
    } catch (Exception $e) {
        throw $e;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}


function deleteOrderAndorderspare($conn, $orderID) {

    $conn->begin_transaction();

    try {
        $sql = sprintf("DELETE FROM orderSpare WHERE orderID = %d", $orderID);
        error_log($sql);

        if (!$stmt = $conn->prepare($sql)) {
            throw new Exception("Database prepare error: " . $conn->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Database execute error: " . $stmt->error);
        }

        $sql = sprintf("DELETE FROM `order` WHERE orderID = %d", $orderID);
        error_log($sql);

        if (!$stmt = $conn->prepare($sql)) {
            throw new Exception("Database prepare error: " . $conn->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Database execute error: " . $stmt->error);
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}
?>