﻿<!DOCTYPE html>
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
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

  <title>Update Information</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/reset.css">
  <link rel="stylesheet" href="../../css/common.css">
  <link rel="stylesheet" href="../../css/bs/bootstrap.css">
  <!-- /css -->
  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/common.js"></script>
  <script src="../../js/dealer/dealer_information_update.js"></script>
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
  <br>
  <?php
  $userID = $_SESSION['userID'];
  $sql = "SELECT d.* FROM dealer d INNER JOIN user u ON d.dealerID = u.dealerID WHERE u.userID = $userID";
  $result = mysqli_query($conn, $sql);
  $dealer = mysqli_fetch_array($result);
  $dealerIDFormatted = sprintf('%06d', $dealer['dealerID']);
  mysqli_close($conn);
  ?>

  <div class="d-flex position-relative content-bg justify-content-center">
    <div class="container content-wrap">
      <br>
      <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
          <div class="col-md-3 border-right child-center-TB">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
              <span class="font-weight-bold rounded-circle mt-5"><?php echo $dealer['dealerName']; ?></span>
              <span class="text-black-50"><?php echo $dealerIDFormatted; ?></span>
            </div>
          </div>
          <div class="col-md-5 border-right">
            <div class="p-3 py-5">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-right">Your Information</h4>
              </div>
              <div class="row mt-2">
                <div class="col-md-12">
                  <label class="labels">Name</label>
                  <input type="text" class="form-control" placeholder="Dealer name" value="<?php echo $dealer['dealerName']; ?>" disabled>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-12">
                  <label class="labels">Contact Name</label>
                  <input type="text" id="contactName" class="form-control" value="<?php echo $dealer['contactName']; ?>">
                </div>
                <div class="col-md-12">
                  <label class="labels">Contact Number</label>
                  <input type="text" id="contactNumber" oninput="value=value.replace(/[^\d]/g,'')" class="form-control" value="<?php echo $dealer['contactNumber']; ?>">
                </div>
                <div class="col-md-12">
                  <label class="labels">Fax Number</label>
                  <input type="text" id="faxNumber" oninput="value=value.replace(/[^\d]/g,'')" class="form-control" value="<?php echo $dealer['faxNumber']; ?>">
                </div>
                <div class="col-md-12">
                  <label class="labels">Delivery Address</label>
                  <input type="text" id="deliveryAddress" class="form-control" value="<?php echo $dealer['deliveryAddress']; ?>">
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-md-6 d-flex child-center-LR">
                  <button class="btn btn-primary profile-button" type="button" onclick="confirmEdition(contactName.value, contactNumber.value, faxNumber.value, deliveryAddress.value, <?php echo $dealer['dealerID']; ?>)">
                    Confirm Your Edition
                  </button>
                </div>
                <div class="col-md-6 d-flex child-center-LR">
                  <a href="dealer_reset_passwd.php">
                    <button class="btn btn-primary profile-button" type="button">
                      Reset Password
                    </button>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
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
          <div class="modal-footer " id="modal-footer">
            <button type="button" id="showModalButton" class="btn btn-secondary " onclick="$('#myModal').modal('hide');">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <p>© <?php echo date("Y"); ?> Smart & Luxury Motor Spares inc.</p>
  </footer>
  <!-- return top -->

  <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png" /></a>
  </div>

  <!-- /return top -->
</body>

</html>