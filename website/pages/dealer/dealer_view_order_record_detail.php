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
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

  <title>Order Deatil</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/reset.css">
  <link rel="stylesheet" href="../../css/common.css">
  <link rel="stylesheet" href="../../css/bs/bootstrap.css">
  <link rel="stylesheet" href="../../css/dealer_view_orderrecord_token.css">
  <link rel="stylesheet" href="../../css/dealer_view_orderrecord.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/bootstrap-table.min.css">
  <!-- /css -->

  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../../js/common.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/add_itemm.js"></script>
  <script src="../../js/dealer_view_orderrecord_token.js"></script>
  <script src="../../js/view_order_record.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/bootstrap-table.min.js"></script>
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
                      <h5 class="text-muted mb-0">Thanks for your Order, <a>(dealername)</a>!</h5>
                      <br />
                      <div class="col">
                        <a href="./dealer_delete_order.php">
                          <button class="cta">
                            <span>Delete this Order</span>
                            <svg width="15px" height="10px" viewBox="0 0 13 10">
                              <path d="M1,5 L11,5"></path>
                              <polyline points="8 1 12 5 8 9"></polyline>
                            </svg>
                          </button>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="lead fw-normal mb-0">Order ID: (Order ID)</p>
                  </div>

                  <div class="d-flex justify-content-between mb-2">
                    <p class="fw-bold mb-0">Order Information</p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">
                        Order Date & Time
                        :
                      </span>22 Dec,2019(12:00)
                    </p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">
                        Manager’s Contact
                        Name:
                      </span>name
                    </p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">
                        Manager’s Contact
                        Number:
                      </span>27272727
                    </p>
                  </div>
                  <hr>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="fw-bold mb-0">Delivery Information</p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">Delivery Date</span> 22
                      Dec,2020
                    </p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">
                        Delivery Address
                        :
                      </span>your home
                    </p>
                  </div>
                  <hr>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="fw-bold mb-0">Item Information</p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">Total Order Item Quantity:</span> 20
                    </p>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">
                      <span class="fw-bold me-4">Total Order Item Weight:</span> 15 KG
                    </p>
                  </div>
                  <!-- table-->
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
                        <!-- record -->
                        <tr>
                          <th scope="row">100001</th>
                          <td>idk</td>
                          <td>
                            <div class="table-img-box center-LR center-TB">
                              <img class="table-img" src="../../images/item/100001.jpg" />
                            </div>
                          </td>
                          <td>120</td>
                          <td>10</td>
                          <td>$1200</td>
                        </tr>
                        <!-- /record -->
                        <!-- record -->
                        <tr>
                          <th scope="row">200002</th>
                          <td>Name</td>
                          <td>
                            <div class="table-img-box center-LR center-TB">
                              <img class="table-img" src="../../images/item/200002.jpg" />
                            </div>
                          </td>
                          <td>150</td>
                          <td>10</td>
                          <td>$1500</td>
                        </tr>
                        <!-- /record -->
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
                        <div class="progress-bar" role="progressbar" style="width: 20%;--bs-progress-bar-bg:cornflowerblue;"></div>
                      </div>
                      <div class="d-flex justify-content-around mb-1">
                        <p class="text-muted mt-1 mb-0 small ms-xl-5">Create Order</p>
                        <p class="text-muted mt-1 mb-0 small ms-xl-5">Accept</p>
                        <p class="text-muted mt-1 mb-0 small ms-xl-5">In Transmit</p>
                        <p class="text-muted mt-1 mb-0 small ms-xl-5">this order is finished</p>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="card-footer border-0 px-4 py-5">
                <div class="row mb-2" style="color: white;">
                    <h2>Payment Details</h2>
                    <div class="col">
                      <div class="cell"><b>Subtotal: </b> [item total price]</div>
                      <div class="cell"><b>Delivery Fee: </b> [Delivery Fee]</div>
                      <div class="cell" style="font-size:2rem"><b>Total Payment: </b> <span class="double-bottom-line" style="border-bottom-color:white">$2700</span></div>
                    </div>

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
  <!-- return top -->

  <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png"></a>
  </div>

  <!-- /return top -->
</body>

</html>