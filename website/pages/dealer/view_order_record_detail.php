<!DOCTYPE html>
<html>
<?php
session_start();

if (isset($_SESSION['expire'])) {
  if ($_SESSION['expire'] < time()) {
    session_destroy();
    header('Location: ../../index.php');
  } else {
    $_SESSION['expire'] = time() + (30 * 60);
    require_once '../db/dbconnect.php';
  }
} else {
  session_destroy();
  header('Location: ../../index.php');
}
?>

<?php
$sql = mysqli_query($conn,"SELECT isPaid FROM `order` where orderID = {$_POST["orderID"]};");
$isPaid = mysqli_fetch_assoc($sql)["isPaid"];

if (!$isPaid && isset($_FILES['receiptUpload']) && file_exists($_FILES['receiptUpload']['tmp_name']) && is_uploaded_file($_FILES['receiptUpload']['tmp_name'])) {
  $target_dir = "../../images/receipt/";
  $target_file = sprintf("Order%010d-%s-%s", $_POST["orderID"], date("Y-m-d-H"), strtolower($_FILES["receiptUpload"]["name"]));
  // if any file uploaded
  $check = getimagesize($_FILES["receiptUpload"]["tmp_name"]);
  if ($check) {
    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    if (move_uploaded_file($_FILES["receiptUpload"]["tmp_name"], $target_dir . $target_file)) {
      $sql = "UPDATE `order` SET `isPaid` = '1', `receipt` = '$target_file' WHERE `orderID` = {$_POST["orderID"]};";
      $conn->query($sql);
    }
  }
  }

?>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

  <title>Order Deatil</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/reset.css">
  <link rel="stylesheet" href="../../css/common.css">
  <link rel="stylesheet" href="../../css/bs/bootstrap.css">
  <link rel="stylesheet" href="../../css/dealer_view_orderrecord.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/bootstrap-table.min.css">
  <!-- /css -->

  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../../js/common.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/add_item.js"></script>
  <script src="../../js/dealer/dealer_view_order_record_detai.js"></script>
  <script src="../../js/FPS.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/bootstrap-table.min.js"></script>
  <!-- /js -->
