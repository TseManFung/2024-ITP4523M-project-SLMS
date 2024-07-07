<!DOCTYPE html>
<html>
<?php
session_start();
if(isset($_SESSION['expire'])){
  if($_SESSION['expire'] < time()){
    session_destroy();
    header('Location: ../../index.php');
  }else{
    $_SESSION['expire'] = time() + (30 * 60);
    require_once '../db/dbconnect.php';
  }
}else{
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
  <script src="../../js/common.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/checkout.js"></script>
  <script src="../../js/dealer_template_resetpasswd.js"></script>
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

  <!-- header -->
  <div style="height: calc(0lvh + 56px)" id="header"></div>
  <!-- /header -->

  <!-- content -->
  <div class="d-flex position-relative content-bg justify-content-center">
    <div class="container content-wrap">
      <br />
      <div class="container">
        <div class="py-5 text-center">
          <h2>Checkout</h2>
        </div>
        <div class="row">
          <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted">Your cart</span>
              <span class="badge badge-secondary badge-pill">3</span>
            </h4>
            <ul class="list-group mb-3 sticky-top">
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/100001.jpg" />
                </div>
                <div>
                  <h6 class="my-0">Spare name</h6>
                  <small class="text-muted">Quantity:10</small>
                </div>
                <span class="text-muted">$1000</span>
              </li>
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/100002.jpg" />
                </div>
                <div>
                  <h6 class="my-0">Spare name</h6>
                  <small class="text-muted">Quantity:2</small>
                </div>
                <span class="text-muted">$200</span>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                  <div class="d-grid gap-2 d-md-block">
                      <a href="./dealer_cart.php">
                      <button type="button" data-mdb-button-init data-mdb-ripple-init
                              class="btn btn-primary btn-block btn-lg">
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
            <h4 class="mb-3">Your order information:</h4>
            <form class="needs-validation" novalidate="" action="./dealer_view_order_record_detail.php" method="get">
                <div class="row">
                    <div class="mb-3">
                        <label for="address"> Your order ID:</label>
                        <input type="text" class="form-control" id="Order-ID" value="12132120220512" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="address"> Order Date & Time:</label>
                        <input type="text" class="form-control" id="Order-D-T" value="2022/01/01" disabled>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address"> Order Quantity:</label>
                    <input type="text" class="form-control" id="Order-Quantity" value="12" disabled>
                </div>
                <div class="mb-3">
                    <label for="address">Order Price:</label>
                    <input type="text" class="form-control" id="Order-Price" value="$1234" disabled>
                </div>
                <div class="mb-3">
                    <label for="address">Order Amount:</label>
                    <input type="text" class="form-control" id="Order-Amount" value="$1234" disabled>
                </div>
                <div class="mb-3">
                    <label for="address">Delivery Fee:</label>
                    <input type="text" class="form-control" id="Delivery-Fee" value="$10000" disabled>
                </div>
                <div class="row">
                    <div class=" mb-3">
                        <label for="zip">Total Order Amount:</label>
                        <input type="text" class="form-control" value="$11234" id="Total-Order-Amount" placeholder="" disabled>
                    </div>
                </div>
                <h4 class="mb-3">Please enter information to create an order</h4>
                <div class="mb-3">
                    <label for="address">Delivery Address </label>
                    <input type="text" class="form-control" id="address" placeholder="Delivery Address" value="Delivery Address get from database" required>
                    <div class="invalid-feedback"> Please enter your shipping address. </div>
                </div>
                <div class="mb-3">
                    <label for="address2">Please choose a Delivery Date <span class="text-muted"></span></label>
                    <section class="container">
                        <!-- use js to make min and max date -->
                        <input type="date" id="start" name="trip-start" value="2024-07-22" min="2024-01-01"
                               max="2024-12-31" />
                    </section>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
          </div>
        </div>
        <ul class="list-inline">
        </ul>
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
    <p>© 2024 Smart & Luxury Motor Spares inc.</p>
  </footer>

  <!-- return top -->

  <div id="page-top">
    <a href="#header"><img src="../../images/common/returan-top.png" /></a>
  </div>

  <!-- /return top -->
</body>

</html>