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

  <title><?php
          if (isset($_POST['DID'])) {
            $sql = "SELECT dealerName FROM dealer where dealerID = {$_POST["DID"]};";
            $result = mysqli_query($conn, $sql);
            $dealerName = mysqli_fetch_assoc($result)["dealerName"];

            echo $dealerName . "'s ";
          } elseif (isset($_POST['spnum'])) {
            $sql = "SELECT sparePartName FROM spare where sparePartNum = {$_POST["spnum"]};";
            $result = mysqli_query($conn, $sql);
            $sparePartName = mysqli_fetch_assoc($result)["sparePartName"];

            echo $sparePartName . "'s ";
          } else {
            echo "Spare Part ";
          }
          ?> Report</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="../../css/reset.css" />
  <link rel="stylesheet" href="../../css/common.css" />
  <link rel="stylesheet" href="../../css/bs/bootstrap.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/bootstrap-table.min.css">

  <!-- /css -->

  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../../js/common.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.0/dist/bootstrap-table.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="../../js/reportChart.js"></script>
  <!-- /js -->
</head>
<?php
$sql;
$condition = "where ";
if (isset($_POST['startDate'])) {
  $startDate = $_POST['startDate'];
  $untilDate = $_POST['untilDate'];
  $condition .= " o.orderDateTime BETWEEN '$startDate' AND '$untilDate' and ";
}

