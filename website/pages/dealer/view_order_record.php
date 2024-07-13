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
  <script src="../../js/search_item.js"></script>
  <script src="../../js/common.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/view_order_record.js"></script>
  <script src="../../js/search_item.js"></script>
  <!-- /js -->
</head>

<?php
$condition = " where dealerID = {$_SESSION['dealerID']} ";

if (isset($_GET["filter"]) && $_GET["filter"] != "N") {
    $condition = "$condition and o.state = '{$_GET["filter"]}' ";
}

if (isset($_GET["search"])) {
  $search = mysqli_real_escape_string($conn, $_GET["search"]);
  $condition = $condition . " and CONCAT(
    o.orderID,'\r\n' ,
    o.orderDateTime,'\r\n' ,
    o.deliveryAddress,'\r\n' ,
    o.TotalAmount + o.shipCost
  ) LIKE CONCAT('%', '$search', '%') ";
}



$sql = "SELECT count(*) FROM `order` o $condition ;";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$orderCount = $row[0];
if (isset($_GET['pages']) && $_GET['pages'] > 0) {
  $currentPage = $_GET['pages'];
} else {
  $currentPage = 1;
}
$totalPage = ceil($orderCount / 10);

if (isset($_GET["sort"])) {
  if ($_GET["sort"] == "N") {
    $condition = "$condition order by o.orderDateTime desc ";
  } else if ($_GET["sort"] == "O") {
    $condition = "$condition order by o.orderDateTime ";
  } else if ($_GET["sort"] == "QLH") {
    $condition = "$condition order by orderItemNumber ";
  } else if ($_GET["sort"] == "QHL") {
    $condition = "$condition order by orderItemNumber desc ";
  } else if ($_GET["sort"] == "ALH") {
    $condition = "$condition order by TA ";
  } else if ($_GET["sort"] == "AHL") {
    $condition = "$condition order by TA desc ";
  }
} else {
  $condition = "$condition order by o.orderDateTime desc ";
}

$sql = "SELECT 
  o.orderID,
  o.orderDateTime,
  ifnull(o.deliveryAddress,'') AS deliveryAddress, 
  o.TotalAmount + o.shipCost as TA,
  o.state AS orderStatus
