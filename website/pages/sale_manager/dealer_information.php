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

  <title>page name</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="../../css/reset.css" />
  <link rel="stylesheet" href="../../css/common.css" />
  <link rel="stylesheet" href="../../css/bs/bootstrap.css" />
  <!-- /css -->

  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../../js/common.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <!-- /js -->
</head>
<?php
  $dealerID = $_GET['DID'];
  $sql = "SELECT * FROM dealer WHERE dealerID = $dealerID";
  $result = mysqli_query($conn, $sql);
  $dealer = mysqli_fetch_array($result);
  $dealerIDFormatted = sprintf('%010d', $dealer['dealerID']);
  mysqli_close($conn);
  ?>
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
  <div style="height: calc(0lvh + 56px)" id="header"></div>
  <!-- /header -->

  <!-- content -->
  <div class="d-flex position-relative content-bg justify-content-center">
    <div class="container content-wrap">
      <br />
      <div class="row">
        <div class="col-md-3 border-right child-center-TB">
          <div class="d-flex flex-column align-items-center text-center p-3 py-5">
            <span class="font-weight-bold rounded-circle mt-5"><?php echo $dealer['dealerName']; ?></span><span class="text-black-50">
            Dealer ID:<?php echo $dealerIDFormatted; ?>
            </span><span> </span>
          </div>
        </div>
        <div class="col-md-5 border-right">
          <div class="p-3 py-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h4 class="text-right">Delaer Information</h4>
            </div>
            <div class="row mt-2">
              <div class="col-md-12">
                <label class="labels">Delaer Name</label><input type="text" class="form-control" placeholder="Delaer name"
                       value="<?php echo $dealer['dealerName']; ?>" disabled>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <label class="labels">Contact Name</label><input type="text" class="form-control" value="<?php echo $dealer['contactName']; ?>" disabled>
              </div>
              <div class="col-md-12">
                <label class="labels">Contant Number</label><input type="text" class="form-control" value="<?php echo $dealer['contactNumber']; ?>" disabled>
              </div>
              <div class="col-md-12">
                <label class="labels">Fax Number</label><input type="text" class="form-control" value="<?php echo $dealer['faxNumber']; ?>" disabled>
              </div>
              <div class="col-md-12">
                <label class="labels">Delivery Address</label><input type="text" class="form-control"
                       placeholder="come form database" value="<?php echo $dealer['deliveryAddress']; ?>" disabled>
              </div>
            </div>
            <div class="mt-5 text-center">
              <a href="./dealer_report_condition.php">
                <button class="btn btn-primary profile-button" type="button">
                  Report
                </button>
              </a>
            </div>
          </div>
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
    <p>© <?php echo date("Y");?> Smart & Luxury Motor Spares inc.</p>
  </footer>
  <!-- return top -->

  <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png" /></a>
  </div>

  <!-- /return top -->
</body>

</html>