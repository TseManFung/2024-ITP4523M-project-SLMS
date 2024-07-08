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
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

  <title>Manage Spare Part</title>

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
  <script src="../../js/edit_delete_item.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <!-- /js -->
</head>

<?php
$sql = sprintf("SELECT * FROM spare s inner join spareqty q on s.sparePartNum = q.sparePartNum WHERE s.sparePartNum = '%s'", $_POST["spnum"]);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
// * = s.sparePartNum, category, sparePartName, sparePartImage, sparePartDescription, weight, price, state, q.sparePartNum, stockItemQty
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
  <div style="height: calc(0lvh + 56px);" id="header"></div>
  <!-- /header -->

  <!-- content -->
  <div class="d-flex position-relative content-bg justify-content-center">
    <div class="container content-wrap">
      <br>
      <div>
        <form name="ED_item" method="post">
          <div class="row">
            <h1 class="center-LR" style="width: fit-content;">Manage Spare Part<h1>
          </div>

          <hr>

          <div class="g-10">
            <div class="row">
              <div class="col">
                <div class="form-floating ">
                  <select class="form-select" id="category" disabled>
                    <option value="A" <?php if($row["category"]=="A"){echo "selected";} ?> >A - Sheet Metal</option>
                    <option value="B" <?php if($row["category"]=="B"){echo "selected";} ?> >B - Major Asssemblies</option>
                    <option value="C" <?php if($row["category"]=="C"){echo "selected";} ?> >C - Light Components</option>
                    <option value="D" <?php if($row["category"]=="D"){echo "selected";} ?> >D - Accessories</option>
                  </select>
                  <label for="category">Category</label>
                </div>
              </div>
              <div class="col">
                <div class="form-floating">
                  <input type="text" class="form-control" id="SpacePartNumber" placeholder="Space Part Number" disabled value="<?php echo $_POST["spnum"]?>">
                  <label for="SpacePartNumber">Space Part Number</label>
                </div>
              </div>
              <div class="col">
                <div class="form-floating">
                  <input type="text" class="form-control" id="name" placeholder="Name" disabled value="<?php echo $row["sparePartName"]?>">
                  <label for="name">Name</label>
                </div>
              </div>
            </div>

            <br>

            <div class="row">
              <div class="col">
                <div class="form-floating">
                  <input type="number" class="form-control" id="qty" placeholder="Quantity" min="0" value="<?php echo $row["stockItemQty"]?>">
                  <label for="qty">Quantity</label>
                </div>
              </div>
              <div class="col">
                <div class="input-group mb-3">
                  <span class="input-group-text">$</span>
                  <div class="form-floating">
                    <input type="number" class="form-control" id="price" placeholder="Price" min="0" value="<?php echo $row["price"]?>">
                    <label for="price">Price</label>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="input-group mb-3">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="weight" placeholder="Weight" min="0" value="<?php echo $row["weight"]?>" disabled>
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
                  <textarea class="form-control" placeholder="Description" id="desc" style="height: 7.4rem"><?php echo $row["sparePartDescription"]; ?></textarea>
                  <label for="desc">Description</label>
                </div>
              </div>

            </div>

            <br>

            <div class="row">
              <div class="col">

                <label for="item-img-input" class="form-label">select or drop the image of this spare part</label>
                <input class="form-control" type="file" id="item-img-input" >

              </div>
              <div class="col">
                <img id="item-img" class="item-img" src="<?php echo $row["sparePartImage"]?>">
              </div>

            </div>

            <br>

            <!-- alert -->
            <div class="row">
              <div id="successful" class="alert alert-success d-none" role="alert">
                successful to edit or delete the spare part: [spare part name].
              </div>

              <div id="fail" class="alert alert-danger d-none" role="alert">
                fail to edit or delete the spare part.<br>Reason: [The reason of submit fail]<br>Please try again.
              </div>

              <div id="confirm-delete" class="alert alert-secondary d-none position-relative" role="alert">
                For delete spare part : [item number] <br>
                Please enter the spare part name below: [spare part name] <br><br>
                <div class="form-floating">
                  <input type="text" class="form-control" id="delete-name" placeholder="Spare Part Name">
                  <label for="delete-name">Spare Part Name</label>
                </div><br><br>
                <div class="position-absolute bottom-0 end-0 m-2">
                  <button type="button" class="btn btn-danger" onclick="Delete()">Confirm to Delete</button>
                  <button type="button" class="btn btn-secondary" onclick="Cancel_delete()">Cancel</button>
                </div>

              </div>
            </div>
            <!-- alert -->

            <br>

            <div class="row">
              <div class="col">
                <button type="button" class="btn btn-primary" onclick="Submit()">Edit</button>
                <button type="button" class="btn btn-danger" onclick="confirm_delete()">Delete</button>
                <button type="button" class="btn btn-secondary" onclick="goBack()">Cancel</button>
              </div>
            </div>

            <br>

          </div>
        </form>
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
    <p>© 2024 Smart & Luxury Motor Spares inc.</p>
  </footer>
  <!-- return top -->

  <div id="page-top" style=""><a href="#header"><img src="../../images/common/returan-top.png"></a>
  </div>

  <!-- /return top -->
</body>

</html>