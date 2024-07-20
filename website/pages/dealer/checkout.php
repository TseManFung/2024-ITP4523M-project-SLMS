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

  <title>Check Out</title>

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
  <script src="../../js/common.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/checkout.js"></script>
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
  <div style="height: calc(0lvh + 56px)" id="header"></div>
  <!-- /header -->

  <!-- content -->
  <div class="d-flex position-relative content-bg justify-content-center">
    <div class="container content-wrap">
      <br />
      <div>
        <div class="py-5 text-center">
          <h2>Checkout</h2>
        </div>
        <div class="card" style="padding:2rem;">
          <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
  <!--             <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">3</span>
              </h4> -->
              <ul class="list-group mb-3 sticky-top">
                <?php
                $userID = $_SESSION['userID'];
                $sql = "SELECT cart.userID, cart.qty, cart.sparePartNum, spare.sparePartName, spare.category, spare.price, spare.sparePartImage, spare.weight, spare.state 
              FROM cart 
              JOIN spare ON cart.sparePartNum = spare.sparePartNum 
              WHERE cart.userID = $userID;";
                $result = mysqli_query($conn, $sql);
                $totalWeight = 0;
                $subTotal = 0;
                $itemTotalqty = 0;
                $Qty = 0;
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_array($result)) {
                    $itemTotalqty += $row['qty'];
                    $itemTotalPrice = $row['qty'] * $row['price'];
                    $subTotal += $itemTotalPrice;
                    printf(
                      '<li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div class="order-img">
                      <img class="order-abs-img img-100" src="%s" />
                    </div>
                    <div>
                      <h6 class="my-0">%s</h6>
                      <small class="text-muted">Quantity:%d</small>
                    </div>
                    <span class="text-muted">$%d</span>
                  </li>',
                      $row['sparePartImage'],
                      $row['sparePartName'],
                      $row['qty'],
                      $itemTotalPrice
                    );
                  }
                }
                ?>
                <?php
                $sql = "SELECT SUM(cart.qty) AS total_quantity, GROUP_CONCAT(spare.sparePartName) AS sparePartNames, GROUP_CONCAT(spare.category) AS categories, GROUP_CONCAT(spare.price) AS prices FROM cart JOIN spare ON cart.sparePartNum = spare.sparePartNum WHERE cart.userID = $userID";
                $result = mysqli_query($conn, $sql);
                $cart = mysqli_fetch_array($result);
                ?>
                <li class="list-group-item d-flex justify-content-between">
                  <div class="d-grid gap-2 d-md-block">
                    <a href="./dealer_cart.php">
                      <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg">
                        <div class="d-flex justify-content-between">
                          <span>View your cart</span>
                        </div>
                      </button>
                    </a>
                  </div>
                </li>
              </ul>
            </div>
            <div class="col-md-8 order-md-1">
              <h4 class="mb-3">Order information:</h4>
              <div class="row">
                <div class="mb-3">
                  <label for="address"> Order Date & Time:</label>
                  <input type="text" class="form-control" id="Order-D-T" value="" disabled>
                </div>
              </div>
              <div class="mb-3">
                <label for="address"> Order Item Quantity:</label>
                <input type="text" class="form-control" id="Order-Quantity" value="<?php echo $cart['total_quantity']; ?>" total-qty="<?php echo $cart['total_quantity']; ?>" disabled>
              </div>
              <?php
              $sql = "SELECT cart.userID, cart.qty, cart.sparePartNum ,spare.sparePartName, spare.category, spare.price, spare.sparePartImage, spare.sparePartDescription, spare.weight, spare.state 
                                                        FROM cart 
                                                        JOIN spare ON cart.sparePartNum = spare.sparePartNum 
                                                        WHERE cart.userID = $userID;";
              $result = mysqli_query($conn, $sql);
              $totalWeight = 0;
              $subTotal = 0;
              $itemTotalqty = 0;
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                  $itemTotalqty += $row['qty'];
                  $itemTotalPrice = $row['qty'] * $row['price'];
                  $subTotal += $itemTotalPrice;
                  $totalWeight += $row['qty'] * $row['weight'];
                  $subTotalFormatted = number_format($subTotal, 2, '.', '');
                }
              }
              ?>
              <div class="mb-3">
                <label for="address">Total Weight:</label>
                <input type="text" class="form-control" id="Order-Weight" value="<?php echo $totalWeight; ?> KG" total-weight=<?php echo $totalWeight; ?> disabled>
              </div>
              <div class="mb-3">
                <label for="address">Total Item Amount:</label>
                <input type="text" class="form-control" id="Order-Amount" value="$<?php echo $subTotalFormatted; ?>" total-amount="<?php echo $subTotal; ?>.toFixed(2)" disabled>
              </div>
              <div class="mb-3">
                <label for="address">Delivery Fee:</label>
                <input type="text" class="form-control" id="Delivery-Fee" value="" disabled>
              </div>
              <div class="row">
                <div class=" mb-3">
                  <label for="zip">Total Order Amount:</label>
                  <input type="text" class="form-control" value="$11234" id="Total-Order-Amount" placeholder="" disabled>
                </div>
              </div>
            </div>
          </div>
        </div>
        <h4 class="mb-3">Please enter delivery address</h4>
        <?php

        $sql = "SELECT SUM(cart.qty) AS total_quantity, d.dealerID, d.deliveryAddress FROM cart JOIN spare ON cart.sparePartNum = spare.sparePartNum JOIN `user` u ON cart.userID = u.userID JOIN dealer d ON u.dealerID = d.dealerID WHERE cart.userID = $userID";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        mysqli_close($conn);
        ?>
        <div class="mb-3">
          <label for="address">Delivery Address </label>
          <input type="text" class="form-control" id="address" placeholder="Delivery Address" value="<?php echo $row['deliveryAddress']; ?>" required>
          <div class="invalid-feedback"> Please enter your shipping address. </div>
        </div>
        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit" onclick="checkout(<?php echo $row['dealerID']; ?>,<?php echo $row['total_quantity']; ?>)">Continue to checkout</button>


        <ul class="list-inline">
        </ul>
      </div>
    </div>
  </div>

  <!-- message box-->
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
          <button type="button" id="showModalButton" class="btn btn-secondary" onclick="closeModal()">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- /message box -->
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

  <div id="page-top">
    <a href="#header"><img src="../../images/common/returan-top.png" /></a>
  </div>

  <!-- /return top -->
</body>

</html>