FROM `order` o
$condition Limit " . ($currentPage - 1) * 10 . ", 10;";
$result = mysqli_query($conn, $sql);
if ($result) {
  $order = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
  $order = [];
}
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
          <h2 class="row__title">Order(<?php echo $orderCount; ?>)</h2>
        </div>
        <div class="col d-flex justify-content-center align-items-end">
          <nav aria-label="Page navigation">
            <ul class="pagination page-nav" style="margin-bottom: 0">
              <li class="page-item <?php if ($currentPage <= 1) {
                                      echo "disabled";
                                    }
                                    ?>">
                <a class="page-link" href="?pages=<?php if ($currentPage <= 1) {
                                                    echo "1";
                                                  } else {
                                                    echo $currentPage - 1;
                                                  }; ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php
              for ($i = max(1, $currentPage - 2); $i <= min($totalPage, $currentPage + 2); $i++) {
              ?>
                <li class="page-item <?php if ($i == $currentPage) {
                                        echo "active";
                                      } ?>">
                  <a class="page-link" href="?pages=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
              <?php } ?>
              <li class="page-item <?php if ($currentPage >= $totalPage) {
                                      echo "disabled";
                                    }
                                    ?>">
                <a class="page-link" href="?pages=<?php if ($currentPage >= $totalPage) {
                                                    echo $totalPage;
                                                  } else {
                                                    echo $currentPage + 1;
                                                  }; ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-md-4 position-relative">
          <div class="position-absolute bottom-0 end-0 d-flex">
            <div class="form-floating" style="padding-right: 12px">

              <select class="form-select" id="filter">
                <option value="N" <?php if (!isset($_GET["filter"]) || $_GET["filter"] == "N") {
                                    echo "selected";
                                  } ?>>All</option>
                <option value="C" <?php if (isset($_GET["filter"]) && $_GET["filter"] == "C") {
                                    echo "selected";
                                  } ?>>Create Order</option>
                <option value="A" <?php if (isset($_GET["filter"]) && $_GET["filter"] == "A") {
                                    echo "selected";
                                  } ?>>Accepted</option>
                <option value="R" <?php if (isset($_GET["filter"]) && $_GET["filter"] == "R") {
                                    echo "selected";
                                  } ?>>Rejected</option>
                <option value="T" <?php if (isset($_GET["filter"]) && $_GET["filter"] == "T") {
                                    echo "selected";
                                  } ?>>In Transmit</option>
                <option value="U" <?php if (isset($_GET["filter"]) && $_GET["filter"] == "U") {
                                    echo "selected";
                                  } ?>>Unavailable</option>
                <option value="F" <?php if (isset($_GET["filter"]) && $_GET["filter"] == "F") {
                                    echo "selected";
                                  } ?>>Finished</option>
              </select>
              <label for="filter">State Filter</label>
            </div>

            <div class="form-floating" style="padding-right: 12px">

              <select class="form-select" id="sort">
                <option value="N" <?php if (!isset($_GET["sort"]) || $_GET["sort"] == "N") {
                                    echo "selected";
                                  } else ?>>Newest</option>
                <option value="O" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "O") {
                                    echo "selected";
                                  } else  ?>>Oldest</option>
                <option value="QLH" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "QLH") {
                                      echo "selected";
                                    } else  ?>>Quantity: Low to High</option>
                <option value="QHL" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "QHL") {
                                      echo "selected";
                                    } else  ?>>Quantity: High to Low</option>
                <option value="ALH" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "ALH") {
                                      echo "selected";
                                    } else  ?>>Amount: Low to High</option>
                <option value="AHL" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "AHL") {
                                      echo "selected";
                                    }  ?>>Amount: High to Low</option>
              </select>
              <label for="sort">Sort</label>
            </div>
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
          <?php foreach ($order as $row) {
            $s = "SELECT sparePartImage FROM orderspare os inner join spare s on s.sparePartNum=os.sparePartNum where orderID = " . $row['orderID'] . " limit 0,7;";
            $r = mysqli_query($conn, $s);
            $images = mysqli_fetch_all($r, MYSQLI_ASSOC); ?>

            <!-- item(order record) -->
            <div class="row item-box table-content">
              <div class="col-10">
                <div class="row table-content-data">
                  <div class="col" style="width: 20%"><?php echo str_pad($row["orderID"], 10, "0", STR_PAD_LEFT) ?></div>
                  <div class="col" style="width: 30%"><?php echo $row["orderDateTime"] ?></div>
                  <div class="col" style="width: 20%"><?php echo $stateConvert[$row["orderStatus"]] ?></div>
                  <div class="col" style="width: 30%">$<?php echo $row["TA"] ?></div>

                </div>
                <div class="d-flex">
                <?php for ($i = 0; $i < count($images); $i++) { ?>
                    <div class="order-img <?php if ($i == 6) {
                                            echo "order-2many-item";
                                          } ?>" data-order-id="<?php echo $row["orderID"]; ?>">
                      <img class="order-abs-img" src="<?php echo $images[$i]["sparePartImage"]; ?>" />
                    </div>
                  <?php } ?>
                </div>
              </div>
              <div class="col-2">
                <button class="cta" data-order-id="<?php echo $row["orderID"]; ?>">
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
          <?php } ?>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col d-flex justify-content-center align-items-end">
          <nav aria-label="Page navigation">
            <ul class="pagination page-nav" style="margin-bottom: 0">
              <li class="page-item <?php if ($currentPage <= 1) {
                                      echo "disabled";
                                    }
                                    ?>">
                <a class="page-link" href="?pages=<?php if ($currentPage <= 1) {
                                                    echo "1";
                                                  } else {
                                                    echo $currentPage - 1;
                                                  }; ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php
              for ($i = max(1, $currentPage - 2); $i <= min($totalPage, $currentPage + 2); $i++) {
              ?>
                <li class="page-item <?php if ($i == $currentPage) {
                                        echo "active";
                                      } ?>">
                  <a class="page-link" href="?pages=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
              <?php } ?>
              <li class="page-item <?php if ($currentPage >= $totalPage) {
                                      echo "disabled";
                                    }
                                    ?>">
                <a class="page-link" href="?pages=<?php if ($currentPage >= $totalPage) {
                                                    echo $totalPage;
                                                  } else {
                                                    echo $currentPage + 1;
                                                  }; ?>" aria-label="Next">
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
    <p>© <?php echo date("Y"); ?> Smart & Luxury Motor Spares inc.</p>

  </footer>
  <!-- return top -->

  <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png" /></a>
  </div>

  <!-- /return top -->
</body>

</html>