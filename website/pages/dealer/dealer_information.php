﻿<!DOCTYPE html>
<html>
<?php
session_start();

if(isset($_SESSION['expire'])){
  if($_SESSION['expire'] < time()){
    session_destroy();
    header('Location: ../../index.php');
  }else{
    $_SESSION['expire'] = time() + (30 * 60);
    require_once 'db/dbconnect.php';
  }
}else{
  session_destroy();
  header('Location: ../../index.php');
}
?>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

  <title>Information</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/reset.css">
  <link rel="stylesheet" href="../../css/common.css">
  <link rel="stylesheet" href="../../css/bs/bootstrap.css">
  <!-- /css -->
  <!-- js -->
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/dealer_information.js"></script>
  <!-- /js -->
</head>

<body>
  <div class="fixed-top">
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid justify-content-center">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-wrap" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="./search_item.php">Our Product</a>
            </li>
          </ul>
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex flex-nowrap align-items-center" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
              Hi [username]<span class="note-label">99+</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="./dealer_information.php">Your Information</a></li>
              <li><a class="dropdown-item" href="./view_order_record.php">Your Order</a></li>
              <li>
                <a class="dropdown-item position-relative d-flex flex-nowrap" href="./dealer_cart.php">
                  Cart<span class="cart-number-label">99+</span>
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
  <hr style="border: rgb(103, 149, 255) 10px solid;" class="content">
  <div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
      <div class="col-md-3 border-right child-center-TB">
        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
          <span class="font-weight-bold rounded-circle mt-5">(dealer name)</span><span class="text-black-50">
            (dealer
            ID)
          </span><span> </span>
        </div>
      </div>
      <div class="col-md-5 border-right">
        <div class="p-3 py-5">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Your Imformation</h4>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
              <label class="labels">Name</label><input type="text" class="form-control" placeholder="Delaer name"
                     value="" disabled>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <label class="labels">Contact Name</label><input type="text" class="form-control"  disabled>
            </div>
            <div class="col-md-12">
              <label class="labels">Contant Number</label><input type="text" class="form-control" disabled>
            </div>
            <div class="col-md-12">
              <label class="labels">Fax Number</label><input type="text" class="form-control"  disabled>
            </div>
            <div class="col-md-12">
              <label class="labels">Delivery Address</label><input type="text" class="form-control"
                     placeholder="come form database" value="" disabled>
            </div>
          </div>
          <div class="mt-5 text-center">
              <a href="dealer_information_update.php">
                  <button class="btn btn-primary profile-button" type="button">
                      Edit Your Information
                  </button>
              </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>

    <!-- link -->

    <ul class="sns">
      <!--         <li><a href="https://twitter.com/lycoris_recoil" target="_blank"><img src="images/common/icon_x.png" alt="twitter/X"></a></li>
                    <li><a href="https://www.pixiv.net/users/83515809" target="_blank"><img src="images/common/icon_pixiv.png" alt="pixiv"></a></li> -->
    </ul>

    <!-- /link -->
    <p>© 2024 Smart & Luxury Motor Spares inc.</p>
  </footer>
    <!-- return top -->

    <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png" /></a>
  </div>

  <!-- /return top -->
</body>

</html>