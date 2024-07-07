<!DOCTYPE html>
<html>

<head>
  <?php
  // log out
  if(isset($_SESSION['userID'])){
    session_destroy();
  }
  ?>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

  <title>Login page</title>

  <!-- css -->
  <!-- icon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/login.css">
  <!-- /css -->

  <!-- js -->
  <script src="js/login.js"></script>
  <!-- /js -->
</head>

<body>
<form action="./pages/menu.php" method="post" id = "LoginForm">
  <div class="container">
    
    <h1>Login</h1>
    <div class="ipt-box">
      <input type="text" id="account" name = "LoginName" placeholder="account" autocomplete="off">
    </div>
    <div class="ipt-box">
      <input type="password" id="password" name = "Password" placeholder="password" autocomplete="off">
      <i class="fa-regular fa-eye-slash" style></i>
      <div class="beam"></div>
    </div>
    <button class="btn-login">login</button>
  
  </div></form>
</body>

</html>