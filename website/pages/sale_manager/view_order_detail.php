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

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />

  <title>Order detail</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="../../css/reset.css" />
  <link rel="stylesheet" href="../../css/common.css" />
  <link rel="stylesheet" href="../../css/bs/bootstrap.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/bootstrap-table.min.css">
  <!-- /css -->

  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../../js/common.js"></script>
  <script src="../../js/sale_manager/view_order_detail.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/bootstrap-table.min.js"></script>
  <!-- /js -->
</head>
<?php
$sql = "SELECT o.orderDateTime, o.deliveryAddress, o.deliveryDate, o.salesManagerID, o.dealerID, o.orderItemNumber, o.TotalAmount, o.shipCost, o.state, d.dealerName, d.contactNumber FROM `order` o inner join dealer d on o.dealerID = d.dealerID where orderID = {$_POST["orderID"]};";
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
              <a class="nav-link" href="./view_item.php">Item</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./view_order.php">Order</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./item_report_condition.php">Report</a>
            </li>

          </ul>
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../../index.php" style="color: red;">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- /navbar -->
  </div>

  <!-- header -->
  <div style="height: calc(0lvh + 56px)" id="header"></div>
  <!-- /header -->

  <!-- content -->
  <div class="content-bg">
    <div class="container content-wrap">
      <section class="h-100 gradient-custom">
        <div class="container py-5 h-100">
          <div class="row child-center-flex h-100">
            <div class="col-lg-10 col-xl-8">
              <div class="card" style="border-radius: 10px;">
                <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="lead fw-normal mb-0">Order ID: <?php echo str_pad($_POST["orderID"], 10, "0", STR_PAD_LEFT) ?></p>
                    <p class="small text-muted mb-0">Sales Manager ID: <?php if ($orderDetail["salesManagerID"] == null) {
                                                                          echo "no sale Manager";
                                                                        } else {
                                                                          echo str_pad($orderDetail["salesManagerID"], 10, "0", STR_PAD_LEFT);
                                                                        } ?></p>
                  </div>
                  <!-- order detail -->
                  <div>
                    <div class="row mb-2">
                      <h2>Order Detail</h2>
                      <div class="col-6">
                        <?php if ($orderDetail["salesManagerID"] != null) {
                          $sql = "SELECT managerName,contactNumber FROM salemanager where salesManagerID = {$orderDetail["salesManagerID"]};";
                          $result = mysqli_query($conn, $sql);
                          $managerDetail = mysqli_fetch_assoc($result);
                        ?>
                          <div class="cell"><b>Manager's Name:</b> <?php echo $managerDetail["managerName"] ?></div>
                          <div class="cell"><b>Manager's Contact Number:</b> <?php echo $managerDetail["contactNumber"] ?> </div><?php } ?>
                        <div class="cell"><b>Order Date & Time:</b> <?php echo $orderDetail["orderDateTime"] ?></div>
                        <div class="cell"><b>Delivery Date:</b> <?php if ($orderDetail["deliveryDate"] == null) {
                                                                  echo "no delivery date";
                                                                } else {
                                                                  echo $orderDetail["deliveryDate"];
                                                                } ?></div>
                      </div>
                      <div class="col-6">
                        <div class="cell"><a href="./dealer_information.php?DID=<?php echo $orderDetail["dealerID"]; ?>"><button type="button" class="btn btn-link p-0"><b>Dealer ID:</b>
                              <?php echo str_pad($orderDetail["dealerID"], 10, "0", STR_PAD_LEFT); ?></button></a></div>
                        <div class="cell"><b>Dealer Name:</b> <?php echo $orderDetail["dealerName"]; ?> </div>
                        <div class="cell"><b>Dealer Contact Number:</b> <?php echo $orderDetail["contactNumber"]; ?></div>

                      </div>
                      <div class="cell"><b>Delivery Address:</b>
                        <address>
                          <?php echo $orderDetail["deliveryAddress"]; ?>
                        </address>
                      </div>
                    </div>
                    <div class="row d-flex align-items-center">
                      <div class="col-md-2">
                        <h5 class="text-muted mb-0">Order Status</h5>
                      </div>
                      <div class="col-md-10">
                        <div class="progress" style="height: 6px; border-radius: 16px;">
                          <div class="progress-bar" role="progressbar" style="width: <?php if ($orderDetail["state"] == "R" || $orderDetail["state"] == "U" || $orderDetail["state"] == "F") {
                                                                                        echo "100";
                                                                                      } elseif ($orderDetail["state"] == "A") {
                                                                                        echo "65";
                                                                                      } elseif ($orderDetail["state"] == "T") {
                                                                                        echo "42.5";
                                                                                      } else {
                                                                                        echo "20";
                                                                                      } ?>%;--bs-progress-bar-bg:<?php if ($orderDetail["state"] == "R" || $orderDetail["state"] == "U") {
                                                                                                                    echo "red";
                                                                                                                  } else {
                                                                                                                    echo "cornflowerblue";
                                                                                                                  } ?>;"></div>
                        </div>
                        <div class="d-flex justify-content-around mb-1">
                          <p class="text-muted mt-1 mb-0 small ms-xl-5">Create Order</p>
                          <?php if ($orderDetail["state"] != "R" || $orderDetail["state"] != "U") { ?>
                            <p class="text-muted mt-1 mb-0 small ms-xl-5">Accept</p>
                            <p class="text-muted mt-1 mb-0 small ms-xl-5">In Transmit</p>
                          <?php } ?>
                          <p class="text-muted mt-1 mb-0 small ms-xl-5">this order is <?php if ($orderDetail["state"] == "R") {
                                                                                        echo "rejected";
                                                                                      } elseif ($orderDetail["state"] == "U") {
                                                                                        echo "unavailable";
                                                                                      } else {
                                                                                        echo "finished";
                                                                                      } ?> </p>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <?php
                    $sql = "SELECT ROUND(SUM(orderQty * weight), 2) as TW FROM orderspare os INNER JOIN spare s ON os.sparePartNum = s.sparePartNum WHERE orderID = {$_POST["orderID"]};";
                    $result = mysqli_query($conn, $sql);
                    $totalWeight = mysqli_fetch_assoc($result)["TW"];
                    ?>
                    <p><b>Total Order Item Quantity:</b> <?php echo $orderDetail["orderItemNumber"]; ?></p>
                    <p><b>Total Order Item Weight:</b> <?php echo $totalWeight; ?> KG</p>
                    <!-- table-->
                    <?php
                    $sql = "SELECT os.sparePartNum, orderQty, sparePartOrderPrice,sparePartName,sparePartImage FROM orderspare os inner join spare s on os.sparePartNum =s.sparePartNum where orderID={$_POST["orderID"]};";
                    $result = mysqli_query($conn, $sql);

                    ?>
                    <table id="item-report" class="table table-striped table-hover" data-toggle="table" data-flat="true" data-search="true">
                      <!-- table header -->
                      <thead class="table-light table-header">
                        <tr>
                          <th scope="col" style="width: 10%;" data-sortable="true">ID</th>
                          <th scope="col" style="width: 40%;" data-sortable="true">Name</th>
                          <th scope="col" style="width: 20%;text-align:center;">photo</th>
                          <th scope="col" style="width: 10%;" data-sortable="true">Price</th>
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
                            <td><?php echo $row["sparePartOrderPrice"]; ?></td>
                            <td><?php echo $row["orderQty"]; ?></td>
                            <td>$<?php echo $row["sparePartOrderPrice"] * $row["orderQty"]; ?></td>
                          </tr>
                          <!-- /record -->
                        <?php } ?>
                      </tbody>
                      <!-- table body -->
                    </table>
                    <!-- /table -->
                  </div>
                  <!-- /order detail -->
                  <hr>

                </div>
                <div class="card-footer border-0 px-4 py-5" style="background-color: #fff !important;">
                  <div class="row mb-2">
                    <h2>Payment Details</h2>
                    <div class="col">
                      <div class="cell text-end"><b>Subtotal: </b> $<?php echo $orderDetail["TotalAmount"]; ?></div>
                      <div class="cell text-end"><b>Delivery Fee: </b> $<?php echo $orderDetail["shipCost"]; ?></div>
                      <div class="cell text-end" style="font-size:2rem"><b>Total Payment: </b> <span class="double-bottom-line">$<?php echo $orderDetail["TotalAmount"] + $orderDetail["shipCost"]; ?></span></div>
                    </div>

                  </div>
                </div>
                <br>

                <br>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="row">
        <div class="cell child-center-LR">
          <button type="button" class="btn btn-primary m-2" onclick="show_edit_status()">Edit Spare Status</button>

          <button type="button" class="btn btn-success m-2">Accept</button>

          <button type="button" class="btn btn-danger  m-2">Reject</button>
        </div>
        <br>
        <div class="alert alert-secondary position-relative" role="alert" id="edit_status">
          <div class="form-floating">
            <select class="form-select" id="status_selecter">
              <option value="C" selected>[Current status (get by js)]</option>
              <option value="T">In Transmit</option>
              <option value="U">Unavailable</option>
              <option value="F">Finished</option>
            </select>
            <label for="status_selecter">Status</label>
          </div><br><br>
          <div class="position-absolute bottom-0 end-0 m-2">
            <button type="button" class="btn btn-primary" onclick="">Save</button>
            <button type="button" class="btn btn-secondary" onclick="Cancel()">Cancel</button>
          </div>

        </div>
      </div>
    </div>

  </div>
  </div>
  <!-- <img src="../../images/menu/chisato.png"> -->
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
  <!-- return top -->

  <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png" /></a>
  </div>

  <!-- /return top -->
</body>

</html>