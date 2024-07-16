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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/reset.css">
  <link rel="stylesheet" href="../../css/common.css">
  <link rel="stylesheet" href="../../css/bs/bootstrap.css">
  <link rel="stylesheet" href="../../css/dealer_cart.css">

  <!-- /css -->
  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../../js/common.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/add_item.js"></script>
  <script src="../../js/dealer/dealer_API_GET.js"></script>
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
  $sql = "SELECT COUNT(cart.userID) AS NID, SUM(cart.qty) AS total_quantity, GROUP_CONCAT(spare.sparePartName) AS sparePartNames, GROUP_CONCAT(spare.category) AS categories, GROUP_CONCAT(spare.price) AS prices FROM cart JOIN spare ON cart.sparePartNum = spare.sparePartNum WHERE cart.userID = $userID";
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
                          <th scope="col" class="h5">Cart (<?php echo $cart['total_quantity']; ?> Items)<br><?php echo $cart['NID']; ?> (types)</th>
                          <th scope="col">ID</th>
                          <th scope="col">Price</th>
                          <th scope="col">Quantity</th>
                          <th scope="col">Price</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql = "SELECT cart.userID, cart.qty, cart.sparePartNum, spare.sparePartName, spare.category, spare.price, spare.sparePartImage, spare.sparePartDescription, spare.weight, spare.state, spareqty.stockItemQty
                        FROM cart
                        JOIN spare ON cart.sparePartNum = spare.sparePartNum
                        JOIN spareqty ON spare.sparePartNum = spareqty.sparePartNum
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
                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2" onclick="decreaseQuantity(%s)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input id="form1%s" min="1" max="%d" name="quantity" value="%d" type="number" class="form-control form-control-sm" style="width: 50px;" />
                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2" onclick="increaseQuantity(%s)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="align-middle">
                                <p class="mb-0" style="font-weight: 500;">$%.2f</p>
                            </td>
                            <td class="align-middle">
                                <p class="mb-0" style="font-weight: 500;">
                                    <button style="background: none; border: none; padding: 0; cursor: pointer;" onclick="deleteitem(%s)">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </p>
                            </td>
                        </tr>',
                              $row['sparePartImage'],
                              $row['sparePartName'],
                              $row['sparePartName'],
                              $row['price'],
                              $row['sparePartNum'],
                              $row['sparePartNum'],
                              $row['stockItemQty'],  // Set max to spareqty
                              $row['qty'],
                              $row['sparePartNum'],
                              $itemTotalPrice,
                              $row['sparePartNum']
                            );
                          }
                        } else {
                          echo '
                    <tr>
                        <td colspan="6" class="text-center align-middle">
                            <p class="mb-0" style="font-weight: 500;">Your cart is empty.</p>
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
                    <p class="mb-2" id="delivery" value="0" total-qty="<?php echo $itemTotalqty; ?>"></p>
                  </div>
                  <div class="d-flex justify-content-between" style="font-weight: 500;">
                    <p class="mb-2">Total weight</p>
                    <p class="mb-2" id="totalWeight" total-weight="<?php echo $totalWeight; ?>"><?php echo $totalWeight; ?> kg</p>
                  </div>
                  <div class="d-flex justify-content-between" style="font-weight: 500;">
                    <p class="mb-0">Subtotal</p>
                    <p class="mb-0">$<?php echo number_format($subTotal, 2); ?></p>
                  </div>
                  <hr class="my-4">
                  <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                    <p class="mb-2">Total</p>
                    <p class="mb-2" id="Total-SAD" subtotal-method="<?php echo $subTotal; ?>"></p>
                  </div>
                  <?php
                  $sql = "SELECT SUM(qty)AS qtyq FROM `cart` WHERE userID= $userID";
                  $result = mysqli_query($conn, $sql);
                  $qtyq = mysqli_fetch_array($result);
                  ?>
                  <div class="d-grid gap-2 d-md-block">
                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg" onclick="checkoutTest(<?php echo $totalWeight ?>, <?php echo $qtyq['qtyq'] ?>)">
                      <div class="d-flex justify-content-between">
                        <span>Checkout</span>
                      </div>
                    </button>
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
  <footer>
    <!-- link -->
    <ul class="sns">
      <!-- <li><a href="https://twitter.com/lycoris_recoil" target="_blank"><img src="images/common/icon_x.png" alt="twitter/X"></a></li>
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