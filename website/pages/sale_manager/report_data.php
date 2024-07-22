<?php
require_once '../db/dbconnect.php';


function return_error($message)
{
    http_response_code(400);
    echo $message;
    exit;
}
if (!isset($_POST["mode"])) {
    return_error("Mode not set");
}
extract($_POST);

if ($mode == 1) {
    // spnum mode
    $sql = "SELECT
    DATE_FORMAT(o.orderDateTime, '%m/%Y') AS `Month/Year`,
    SUM(os.orderQty) AS `SalesQuantity`
FROM
    `order` o
JOIN
    `orderSpare` os ON o.orderID = os.orderID
WHERE
    os.sparePartNum = '{$ID}' AND
    o.orderDateTime >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
GROUP BY
    DATE_FORMAT(o.orderDateTime, '%m/%Y')
ORDER BY
    `Month/Year`;";
} elseif ($mode == 2) {
    //dealer mode
    $sql = "SELECT
    DATE_FORMAT(o.orderDateTime, '%m/%Y') AS `Month/Year`,
    COUNT(o.orderID) AS `OrderCount`
FROM
    `order` o
WHERE
    o.dealerID = {$ID}
    AND o.orderDateTime >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
GROUP BY
    DATE_FORMAT(o.orderDateTime, '%m/%Y')
ORDER BY
    `Month/Year`;";
} else {
    return_error("Invalid mode");
}
try {
    $result = $conn->query($sql);
} catch (Exception $e) {
    return_error("Error in query");
}
$records = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($records);
