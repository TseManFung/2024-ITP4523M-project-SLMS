$(document).ready(function () {
  $("#show-order").bind("change", function () {
    var selectedOption = $(this).val();
    if (selectedOption === "N") {
      $(".btn-success").show();
      $(".btn-danger").show();
    } else if (selectedOption === "A") {
      $(".btn-success").hide();
      $(".btn-danger").hide();
    } else if (selectedOption === "R") {
      $(".btn-success").show();
      $(".btn-danger").hide();
    }
  });
  $(".btn-primary").bind("click", function () {
    window.location.href = "./view_order_detail.php";
  });
  $(".order-2many-item").bind("click", function () {
    window.location.href = "./view_order_detail.php";
  });
});
