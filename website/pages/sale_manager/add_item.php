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

  <title>New Spare</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/reset.css">
  <link rel="stylesheet" href="../../css/common.css">
  <link rel="stylesheet" href="../../css/bs/bootstrap.css">
  <!-- /css -->

  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../../js/common.js"></script>
  <script src="../../js/add_item.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
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

  <!-- header -->
  <div style="height: calc(0lvh + 56px);" id="header"></div>
  <!-- /header -->

  <!-- content -->
  <div class="d-flex position-relative content-bg justify-content-center">
    <div class="container content-wrap">
      <br>
      <div>
        <form id="uploadForm" name="uploadForm" enctype="multipart/form-data">
          <div class="row">
            <h1 class="center-LR" style="width: fit-content;">New Spare Part<h1>
          </div>

          <hr>

          <div class="g-10">
            <div class="row">
              <div class="col">
                <div class="form-floating">
                  <select class="form-select" id="category" name="category">
                    <option value="A">A - Sheet Metal</option>
                    <option value="B">B - Major Asssemblies</option>
                    <option value="C">C - Light Components</option>
                    <option value="D">D - Accessories</option>
                  </select>
                  <label for="category">Category</label>
                </div>
              </div>
              <div class="col">
                <div class="form-floating">
                  <input type="text" class="form-control" id="name" placeholder="Name" name="sparePartName">
                  <label for="name">Name</label>
                </div>
              </div>
            </div>

            <br>

            <div class="row">
              <div class="col">
                <div class="form-floating">
                  <input type="number" class="form-control" id="qty" name="Quantity"  placeholder="Quantity" min="0">
                  <label for="qty">Quantity</label>
                </div>
              </div>
              <div class="col">
                <div class="input-group mb-3">
                  <span class="input-group-text">$</span>
                  <div class="form-floating">
                    <input type="number" step="0.01" class="form-control" name="price" id="price" placeholder="Price" min="0">
                    <label for="price">Price</label>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="input-group mb-3">
                  <div class="form-floating">
                    <input type="number" step="0.0001" class="form-control" id="weight" name="weight"  placeholder="Weight" min="0">
                    <label for="weight">Weight</label>
                  </div>
                  <span class="input-group-text">kg</span>
                </div>
              </div>
            </div>

            <br>

            <div class="row">
              <div class="col">

                <div class="form-floating">
                  <textarea name="sparePartDescription" class="form-control" placeholder="Description" id="desc" style="height: 7.4rem"></textarea>
                  <label for="desc">Description</label>
                </div>
              </div>

            </div>

            <br>

            <div class="row">
              <div class="col">

                <label for="item-img-input" class="form-label">select or drop the image of this spare part</label>
                <input class="form-control" type="file" name="fileToUpload" id="item-img-input">

              </div>
              <div class="col">
                <img id="item-img" class="item-img" src="">
              </div>

            </div>

            <br>


            <br>

            <div class="row">
              <div class="col">
                <button type="submit" class="btn btn-primary" id="btnSubmit">Confirm to add a new item</button>
                <button type="button" class="btn btn-secondary" onclick="Clear()">Clear</button>
                <button type="button" class="btn btn-secondary" onclick="goBack()">Cancel</button>
              </div>
            </div>

            <br>

          </div>
        </form>

        <!-- alert -->
        <div class="row">
          <div id="successful" class="alert alert-success d-none" role="alert">

          </div>

          <div id="fail" class="alert alert-danger d-none" role="alert">
            fail to add a new spare part.<br>Reason: [The reason of submit fail]<br>Please try again.
          </div>
        </div>
        <!-- alert -->
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
    <p>© <?php echo date("Y");?> Smart & Luxury Motor Spares inc.</p>
  </footer>
  <!-- return top -->

  <div id="page-top" style=""><a href="#header"><img src="../../images/common/returan-top.png"></a>
  </div>

  <!-- /return top -->
</body>

</html>