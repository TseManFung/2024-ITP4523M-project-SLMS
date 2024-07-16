$(document).ready(function () {
    $(".cta").bind("click", function () {
      GoToPage_POST("./dealer_delete_order.php", {
        orderID: $(this).attr("data-order-id"),
      });
    });
  });