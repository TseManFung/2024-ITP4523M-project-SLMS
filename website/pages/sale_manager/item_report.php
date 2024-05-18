<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />

  <title>Spare Part Report</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="../../css/reset.css" />
  <link rel="stylesheet" href="../../css/common.css" />
  <link rel="stylesheet" href="../../css/bs/bootstrap.css" />
  <!-- /css -->

  <!-- js -->
  <script src="../../js/common.js"></script>
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
  <div style="height: calc(0lvh + 56px)" id="header"></div>
  <!-- /header -->

  <!-- content -->
  <div class="d-flex position-relative content-bg justify-content-center">
    <div class="container content-wrap">
      <br />
      <div class="row row--top-40">
        <div class="col-md-4">
          <h2 class="row__title">Spare Part Report (2)</h2>
          # this report genarate at [2024-01-01 00:00:00]
        </div>

        <div class="col">
        </div>
        <div class="col-md-4 position-relative">
          <div class="form-floating position-absolute bottom-0 end-0" style="padding-right: 12px">
            <select class="form-select" id="sort">
              <option value="ID">ID</option>
              <option value="OLH">Order Number: Low to High</option>
              <option value="OHL">Order Number: High to Low</option>
              <option value="ALH">Sale Amount: Low to High</option>
              <option value="AHL">Sale Amount: High to Low</option>
            </select>
            <label for="sort">Sort</label>
          </div>
        </div>

      </div>
      <br />
      <!-- table-->
      <table id="item-report" class="table table-striped table-hover">
        <!-- table header -->
        <thead class="table-light table-header">
          <tr>
            <th scope="col" style="width: 10%;">ID</th>
            <th scope="col" style="width: 40%;">Name</th>
            <th scope="col" style="width: 20%;text-align:center;">photo</th>
            <th scope="col" style="width: 15%;">Total order number</th>
            <th scope="col" style="width: 15%;">Total sale amount</th>
          </tr>
        </thead>
        <!-- /table header -->
        <!-- table body -->
        <tbody>
          <!-- record -->
          <tr>
            <th scope="row">100001</th>
            <td>idk</td>
            <td>
              <div class="table-img-box center-LR center-TB">
                <img class="table-img" src="../../images/item/100001.jpg" />
              </div>
            </td>
            <td>12</td>
            <td>$123456</td>
          </tr>
          <!-- /record -->
          <!-- record -->
          <tr>
            <th scope="row">200002</th>
            <td>a long long long long long long long long long long long ng long long long long long long ng long long
              long long long long ng long long long long long long ng long long long long long long ng long long long
              long long long ng long long long long long long ng long long long long long long ng long long long long
              long long ng long long long long long long ng long long long long long long ng long long long long long
              long ng long long long long long long ng long long long long long long ng long long long long long long ng
              long long long long long long ng long long long long long long ng long long long long long long ng long
              long long long long long ng long long long long long long long long long long long long longg long long
              long long long long long long long long long long long lon long long long long long long long long long
              long long long long long long long long long long long long long long long long long long long long long
              name</td>
            <td>
              <div class="table-img-box center-LR center-TB">
                <img class="table-img" src="../../images/item/200002.jpg" />
              </div>
            </td>
            <td>150</td>
            <td>$123456</td>
          </tr>
          <!-- /record -->
        </tbody>
        <!-- table body -->
      </table>
      <!-- /table -->
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
    <p>© 2024 Smart & Luxury Motor Spares inc.</p>
  </footer>
  <!-- return top -->

  <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png" /></a>
  </div>

  <!-- /return top -->
</body>

</html>