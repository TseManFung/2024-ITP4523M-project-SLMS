$(document).ready(function () {
  $(".order-2many-item").bind("click", function () {
    GoToPage_POST("./dealer_view_order_record_detail.php", {
      orderID: $(this).attr("data-order-id"),
    });
  });
  $(".cta").bind("click", function () {
    GoToPage_POST("./dealer_view_order_record_detail.php", {
      orderID: $(this).attr("data-order-id"),
    });
  });
});
