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

  <title>Cart</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/reset.css">
  <link rel="stylesheet" href="../../css/common.css">
  <link rel="stylesheet" href="../../css/bs/bootstrap.css">
  <link rel="stylesheet" href="../../css/dealer_view_orderrecord_token.css">
  <link rel="stylesheet" href="../../css/dealer_cart.css">

  <!-- /css -->
  <!-- js -->
  <script src="../../js/common.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/add_itemm.js"></script>
  <script src="../../js/dealer_view_orderrecord_token.js"></script>


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
  <?php
  $userID = $_SESSION['userID'];
  $sql = " SELECT COUNT(cart.userID) AS NID, SUM(cart.qty) AS total_quantity, GROUP_CONCAT(spare.sparePartName) AS sparePartNames, GROUP_CONCAT(spare.category) AS categories, GROUP_CONCAT(spare.price) AS prices FROM cart JOIN spare ON cart.sparePartNum = spare.sparePartNum WHERE cart.userID = $userID";
  $result = mysqli_query($conn, $sql);
  $cart = mysqli_fetch_array($result);
  ?>
  <div class="content-bg">
    <div class="container">
      <section class="h-100 h-custom">
        <div class="container h-100 py-5">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
              <div class="card mb-5">
                <div class="card-body p-4">

                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col" class="h5">Cart (<?php echo $cart['total_quantity']; ?> Items) <?php echo $cart['NID']; ?> (types)</th>
                          <th scope="col">ID</th>
                          <th scope="col">Price</th>
                          <th scope="col">Quantity</th>
                          <th scope="col">Price</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT cart.userID, cart.qty, spare.sparePartName, spare.category, spare.price, spare.sparePartImage, spare.sparePartDescription, spare.weight, spare.state 
        FROM cart 
        JOIN spare ON cart.sparePartNum = spare.sparePartNum 
        WHERE cart.userID = $userID;";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_array($result)) {
                            printf(
                              '
            <tr>
                <th scope="row">
                    <div class="d-flex align-items-center">
                        <img src="%s" class="img-fluid rounded-3" style="width: 120px;" alt="%s">
                    </div>
                </th>
                <td class="align-middle">
                    <p class="mb-0" style="font-weight: 500">%s</p>
                </td>
                <td class="align-middle">
                    <p class="mb-0" style="font-weight: 500">$%.2f</p>
                </td>
                <td class="align-middle">
                    <div class="d-flex flex-row">
                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2" onclick="this.parentNode.querySelector(\'input[type=number]\').stepDown()">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input id="form1" min="1" name="quantity" value="%d" type="number" class="form-control form-control-sm" style="width: 50px;" />
                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2" onclick="this.parentNode.querySelector(\'input[type=number]\').stepUp()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </td>
                <td class="align-middle">
                    <p class="mb-0" style="font-weight: 500;">$%.2f</p>
                </td>
                <td class="align-middle">
                    <p class="mb-0" style="font-weight: 500;"><i class="fa-solid fa-xmark"></i></p>
                </td>
            </tr>
        </tbody>',
                              $row['sparePartImage'],
                              $row['sparePartName'],
                              $row['sparePartName'],
                              $row['price'],
                              $row['qty'],
                              $row['qty'] * $row['price']
                            );
                          }
                        } else {
                          echo '
    <tbody>
        <tr>
            <td colspan="6" class="text-center align-middle">
                <p class="mb-0" style="font-weight: 500;">Your car is empty.</p>
            </td>
        </tr>';
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="card shadow-2-strong mb-5 mb-lg-0" style="border-radius: 16px;">
                <div class="card-body p-4">
                  <div class="d-flex justify-content-between" style="font-weight: 500;">
                    <p class="mb-2">Delivery fee</p>
                    <p class="mb-2">6.0kg</p>
                  </div>
                  <div class="d-flex justify-content-between" style="font-weight: 500;">
                    <p class="mb-2">Total weight</p>
                    <p class="mb-2">6.0kg</p>
                  </div>
                  <div class="d-flex justify-content-between" style="font-weight: 500;">
                    <p class="mb-0">Subtotal</p>
                    <p class="mb-0">$1013.50</p>
                  </div>
                  <hr class="my-4">
                  <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                    <p class="mb-2">Total</p>
                    <p class="mb-2">$1013.50</p>
                  </div>
                  <div class="d-grid gap-2 d-md-block">
                    <a href="./checkout.php">
                      <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg">
                        <div class="d-flex justify-content-between">
                          <span>Checkout</span>
                          <span>($26.48)</span>
                        </div>
                      </button>
                    </a>
                    <a href="./search_item.php">
                      <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg">
                        <div class="d-flex justify-content-between">
                          <span>Back to view item</span>
                        </div>
                      </button>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <br><br>
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