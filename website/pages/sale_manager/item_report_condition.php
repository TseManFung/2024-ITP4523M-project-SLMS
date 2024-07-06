<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

  <title>Generate Item Report</title>

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
  <script src="../../js/item_report_condition.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <!-- /js -->
</head>

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
              <a class="nav-link" href="./view_item.html">Item</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./view_order.html">Order</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./item_report_condition.html">Report</a>
            </li>

          </ul>
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../../index.html" style="color: red;">Logout</a>
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
        <form name="item_report" method="get" action="item_report.php">
          <div class="row">
            <h1 class="center-LR" style="width: fit-content;">Generate Item Report<h1>
          </div>

          <hr>

          <div class="g-10">
            <div class="row d-none" id="spec_item_row">
              <div class="col">
                <div class="row">
                  <div class="col">
                    <div class="form-floating ">
                      <select class="form-select" id="category" disabled>
                        <option value="A">A - Sheet Metal</option>
                        <option value="B">B - Major Asssemblies</option>
                        <option value="C">C - Light Components</option>
                        <option value="D">D - Accessories</option>
                      </select>
                      <label for="category">Category</label>
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col">

                    <div class="form-floating">
                      <input type="text" class="form-control" id="SpacePartNumber" placeholder="Space Part Number"
                             disabled>
                      <label for="SpacePartNumber">Space Part Number</label>
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col">
                    <div class="form-floating">
                      <input type="text" class="form-control" id="name" placeholder="Name" disabled>
                      <label for="name">Name</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col child-center-flex">
                <img id="item-img" class="item-img" src="../../images/item/100001.jpg">
              </div>
            </div>
            <div class="row" id="all_item_row">
              <div class="col">
                <h4>Category</h4>
                <div class="form-check">
                  <input id="A" class="form-check-input cursor-pointer" type="checkbox" value="A" checked>
                  <label for="A" class="cursor-pointer form-check-label">Sheet Metal</label>
                </div>
                <div class="form-check">
                  <input id="B" class="form-check-input cursor-pointer" type="checkbox" value="B" checked>
                  <label for="B" class="cursor-pointer form-check-label">Major Assemblies</label>
                </div>
                <div class="form-check">
                  <input id="C" class="form-check-input cursor-pointer" type="checkbox" value="C" checked>
                  <label for="C" class="cursor-pointer form-check-label">Light Components</label>
                </div>
                <div class="form-check">
                  <input id="D" class="form-check-input cursor-pointer" type="checkbox" value="D" checked>
                  <label for="D" class="cursor-pointer form-check-label">Accessories</label>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-4">
                <div class="form-check form-switch">
                  <input class="form-check-input cursor-pointer" type="checkbox" role="switch" id="hasDate">
                  <label class="form-check-label cursor-pointer" for="hasDate">The report requires a specific date
                    range</label>
                </div>
              </div>
              <div class="col-8 d-none" id="dateRange">
                <div class="row">
                  <div class="col">
                    <div class="form-floating">
                      <input type="date" class="form-control" id="startDate" placeholder="From">
                      <label for="startDate">From</label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="form-floating">
                      <input type="date" class="form-control" id="untilDate" placeholder="To">
                      <label for="untilDate">To</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <br>

            <div class="row">
              <div class="col">
                <button type="submit" class="btn btn-primary">Generate</button>
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