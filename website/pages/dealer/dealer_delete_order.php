<!DOCTYPE html>
<html lang="en">
<?php
session_start();

if (isset($_SESSION['expire'])) {
    if ($_SESSION['expire'] < time()) {
        session_destroy();
        header('Location: ../../index.php');
        exit();
    } else {
        $_SESSION['expire'] = time() + (30 * 60);
        require_once '../db/dbconnect.php';
    }
} else {
    session_destroy();
    header('Location: ../../index.php');
    exit();
}
?>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />

    <title>Delete Order</title>

    <!-- css -->
    <!-- icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../css/reset.css" />
    <link rel="stylesheet" href="../../css/common.css" />
    <link rel="stylesheet" href="../../css/bs/bootstrap.css" />
    <link rel="stylesheet" href="../../css/checkout.css" />
    <!-- /css -->

    <!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    <script src="../../js/common.js"></script>
    <script src="../../js/bs/bootstrap.bundle.js"></script>
    <script src="../../js/dealer_delete_order.js"></script>
    <!-- /js -->
</head>

<body>
    <div class="fixed-top">
        <!-- navbar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid justify-content-center">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse nav-wrap" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="./search_item.php">Our Product</a>
                        </li>
                    </ul>
                    <?php
                    $sql = "SELECT count(*) as cn FROM cart WHERE userID = " . $_SESSION['userID'] . ";";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);
                    $cartNum = $row['cn'];
                    if ($cartNum > 99) {
                        $cartNum = "99+";
                    }
                    ?>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex flex-nowrap align-items-center" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Hi <?php echo htmlspecialchars($_SESSION["dealerName"]); ?><span class="note-label"><?php echo $cartNum; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="./dealer_information.php">Your Information</a></li>
                            <li><a class="dropdown-item" href="./view_order_record.php">Your Order</a></li>
                            <li>
                                <a class="dropdown-item position-relative d-flex flex-nowrap" href="./dealer_cart.php">
                                    Cart<span class="cart-number-label"><?php echo $cartNum; ?></span>
                                </a>
                            </li>
                            <li class="dropdown-item">
                                <a class="nav-link" aria-current="page" href="../../index.php" style="color: red;">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- /navbar -->
    </div>

    <!-- header -->
    <div style="height: calc(0lvh + 56px)" id="header"></div>
    <!-- /header -->

    <?php
    $orderID = $_POST['orderID'];
    $sql = "SELECT * FROM `order` WHERE orderID = $orderID";
    $result = mysqli_query($conn, $sql);
    $order = mysqli_fetch_array($result);
    $dealerIDFormatted = sprintf('%010d', $order['orderID']);

    $sql_items = "SELECT os.orderQty, os.sparePartOrderPrice, s.sparePartName, s.sparePartImage 
                  FROM `orderSpare` os 
                  INNER JOIN `spare` s ON os.sparePartNum = s.sparePartNum 
                  WHERE os.orderID = $orderID";
    $result_items = mysqli_query($conn, $sql_items);
    mysqli_close($conn);
    ?>

    <!-- content -->
    <div class="d-flex position-relative content-bg justify-content-center">
        <div class="container content-wrap">
            <br />
            <div class="container">
                <div class="py-5 text-center">
                    <h2>Delete Order</h2>
                </div>
                <div class="row">
                    <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Order Items</span>
                            <span class="badge badge-secondary badge-pill"><?php echo mysqli_num_rows($result_items); ?></span>
                        </h4>
                        <ul class="list-group mb-3 sticky-top">
                            <?php while ($item = mysqli_fetch_array($result_items)) { 
                                $totalPrice = $item['orderQty'] * $item['sparePartOrderPrice'];
                            ?>
                                <li class="list-group-item justify-content-between lh-condensed">
                                    <div class="order-img">
                                        <img class="order-abs-img" src="../../images/item/<?php echo htmlspecialchars($item['sparePartImage']); ?>" alt="Item <?php echo htmlspecialchars($item['sparePartName']); ?>" />
                                    </div>
                                    <div>
                                        <h6 class="my-0"><?php echo htmlspecialchars($item['sparePartName']); ?></h6>
                                        <small class="text-muted">Quantity: <?php echo htmlspecialchars($item['orderQty']); ?></small>
                                    </div>
                                    <span class="text-muted">$<?php echo htmlspecialchars($totalPrice); ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h4 class="mb-3">Your order information:</h4>
                        <form class="needs-validation" novalidate>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="Order-ID">Your order ID:</label>
                                    <input type="text" class="form-control" id="Order-ID" value="<?php echo $dealerIDFormatted; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="Order-D-T">Order Date & Time:</label>
                                    <input type="text" class="form-control" id="Order-D-T" value="<?php echo htmlspecialchars($order['orderDateTime']); ?>" disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Order-Quantity">Order Quantity:</label>
                                <input type="text" class="form-control" id="Order-Quantity" value="<?php echo htmlspecialchars($order['orderItemNumber']); ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="Order-Price">Order Price:</label>
                                <input type="text" class="form-control" id="Order-Price" value="$<?php echo htmlspecialchars($order['TotalAmount']); ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="Delivery-Fee">Delivery Fee:</label>
                                <input type="text" class="form-control" id="Delivery-Fee" value="$<?php echo htmlspecialchars($order['shipCost']); ?>" disabled>
                            </div>
                            <?php
                                $totalOrderAmount = $order['TotalAmount'] + $order['shipCost'];
                            ?>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="Total-Order-Amount">Total Order Amount:</label>
                                    <input type="text" class="form-control" id="Total-Order-Amount" value="$<?php echo htmlspecialchars($totalOrderAmount); ?>" disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Delivery-Address">Delivery Address</label>
                                <input type="text" class="form-control" id="Delivery-Address" value="<?php echo htmlspecialchars($order['deliveryAddress']); ?>" required disabled>
                            </div>
                            <div class="mb-3">
                                <label for="Delivery-Date">Delivery Date of this order</label>
                                <input type="text" class="form-control" id="Delivery-Date" value="<?php echo htmlspecialchars($order['deliveryDate'] ?? 'unfinished'); ?>" required disabled>
                            </div>
                            <hr class="mb-4">
                            <h4 class="mb-3">Enter your password to delete the order:</h4>
                            <div class="mb-3">
                                <div class="col-md-12">
                                    <label class="labels">Password</label>
                                    <input type="password" id="Password_delete" class="form-control" value="" required>
                                    <input type="checkbox" onclick="SPassword_delete()">Show Password
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="deleteOrder(<?php echo $_SESSION['userID']; ?>,<?php echo $orderID; ?>)">
                                Delete the order
                            </button>
                        </form>
                    </div>
                </div>
                <ul class="list-inline"></ul>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                </div>
                <div class="modal-body" id="modal-body">
                    ...
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" id="showModalButton" class="btn btn-secondary" onclick="$('#myModal').modal('hide');">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /content -->

    <footer>
        <!-- link -->
        <ul class="sns"></ul>
        <!-- /link -->
        <p>© <?php echo date("Y"); ?> Smart & Luxury Motor Spares inc.</p>
    </footer>

    <!-- return top -->
    <div id="page-top">
        <a href="#header"><img src="../../images/common/return-top.png" alt="Return to top" /></a>
    </div>
    <!-- /return top -->
</body>

</html>