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

  <title>View Item</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="../../css/reset.css" />
  <link rel="stylesheet" href="../../css/common.css" />

  <link rel="stylesheet" href="../../css/bs/bootstrap.css" />
  <!-- /css -->

  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/search_item.js"></script>
  <script src="../../js/sale_manager/view_item.js"></script>
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
              <a class="nav-link" href="./view_item.php">Item</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./view_order.php">Order</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./item_report_condition.php">Report</a>
            </li>

          </ul>
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../../index.php" style="color: red;">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- /navbar -->
  </div>
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
  <?php
  $condition = "";
  if (isset($_GET["search"])) {
    $condition = "$condition and (sparePartName like '%" . $_GET["search"] . "%') or (sparePartDescription like '%" . $_GET["search"] . "%') or (s.sparePartNum like '%" . $_GET["search"] . "%') ";
  }
  if (isset($_GET["A"])) {
    $condition = "$condition and category != 'A' ";
  }
  if (isset($_GET["B"])) {
    $condition = "$condition and category != 'B' ";
  }
  if (isset($_GET["C"])) {
    $condition = "$condition and category != 'C' ";
  }
  if (isset($_GET["D"])) {
    $condition = "$condition and category != 'D' ";
  }
  if (isset($_GET["minPrice"])) {
    $condition = "$condition and price >= " . $_GET["minPrice"] . " ";
  }
  if (isset($_GET["maxPrice"])) {
    $condition = "$condition and price <= " . $_GET["maxPrice"] . " ";
  }
  if (isset($_GET["sort"])) {
    if ($_GET["sort"] == "NA") {
      $condition = "$condition order by s.sparePartNum desc ";
    } else if ($_GET["sort"] == "PLH") {
      $condition = "$condition order by price ";
    } else if ($_GET["sort"] == "PHL") {
      $condition = "$condition order by price desc ";
    }
  }

  $sql  = "SELECT count(*) as spareCount,ifnull(max(price),0) as SpareMaxPrice,ifnull(min(price),0) as SpareMinPrice FROM spare s inner join spareqty q on s.sparePartNum = q.sparePartNum where state = 'N' " . $condition . ";";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $spareCount = $row['spareCount'];
  $spareMaxPrice = $row['SpareMaxPrice'];
  $spareMinPrice = $row['SpareMinPrice'];
  $totalPage = ceil($spareCount / 12);
  if (isset($_GET['pages']) && $_GET['pages'] > 0) {
    $currentPage = min(max(1, $_GET['pages']), $totalPage);
  } else {
    $currentPage = 1;
  }

  ?>
  <!-- content -->
  <div class="d-flex position-relative content-bg justify-content-center">
    <div class="container content-wrap">
      <br />
      <div class="row">
        <div class="col">
          <h2><?php if (isset($_GET["search"])) {
                echo "search for: " . $_GET["search"];
              } else {
                echo "All item";
              } ?></h2>
        </div>
        <div class="col-3 position-relative">
          <a href="./add_item.php">
            <button class="btn btn-primary position-absolute bottom-0 end-0">
              Add New Spare
            </button></a>
        </div>
      </div>
      <hr />
      <div class="row category-item">
        <div class="col-3">
          <div class="position-relative d-flex flex-column" name="filter">
            <h4>Category</h4>
            <div class="form-check">
              <input id="A" name="Category" class="form-check-input cursor-pointer" type="checkbox" value="A" <?php if (!isset($_GET["A"])) {
                                                                                                                echo "checked";
                                                                                                              } ?> />
              <label for="A" class="cursor-pointer form-check-label">Sheet Metal</label>
            </div>
            <div class="form-check">
              <input id="B" name="Category" class="form-check-input cursor-pointer" type="checkbox" value="B" <?php if (!isset($_GET["B"])) {
                                                                                                                echo "checked";
                                                                                                              } ?> />
              <label for="B" class="cursor-pointer form-check-label">Major Assemblies</label>
            </div>
            <div class="form-check">
              <input id="C" name="Category" class="form-check-input cursor-pointer" type="checkbox" value="C" <?php if (!isset($_GET["C"])) {
                                                                                                                echo "checked";
                                                                                                              } ?> />
              <label for="C" class="cursor-pointer form-check-label">Light Components</label>
            </div>
            <div class="form-check">
              <input id="D" name="Category" class="form-check-input cursor-pointer" type="checkbox" value="D" <?php if (!isset($_GET["D"])) {
                                                                                                                echo "checked";
                                                                                                              } ?> />
              <label for="D" class="cursor-pointer form-check-label">Accessories</label>
            </div>
            <br />
            <h4>Price</h4>
            <div class="row">
              <div class="col">
                <!-- use js to set placeholder and min and max and value of minPrice and maxPrice -->
                <input id="minPrice" name="PriceRange" class="form-control" type="number" min="<?php echo $spareMinPrice; ?>" max="<?php echo $spareMaxPrice; ?>" placeholder="<?php echo floor($spareMinPrice); ?>" value="<?php if (isset($_GET["minPrice"])) {
                                                                                                                                                                                                                        echo $_GET["minPrice"];
                                                                                                                                                                                                                      } ?>" />
              </div>
              <div class="col-1 text-center">-</div>
              <div class="col">
                <input id="maxPrice" name="PriceRange" class="form-control" type="number" min="<?php echo $spareMinPrice; ?>" max="<?php echo $spareMaxPrice; ?>" placeholder="<?php echo ceil($spareMaxPrice); ?>" value="<?php if (isset($_GET["maxPrice"])) {
                                                                                                                                                                                                                        echo $_GET["maxPrice"];
                                                                                                                                                                                                                      } ?>" />
              </div>
            </div>
            <br />
            <button type="button" onclick="Submitfilter()" class="btn btn-primary">Submit</button>
          </div>
          <br />
          <br />
          <br />
        </div>
        <div class="col-9">
          <div class="row">
            <div class="col position-relative">
              <ul class="d-flex flex-wrap p-0 m-0 position-absolute bottom-0 start-0 flex-set" style="list-style: none; gap: 2px">
                <li name="Display_mode" class="cursor-pointer">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M448 96V224H288V96H448zm0 192V416H288V288H448zM224 224H64V96H224V224zM64 288H224V416H64V288zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z" />
                  </svg>
                </li>
                <li style="width: 5px"></li>
                <li name="Display_mode" class="cursor-pointer">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                    <path d="M0 96C0 60.7 28.7 32 64 32H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zm64 0v64h64V96H64zm384 0H192v64H448V96zM64 224v64h64V224H64zm384 0H192v64H448V224zM64 352v64h64V352H64zm384 0H192v64H448V352z" />
                  </svg>
                </li>
              </ul>
            </div>
            <div class="col d-flex justify-content-center align-items-end">
              <nav aria-label="Page navigation">
                <ul class="pagination page-nav" style="margin-bottom: 0">
                  <li class="page-item <?php if ($currentPage <= 1) {
                                          echo "disabled";
                                        }
                                        ?>">
                    <a class="page-link cursor-pointer" pages="<?php if ($currentPage <= 1) {
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
                      <a class="page-link cursor-pointer" pages="<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                  <?php } ?>
                  <li class="page-item <?php if ($currentPage >= $totalPage) {
                                          echo "disabled";
                                        }
                                        ?>">
                    <a class="page-link cursor-pointer" pages="<?php if ($currentPage >= $totalPage) {
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
            <div class="col">
              <div class="form-floating">
                <select class="form-select" id="sort">

                  <option value="R" <?php if (!isset($_GET["sort"]) || $_GET["sort"] == "R") {
                                      echo "selected";
                                    } else ?>>Recommend</option>
                  <option value="NA" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "NA") {
                                        echo "selected";
                                      } else  ?>>Newest Arrivals</option>
                  <option value="PLH" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "PLH") {
                                        echo "selected";
                                      } else  ?>>Price: Low to High</option>
                  <option value="PHL" <?php if (isset($_GET["sort"]) && $_GET["sort"] == "PHL") {
                                        echo "selected";
                                      } ?>>Price: High to Low</option>
                </select>
                <label for="sort">Sort</label>
              </div>
            </div>
          </div>
          <hr />
          <div class="row">
            <div id="item" class="item-wrap <?php if (isset($_COOKIE["DisplayMode"])) {
                                              echo $_COOKIE["DisplayMode"];
                                            } else {
                                              echo "cell";
                                            } ?>">
              <?php
              $sql = sprintf("SELECT s.sparePartNum as spnum,sparePartImage,sparePartName,sparePartDescription,price,stockItemQty
               FROM spare s inner join spareqty q on s.sparePartNum = q.sparePartNum 
               where state = 'N' %s 
               limit %d,12;", $condition, ($currentPage - 1) * 12);
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_array($result)) {

                printf('              <div class="item-box">
                <!-- onclick go to item detail -->
                <div class="item-img">
                  <img class="img-m" src="%s" />
                </div>
                <div class="item-info">
                  <p class="item-name">%s | %s</p>
                  <p class="item-desc">
                  Item Description : %s
                  </p>
                  <div class="d-flex item-data">
                  <span>Price: $%.2f</span> <span>Stock: %d</span>
                  </div>
                </div>
                <div class="item-btn">
                  <div class="bg"></div>
                  <button type="button" class="btn btn-primary" onclick="editItem(\'%s\')">
                    Manage this item
                  </button>
                  <br />
                  <button type="button" class="btn btn-primary" onclick="itemReport(\'%s\')">
                    Report of this spare
                  </button>
                </div>
              </div>', $row['sparePartImage'], $row['spnum'], $row['sparePartName'], $row['sparePartDescription'], $row['price'], $row['stockItemQty'], $row['spnum'], $row['spnum']);
              }
              ?>


            </div>
          </div>
          <hr />
          <div class="row">
            <div class="col d-flex justify-content-center align-items-end">
              <nav aria-label="Page navigation">
                <ul class="pagination page-nav" style="margin-bottom: 0">
                  <li class="page-item <?php if ($currentPage <= 1) {
                                          echo "disabled";
                                        }
                                        ?>">
                    <a class="page-link cursor-pointer" pages="<?php if ($currentPage <= 1) {
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
                      <a class="page-link cursor-pointer" pages="<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                  <?php } ?>
                  <li class="page-item <?php if ($currentPage >= $totalPage) {
                                          echo "disabled";
                                        }
                                        ?>">
                    <a class="page-link cursor-pointer" pages="<?php if ($currentPage >= $totalPage) {
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
          <br />
        </div>
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
    <p>© <?php echo date("Y"); ?> Smart & Luxury Motor Spares inc.</p>
  </footer>
  <!-- return top -->

  <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png" /></a>
  </div>

  <!-- /return top -->
</body>

</html>