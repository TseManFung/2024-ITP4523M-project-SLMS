$(document).ready(function() {
    $(".order-2many-item").bind("click", function () {
        console.log("click");
    });
    $(".cta").bind("click", function () {
        window.location.href = "./dealer_view_order_record_detail.html";
      });
});