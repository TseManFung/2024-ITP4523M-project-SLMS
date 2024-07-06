<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

  <title>Order Deatil</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/reset.css">
  <link rel="stylesheet" href="../../css/common.css">
  <link rel="stylesheet" href="../../css/bs/bootstrap.css">
  <link rel="stylesheet" href="../../css/dealer_view_orderrecord_token.css">
  <link rel="stylesheet" href="../../css/dealer_view_orderrecord.css" />

  <!-- /css -->
  <!-- js -->
  <script src="../../js/common.js"></script>
  <script src="../../js/bs/bootstrap.bundle.js"></script>
  <script src="../../js/add_itemm.js"></script>
  <script src="../../js/dealer_view_orderrecord_token.js"></script>
  <script src="../../js/view_order_record.js"></script>
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
  <!-- header -->
  <div style="height: calc(0lvh + 56px);" id="header"></div>
  <!-- /header -->
  <!-- content -->
  <div class="content-bg">
    <div class="container">
      <section class="h-100 gradient-custom">
        <div class="container py-5 h-100">
          <div class="row child-center-flex h-100">
            <div class="col-lg-10 col-xl-8">
              <div class="card" style="border-radius: 10px;">
                <div class="card-header px-4 py-5">
                  <div class="row">
                    <div class="col">
                      <h5 class="text-muted mb-0">Thanks for your Order, <a>(dealername)</a>!</h5>
                      <br />
                      <div class="col">
                          <a href="./dealer_delete_order.html">
                              <button class="cta">
                                  <span>Delete this Order</span>
                                  <svg width="15px" height="10px" viewBox="0 0 13 10">
                                      <path d="M1,5 L11,5"></path>
                                      <polyline points="8 1 12 5 8 9"></polyline>
                                  </svg>
                              </button>
                          </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="lead fw-normal mb-0">(Order ID)</p>
                        <p class="small text-muted mb-0">Sales Manager ID: (ID)</p>
                    </div>
                    <div class="card shadow-0 border mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0">Item picture</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0">Spare name</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small">Categories</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small">Qantity</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small">Price</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small">Total Price</p>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="../../images/item/100002.jpg" class="img-fluid" alt="1000002">
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0">(item name)</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small">(ABCD)</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small">10</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small">$100</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small">$1000</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="../../images/item/100001.jpg" class="img-fluid" alt="100001">
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0">(item name)</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small">(ABCD)</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small"> 5</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small">$100</p>
                                </div>
                                <div class="col-md-2 text-center child-center-flex">
                                    <p class="text-muted mb-0 small">$500</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="fw-bold mb-0">Order Details</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0">
                            <span class="fw-bold me-4">Order Price:</span>price
                        </p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0">
                            <span class="fw-bold me-4">Order ID :</span>788152
                        </p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0">
                            <span class="fw-bold me-4">
                                Order Date & Time
                                :
                            </span>22 Dec,2019(12:00)
                        </p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0">
                            <span class="fw-bold me-4">
                                Manager’s Contact
                                Name:
                            </span>name
                        </p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0">
                            <span class="fw-bold me-4">
                                Manager’s Contact
                                Number:
                            </span>27272727
                        </p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0">
                            <span class="fw-bold me-4">
                                Delivery Address
                                :
                            </span>your home
                        </p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0">
                            <span class="fw-bold me-4">Delivery Cost:</span>
                            321312321
                        </p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0">
                            <span class="fw-bold me-4">Delivery Date</span> 22
                            Dec,2020
                        </p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0">
                            <span class="fw-bold me-4">Total Weight：</span> 1541
                        </p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p class="text-muted mb-0">
                            <span class="fw-bold me-4">Total Spares：</span> 15
                        </p>
                    </div>
                    <br />
                    <div class="row d-flex align-items-center">
                        <div class="col-md-2">
                            <p class="text-muted mb-0 small">Order Status</p>
                        </div>
                        <div class="col-md-10">
                            <div class="progress" style="height: 6px; border-radius: 16px;">
                                <div class="progress-bar" role="progressbar"
                                     style="width: 20%;--bs-progress-bar-bg:cornflowerblue;"></div>
                            </div>
                            <div class="d-flex justify-content-around mb-1">
                                <p class="text-muted mt-1 mb-0 small ms-xl-5">Create Order</p>
                                <p class="text-muted mt-1 mb-0 small ms-xl-5">Accept</p>
                                <p class="text-muted mt-1 mb-0 small ms-xl-5">In Transmit</p>
                                <p class="text-muted mt-1 mb-0 small ms-xl-5">this order is finished</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer border-0 px-4 py-5">
                  <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">
                    Total Order Amount: <span class="h2 mb-0 ms-2">$1500</span>
                  </h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
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
    <p>© 2024 Smart & Luxury Motor Spares inc.</p>
  </footer>
  <!-- return top -->

  <div id="page-top" style="">
    <a href="#header"><img src="../../images/common/returan-top.png"></a>
  </div>

  <!-- /return top -->
</body>

</html>