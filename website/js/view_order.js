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
    GoToPage_POST("./view_order_detail.php", {
      orderID: $(this).attr("data-order-id"),
    });
  });

  $(".btn-success").bind("click", function () {
    $.ajax({
      url: "./update_order.php",
      type: "POST",
      data: {
        orderID: $(this).attr("data-order-id"),
        state: "A",
      },
      success: function (data) {
        location.reload();
      },
    });
  });

  $(".btn-danger").bind("click", function () {
    $.ajax({
      url: "./update_order.php",
      type: "POST",
      data: {
        orderID: $(this).attr("data-order-id"),
        state: "R",
      },
      success: function (data) {
        location.reload();
      },
    });
  });

  $(".order-2many-item").bind("click", function () {
    GoToPage_POST("./view_order_detail.php", {
      orderID: $(this).attr("data-order-id"),
    });
  });
});