</head>
<?php
$sql = "SELECT o.orderDateTime,o.isPaid,o.receipt, o.deliveryAddress, o.deliveryDate, o.salesManagerID, o.orderItemNumber, o.TotalAmount, o.shipCost, o.state, d.dealerName FROM `order` o inner join dealer d on o.dealerID = d.dealerID where orderID = {$_POST["orderID"]};";
$result = mysqli_query($conn, $sql);
$orderDetail = mysqli_fetch_assoc($result);
// orderID, orderDateTime, deliveryAddress, deliveryDate, salesManagerID, dealerID, orderItemNumber, TotalAmount, shipCost, state
?>

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
          $sql = "SELECT count(*) as cn FROM cart where userID = " . $_SESSION['userID'] . ";";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_array($result);
          $cartNum = $row['cn'];
          if ($cartNum > 99) {
            $cartNum = "99+";
          }
          ?>
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex flex-nowrap align-items-center" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Hi <?php echo $_SESSION["dealerName"] ?><span class="note-label"><?php echo $cartNum ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="./dealer_information.php">Your Information</a></li>
              <li><a class="dropdown-item" href="./view_order_record.php">Your Order</a></li>
              <li>
                <a class="dropdown-item position-relative d-flex flex-nowrap" href="./dealer_cart.php">
                  Cart<span class="cart-number-label"><?php echo $cartNum ?></span>
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
  <div style="height: calc(0lvh + 56px);" id="header"></div>
  <!-- /header -->
  <!-- content -->
  <div class="content-bg">
    <div class="container">
      <section class="h-100 gradient-custom">
        <div class="container py-5 h-100">
          <div class="row child-center-flex h-100">
            <div class="col-lg-10 col-xl-8">
              <div class="card" style="border-radius: 10px;">
                <div class="card-header px-4 py-5">
                  <div class="row">
                    <div class="col">
                      <h5 class="text-muted mb-0">Thanks for your Order, <?php echo $orderDetail["dealerName"]; ?>!</h5>
                      <br />
                      <div class="col">
                        <?php if ($orderDetail["state"] != "F" && $orderDetail["state"] != "U") { ?>
                          <button class="cta" data-order-id="<?php echo $_POST["orderID"]; ?>">
                            <span>Delete this Order</span>
                            <svg width="15px" height="10px" viewBox="0 0 13 10">
                              <path d="M1,5 L11,5"></path>
                              <polyline points="8 1 12 5 8 9"></polyline>
                            </svg>
                          </button>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="lead fw-normal mb-0">Order ID: <?php echo str_pad($_POST["orderID"], 10, "0", STR_PAD_LEFT) ?></p>
                  </div>

                  <div class="d-flex justify-content-between mb-2">
                    <p class="fw-bold mb-0">Order Information</p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">
                        Order Date & Time
                        :
                      </span><?php echo $orderDetail["orderDateTime"] ?>
                    </p>
                  </div>
                  <?php if ($orderDetail["salesManagerID"] != null) {
                    $sql = "SELECT contactName,contactNumber FROM salemanager where salesManagerID = {$orderDetail["salesManagerID"]};";
                    $result = mysqli_query($conn, $sql);
                    $managerDetail = mysqli_fetch_assoc($result);
                  ?>
                    <div class="d-flex justify-content-between mb-2">
                      <p class="text-muted mb-0">
                        <span class="fw-bold me-4">
                          Manager’s Contact
                          Name:
                        </span><?php echo $managerDetail["contactName"] ?>
                      </p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <p class="text-muted mb-0">
                        <span class="fw-bold me-4">
                          Manager’s Contact
                          Number:
                        </span><?php echo $managerDetail["contactNumber"] ?>
                      </p>
                    </div>
                  <?php } ?>
                  <hr>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="fw-bold mb-0">Delivery Information</p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">Delivery Date</span><?php if ($orderDetail["deliveryDate"] == null) {
                                                                        echo "no delivery date";
                                                                      } else {
                                                                        echo $orderDetail["deliveryDate"];
                                                                      } ?>
                    </p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">
                        Delivery Address
                        :
                      </span><?php echo $orderDetail["deliveryAddress"]; ?>
                    </p>
                  </div>
                  <hr>
                  <?php
                  $sql = "SELECT ROUND(SUM(orderQty * weight), 2) as TW FROM orderspare os INNER JOIN spare s ON os.sparePartNum = s.sparePartNum WHERE orderID = {$_POST["orderID"]};";
                  $result = mysqli_query($conn, $sql);
                  $totalWeight = mysqli_fetch_assoc($result)["TW"];
                  ?>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="fw-bold mb-0">Item Information</p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">Total Order Item Quantity:</span> <?php echo $orderDetail["orderItemNumber"]; ?>
                    </p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">Total Order Item Weight:</span> <?php echo $totalWeight; ?> KG
                    </p>
                  </div>
                  <!-- table-->
                  <?php
                  $sql = "SELECT os.sparePartNum, orderQty,price, sparePartOrderPrice,sparePartName,sparePartImage FROM orderspare os inner join spare s on os.sparePartNum =s.sparePartNum where orderID={$_POST["orderID"]};";
                  $result = mysqli_query($conn, $sql);

                  ?>
                  <table id="item-report" class="table table-striped table-hover" data-toggle="table" data-flat="true" data-search="true">
                    <!-- table header -->
                    <thead class="table-light table-header">
                      <tr>
                        <th scope="col" style="width: 10%;" data-sortable="true">ID</th>
                        <th scope="col" style="width: 40%;" data-sortable="true">Name</th>
                        <th scope="col" style="width: 20%;text-align:center;">photo</th>
                        <th scope="col" style="width: 10%;" data-sortable="true">Unit Price</th>
                        <th scope="col" style="width: 10%;" data-sortable="true">Quantity</th>
                        <th scope="col" style="width: 10%;" data-sortable="true">Amount</th>
                      </tr>
                    </thead>
                    <!-- /table header -->
                    <!-- table body -->
                    <tbody>
                      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <!-- record -->
                        <tr>
                          <th scope="row"><?php echo $row["sparePartNum"]; ?></th>
                          <td><?php echo $row["sparePartName"]; ?></td>
                          <td>
                            <div class="table-img-box center-LR center-TB">
                              <img class="table-img" src="<?php echo $row["sparePartImage"]; ?>" />
                            </div>
                          </td>
                          <td><?php echo $row["price"]; ?></td>
                          <td><?php echo $row["orderQty"]; ?></td>
                          <td>$<?php echo $row["sparePartOrderPrice"]; ?></td>
                        </tr>
                        <!-- /record -->
                      <?php } ?>
                    </tbody>
                    <!-- table body -->
                  </table>
                  <!-- /table -->
                  <br>
                  <div class="row d-flex align-items-center">
                    <div class="col-md-2">
                      <p class="text-muted mb-0 small">Order Status</p>
                    </div>
                    <div class="col-md-10">
                      <div class="progress" style="height: 6px; border-radius: 16px;">
                        <div class="progress-bar" role="progressbar" style="width: <?php if ($orderDetail["state"] == "R" || $orderDetail["state"] == "U" || $orderDetail["state"] == "F") {
                                                                                      echo "100";
                                                                                    } elseif ($orderDetail["state"] == "A") {
                                                                                      echo "35";
                                                                                    } elseif ($orderDetail["state"] == "T") {
                                                                                      echo "65";
                                                                                    } else {
                                                                                      echo "10";
                                                                                    } ?>%;--bs-progress-bar-bg:<?php if ($orderDetail["state"] == "R" || $orderDetail["state"] == "U") {
                                                                                                                  echo "red";
                                                                                                                } else {
                                                                                                                  echo "cornflowerblue";
                                                                                                                } ?>;"></div>
                      </div>
                      <div class="d-flex justify-content-between mb-1">
                        <p class="text-muted mt-1 mb-0 small ">Create Order</p>
                        <?php if ($orderDetail["state"] != "R" && $orderDetail["state"] != "U") { ?>
                          <p class="text-muted mt-1 mb-0 small ">Accept</p>
                          <p class="text-muted mt-1 mb-0 small ">In Transmit</p>
                        <?php } ?>
                        <p class="text-muted mt-1 mb-0 small ">this order is <?php if ($orderDetail["state"] == "R") {
                                                                                echo "rejected";
                                                                              } elseif ($orderDetail["state"] == "U") {
                                                                                echo "unavailable";
                                                                              } else {
                                                                                echo "finished";
                                                                              } ?> </p>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="card-footer border-0 px-4 py-5">
                  <div class="row mb-2" style="color: white;">
                    <h2>Payment Details</h2>
                    <div class="col">
                      <h4>payment status: <?php echo $orderDetail["isPaid"] ? "paid" : "arrearage"; ?></h4>
                      <?php if ($orderDetail["isPaid"]) { ?>
                        <div class="cell"><b>Receipt: </b><a href="../../images/receipt/<?php echo $orderDetail["receipt"]; ?>" class="white-link" target="_blank">View Receipt</a></div>
                      <?php } elseif (!$orderDetail["isPaid"] && $orderDetail["state"] != "R" && $orderDetail["state"] != "U") { ?>
                        <button type="button" class="btn btn-warning" id="btnPayByFps">Pay by FPS</button>
                      <?php } ?>
                    </div>
                    <div class="col">
                      <div class="cell text-end"><b>Subtotal: </b> $<?php echo $orderDetail["TotalAmount"]; ?></div>
                      <div class="cell text-end"><b>Delivery Fee: </b> $<?php echo $orderDetail["shipCost"]; ?></div>
                      <div class="cell text-end" style="font-size:2rem"><b>Total Payment: </b> <span class="double-bottom-line" style="border-bottom-color:white">$<?php echo $orderDetail["TotalAmount"] + $orderDetail["shipCost"]; ?></span></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </section>
    </div>
  </div>
  <!-- /content -->
  <footer>

    <!-- link -->

    <ul class="sns">
      <!--         <li><a href="https://twitter.com/lycoris_recoil" target="_blank"><img src="images/common/icon_x.png" alt="twitter/X"></a></li>
            <li><a href="https://www.pixiv.net/users/83515809" target="_blank"><img src="images/common/icon_pixiv.png" alt="pixiv"></a></li> -->
    </ul>

    <!-- /link -->
    <p>© <?php echo date("Y"); ?> Smart & Luxury Motor Spares inc.</p>
  </footer>
  <?php if (!$orderDetail["isPaid"] && $orderDetail["state"] != "R" && $orderDetail["state"] != "U") { ?>
    <!-- pop up -->
    <div class="modal" tabindex="-1" id="myModal">
      <form method="post" name="receiptForm" id="receiptForm" enctype="multipart/form-data">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Use FPS to Pay</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row mb-2">
                <label for="receipt-img-input" class="form-label">Please scan the FPS QR-code on the right to pay, then select or drop the receipt below</label>
                <div class="col">
                  <input type="hidden" name="orderID" value="<?php echo $_POST["orderID"] ?>">
                  <input class="form-control" type="file" name="receiptUpload" id="receipt-img-input">
                  <p style="color: red;" id="receipt-input-error"></p>
                </div>
                <div class="col">
                  <div id="qrcode" data-price="<?php echo $orderDetail["TotalAmount"] + $orderDetail["shipCost"]; ?>"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Upload receipt</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- /pop up -->
  <?php } ?>
  <!-- return top -->

  <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png"></a>
  </div>

  <!-- /return top -->
</body>

</html>