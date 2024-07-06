<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

  <title>Reset Password</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/reset.css">
  <link rel="stylesheet" href="../../css/common.css">
  <link rel="stylesheet" href="../../css/bs/bootstrap.css">
  <link rel="stylesheet" href="../../css/dealer_template_resetpasswd.css">
  <!-- /css -->
  <!-- js -->
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/dealer_template_resetpasswd.js"></script>

  <!-- /css -->
  <!-- js -->
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
              <a class="nav-link" href="./search_item.html">Our Product</a>
            </li>
          </ul>
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex flex-nowrap align-items-center" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
              Hi [username]<span class="note-label">99+</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="./dealer_information.html">Your Information</a></li>
              <li><a class="dropdown-item" href="./view_order_record.html">Your Order</a></li>
              <li>
                <a class="dropdown-item position-relative d-flex flex-nowrap" href="./dealer_cart.html">
                  Cart<span class="cart-number-label">99+</span>
                </a>
              </li>
              <li class="dropdown-item">
                <a class="nav-link" aria-current="page" href="../../index.html" style="color: red;">Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <!-- /navbar -->
  </div>
  <br>
  <hr style="border: rgb(103, 149, 255) 10px solid;" class="content">

  <div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
      <div class="col-md-3 border-right">
        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
          <span class="font-weight-bold rounded-circle mt-5">(dealer name)</span><span class="text-black-50">
            (dealer
            ID)
          </span><span> </span>
        </div>
      </div>
      <div class="col-md-5 border-right">
        <div class="p-3 py-5">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-right">Reset Password</h4>
          </div>
          <div class="col-md-12">
            <label class="labels">Current Password: </label><input type="password" id="myInput1" class="form-control"
                   value="">
            <input type="checkbox" onclick="myFunction1()">Show Password
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <label class="labels">New Password: </label><input type="password" id="myInput2" class="form-control"
                     value="">
              <input type="checkbox" onclick="myFunction2()">Show Password
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <label class="labels">Confirm Password: </label><input type="password" id="myInput3"
                       class="form-control" value="">
                <input type="checkbox" onclick="myFunction3()">Show Password
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-6 ">
                  <a href="dealer_information_update.html">
                      <button class="btn btn-primary profile-button" type="button">
                          Return
                      </button>
                  </a>
              </div>
              <div class="col-md-6 ">
                <button class="btn btn-primary profile-button" type="button">
                  Reset Password
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <p>© 2024 Smart & Luxury Motor Spares inc.</p>
  </footer>
</body>

</html>