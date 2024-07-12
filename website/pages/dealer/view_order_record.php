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

  <title>Order Record</title>

  <!-- css -->
  <!-- icon -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="../../css/reset.css" />
  <link rel="stylesheet" href="../../css/common.css" />
  <link rel="stylesheet" href="../../css/bs/bootstrap.css" />
  <link rel="stylesheet" href="../../css/dealer_view_orderrecord.css" />
  <!-- /css -->
  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script src="../../js/common.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/view_order_record.js"></script>
  <script src="../../js/search_item.js"></script>
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
  <!-- search-bar -->
  <div style="height: calc(20lvh + 74px)" id="header" class="d-flex position-relative justify-content-center align-items-center">
    <div class="position-relative start-0 end-0 d-flex justify-content-center" style="margin-top: 10px">
      <div class="position-relative d-flex search-bar" role="search">
        <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="search-input" value="<?php if (isset($_GET["search"])) {
                                                                                                                      echo $_GET["search"];
                                                                                                                    } ?>" />
        <div class="search-box" id="search-box">
          <i class="fa-solid fa-magnifying-glass fa-xl"></i>
        </div>
      </div>
    </div>
  </div>
  <!-- /search-bar -->
  <!-- /header -->
  <!-- content -->
  <div class="d-flex position-relative content-bg justify-content-center">
    <div class="container content-wrap">
      <br />
      <div class="row row--top-40">
        <div class="col-md-4">
          <h2 class="row__title">Order(2)</h2>
        </div>
        <div class="col d-flex justify-content-center align-items-end">
          <nav aria-label="Page navigation">
            <ul class="pagination page-nav" style="margin-bottom: 0">
              <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li class="page-item active">
                <a class="page-link" href="#">1</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">2</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">3</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-md-4 position-relative">
          <div class="form-floating position-absolute bottom-0 end-0" style="padding-right: 12px">
            <select class="form-select" id="sort">
              <option value="NA">Newest Arrivals</option>
              <option value="PLH">Price: Low to High</option>
              <option value="PHL">Price: High to Low</option>
            </select>
            <label for="sort">Sort</label>
          </div>
        </div>
      </div>
      <br />
      <div class="row">
        <div id="order" class="col item-wrap list d-flex" style="background-color:#fff">
          <!-- table header -->
          <div class="row item-box table-header">
            <div class="col-2">Order ID</div>
            <div class="col-3">Order Date & Time</div>
            <div class="col-2">Order Status</div>
            <div class="col-3">Total Amount</div>
            <div class="col-2"></div>
            <hr class="z-1" />
          </div>
          <!-- /table header -->

          <!-- item(order record) -->
          <div class="row item-box table-content">
            <div class="col-10">
              <div class="row table-content-data">
                <div class="col" style="width: 20%">0123456789</div>
                <div class="col" style="width: 30%">16/05/2024 | 16:00</div>
                <div class="col" style="width: 20%">Create</div>
                <div class="col" style="width: 30%">$12345</div>

              </div>
              <div class="d-flex">
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/100001.jpg" />
                </div>
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/200002.jpg" />
                </div>
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/300003.jpg" />
                </div>
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/400004.jpg" />
                </div>
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/100004.jpg" />
                </div>
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/200004.jpg" />
                </div>
                <div class="order-img order-2many-item">
                  <img class="order-abs-img" src="../../images/item/300004.jpg" />
                </div>
              </div>
            </div>
            <div class="col-2">
              <button class="cta">
                <span>View more</span>
                <svg width="15px" height="10px" viewBox="0 0 13 10">
                  <path d="M1,5 L11,5"></path>
                  <polyline points="8 1 12 5 8 9"></polyline>
                </svg>
              </button>
            </div>
            <hr class="z-1" />
          </div>
          <!-- /item(order record) -->

          <!-- item(order record) -->
          <div class="row item-box table-content">
            <div class="col-10">
              <div class="row table-content-data">
                <div class="col" style="width: 20%">0123456789</div>
                <div class="col" style="width: 30%">16/05/2024 | 16:00</div>
                <div class="col" style="width: 20%">Create</div>
                <div class="col" style="width: 30%">$12345</div>

              </div>
              <div class="d-flex">
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/100001.jpg" />
                </div>
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/200002.jpg" />
                </div>
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/300003.jpg" />
                </div>
                <div class="order-img">
                  <img class="order-abs-img" src="../../images/item/400004.jpg" />
                </div>
              </div>
            </div>
            <div class="col-2">
              <button class="cta">
                <span>View more</span>
                <svg width="15px" height="10px" viewBox="0 0 13 10">
                  <path d="M1,5 L11,5"></path>
                  <polyline points="8 1 12 5 8 9"></polyline>
                </svg>
              </button>
            </div>
            <hr class="z-1" />
          </div>
          <!-- /item(order record) -->
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col d-flex justify-content-center align-items-end">
          <nav aria-label="Page navigation">
            <ul class="pagination page-nav" style="margin-bottom: 0">
              <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li class="page-item active">
                <a class="page-link" href="#">1</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">2</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#">3</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <br>
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
    <p>© 2024 Smart & Luxury Motor Spares inc.</p>
  </footer>
  <!-- return top -->

  <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png" /></a>
  </div>

  <!-- /return top -->
</body>

</html>