if (isset($_POST['DID'])) {
  $condition .= " o.dealerID = " . $_POST['DID'] . " ";
  $sql = "SELECT
o.orderID 'Order ID',
o.orderDateTime 'Order Date & Time',
SUM(os.orderQty) 'Total Item Quantity',
SUM(os.orderQty * s.weight) 'Total Item Weight',
o.TotalAmount 'Total Order Amount',
o.state 'Status'
FROM `order` o
INNER JOIN orderSpare os ON o.orderID = os.orderID
INNER JOIN spare s ON os.sparePartNum = s.sparePartNum
$condition
GROUP BY o.orderID";
} elseif (isset($_POST['spnum'])) {
  $condition .= " os.sparePartNum = " . $_POST['spnum'] . " ";
  $sql = "SELECT 
  s.sparePartNum AS 'ID',
  s.sparePartName AS 'Name', 
  s.sparePartImage AS 'photo',
  COUNT(*) AS 'Total order number',
  SUM(os.orderQty) AS 'Total sale quantity',
  SUM(os.sparePartOrderPrice*os.orderQty) AS 'Total sale amount'
 FROM orderSpare os 
 INNER JOIN spare s ON s.sparePartNum = os.sparePartNum
 INNER JOIN `order` o ON o.orderID = os.orderID
 $condition
 GROUP BY s.sparePartNum;";
} else {
  $category = "";
  if (isset($_POST['A'])) {
    $category .= "A";
  }
  if (isset($_POST['B'])) {
    $category .= "B";
  }
  if (isset($_POST['C'])) {
    $category .= "C";
  }
  if (isset($_POST['D'])) {
    $category .= "D";
  }

  $condition .= " '$category' like concat('%',category,'%') and s.state = 'N' ";
  $sql = "SELECT
  s.sparePartNum AS 'ID',
  s.sparePartName AS 'Name',
  s.sparePartImage AS 'photo',
  sq.stockItemQty as 'Stock number',
  COUNT(*) AS 'Total order number', 
  ifnull(SUM(os.orderQty),0) AS 'Total sale quantity',
  ifnull(SUM(os.sparePartOrderPrice*os.orderQty),0) AS 'Total sale amount'
FROM spare s
left JOIN orderSpare os ON s.sparePartNum = os.sparePartNum
left JOIN `order` o ON o.orderID = os.orderID
INNER JOIN spareQty sq ON sq.sparePartNum = s.sparePartNum
$condition
GROUP BY s.sparePartNum;";
}
try {
  $result = mysqli_query($conn, $sql);
} catch (Exception $e) {
  echo $sql;
}
$all_row = mysqli_fetch_all($result, MYSQLI_ASSOC);
$row_count = mysqli_num_rows($result);
$dataHTML = '%s" data-%s = "%s';
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
      <div class="row row--top-40">
        <div class="col-md-8">
          <h2 class="row__title"><?php
                                  if (isset($_POST['DID'])) {
                                    echo $dealerName . "'s ";
                                  } elseif (isset($_POST['spnum'])) {
                                    echo $sparePartName . "'s ";
                                  } else {
                                    echo "Spare Part ";
                                  }
                                  ?> Report (<?php echo $row_count; ?>)</h2>
          # this report generated at <?php echo gmdate('Y-m-d H:i:s', time() + 8 * 3600); ?>
        </div>


      </div>
      <br />
      <div>
      <canvas id="Chart" data-type="<?php if (isset($_POST['DID'])) {printf($dataHTML,"D","D",$_POST['DID']); } elseif (isset($_POST['spnum'])) {printf($dataHTML,"S","S",$_POST['spnum']); } else { echo "N";}?>"></canvas>      </div>
      <br />
      <!-- table-->
      <table id="item-report" class="table table-striped table-hover" data-toggle="table" data-flat="true" data-search="true">
        <!-- table header -->
        <thead class="table-light table-header">
          <tr>
            <?php if (isset($_POST['DID'])) { ?>
              <th scope="col" data-sortable="true">Order ID</th>
              <th scope="col" data-sortable="true">Order Date & Time</th>
              <th class="text-end" scope="col" data-sortable="true">Total Item Quantity</th>
              <th class="text-end" scope="col" data-sortable="true">Total Item Weight</th>
              <th class="text-end" scope="col" data-sortable="true">Total Order Amount</th>
              <th scope="col" data-sortable="true">Status</th>
            <?php } elseif (isset($_POST['spnum'])) { ?>
              <th scope="col" style="width: 10%;" data-sortable="true">Spare ID</th>
              <th scope="col" style="width: 40%;" data-sortable="true">Name</th>
              <th scope="col" style="width: 20%;text-align:center;">photo</th>
              <th class="text-end" scope="col" style="width: 10%;" data-sortable="true">Total order number</th>
              <th class="text-end" scope="col" style="width: 10%;" data-sortable="true">Total sale quantity</th>
              <th class="text-end" scope="col" style="width: 10%;" data-sortable="true">Total sale amount</th>
            <?php } else { ?>
              <th scope="col" style="width: 10%;" data-sortable="true">Spare ID</th>
              <th scope="col" style="width: 30%;" data-sortable="true">Name</th>
              <th scope="col" style="width: 20%;text-align:center;">photo</th>
              <th class="text-end" scope="col" style="width: 10%;" data-sortable="true">Stock number</th>
              <th class="text-end" scope="col" style="width: 10%;" data-sortable="true">Total order number</th>
              <th class="text-end" scope="col" style="width: 10%;" data-sortable="true">Total sale quantity</th>
              <th class="text-end" scope="col" style="width: 10%;" data-sortable="true">Total sale amount</th>
            <?php } ?>
          </tr>
        </thead>
        <!-- /table header -->
        <!-- table body -->
        <tbody>
          <?php if (isset($_POST['DID'])) {
            foreach ($all_row as $row) { ?>

              <!-- record -->
              <tr>
                <th scope="row"><?php echo $row['Order ID']; ?></th>
                <td><?php echo $row['Order Date & Time']; ?></td>
                <td class="text-end"><?php echo $row['Total Item Quantity']; ?></td>
                <td class="text-end"><?php echo number_format($row['Total Item Weight'],2); ?> KG</td>
                <td class="text-end">$ <?php echo $row['Total Order Amount']; ?></td>
                <td><?php echo $stateConvert[$row['Status']]; ?></td>
              </tr>
              <!-- /record -->

            <?php }
          } else {
            foreach ($all_row as $row) { ?>
              <!-- record -->
              <tr>
                <th scope="row"><?php echo $row['ID']; ?></th>
                <td><?php echo $row['Name']; ?></td>
                <td>
                  <div class="table-img-box center-LR center-TB">
                    <img class="table-img" src="../../images/item/<?php echo $row['photo']; ?>" />
                  </div>
                </td>
                <?php if (!isset($_POST['spnum'])) { ?>
                  <td class="text-end"><?php echo $row['Stock number']; ?></td>
                <?php } ?>
                <td class="text-end"><?php echo $row['Total order number']; ?></td>
                <td class="text-end"><?php echo $row['Total sale quantity']; ?></td>
                <td class="text-end">$ <?php echo $row['Total sale amount']; ?></td>
              </tr>
              <!-- /record -->
          <?php }
          } ?>


        </tbody>
        <!-- table body -->
      </table>
      <!-- /table -->
      <br />

    </div>

    <br />

    <br>
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