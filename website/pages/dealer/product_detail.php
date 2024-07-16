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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Product Detail</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/reset.css">
  <link rel="stylesheet" href="../../css/common.css">
  <link rel="stylesheet" href="../../css/bs/bootstrap.css">
  <link rel="stylesheet" href="../../css/productdetail.css">
  <!-- /css -->
  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/dealer/product_detail.js"></script>
  <script src="../../js/common.js"></script>
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
  $spnum = $_GET['spnum'];
  $sql = "SELECT s.sparePartNum, s.category, s.sparePartName, s.sparePartImage, s.sparePartDescription, s.weight, s.price, s.state, sq.stockItemQty FROM spare s JOIN spareqty sq ON s.sparePartNum = sq.sparePartNum WHERE s.sparePartNum = $spnum";
  $result = mysqli_query($conn, $sql);
  $detail = mysqli_fetch_array($result);
  mysqli_close($conn);
  ?>

  <hr style="border: rgb(103, 149, 255) 10px solid;" class="content">
  <div class="d-flex position-relative content-bg justify-content-center">
    <div class="container content-wrap">
      <br />
      <div class="">
        <div class="row">
          <div class="col">
            <img src="<?php echo $detail['sparePartImage']; ?>" class="float-left img-fluid img-thumbnail img400">
          </div>
          <div class="col">
            <div class="row">
              <div class="col">
                <h1><?php echo $detail['sparePartName']; ?></h1>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p><?php echo $detail['sparePartNum']; ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p id="price" data-value="<?php echo $detail['price']; ?>">$<?php echo $detail['price']; ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <p>Retail Inventory: <?php echo $detail['stockItemQty']; ?>(pieces)</p>
              </div>
            </div>
            <hr />
            <h2>About the Spare:</h2>
            <p><small><?php echo $detail['sparePartDescription']; ?></small></p>
            <div class="container">
              <div class="row g-3">
                <p>Spare Weight (Single): <?php echo $detail['weight']; ?>KG</p>
                <div class="col-md-4">
                  <label for="quantityInput" class="form-label">Quantity</label>
                  <input type="number" class="form-control" value="1" id="quantityInput" min="1" max="<?php echo $detail['stockItemQty']; ?>" required>
                </div>
                <div class="col-12">
                  <button class="btn btn-primary" id="addToCartBtn" onclick="addToCartqty('<?php echo $detail['sparePartNum']; ?>') " >
                    <span class="fa-solid fa-cart-shopping"></span> Add to Cart
                  </button>
                  <button class="btn btn-primary" onclick="goBack()">Back</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
    </div>
  </div>
  <footer>
    <!-- link -->
    <ul class="sns">
      <!--         <li><a href="https://twitter.com/lycoris_recoil" target="_blank"><img src="images/common/icon_x.png" alt="twitter/X"></a></li>
                            <li><a href="https://www.pixiv.net/users/83515809" target="_blank"><img src="images/common/icon_pixiv.png" alt="pixiv"></a></li> -->
    </ul>
    <!-- /link -->
    <p>© <?php echo date("Y");?> Smart & Luxury Motor Spares inc.</p>
  </footer>
  <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png"></a>
  </div>
</body>
</html>