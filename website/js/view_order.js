$(document).ready(function () {
  const myModal = $("#myModal");
  const DeliveryDate = $("#deliveryDate");
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

  $(".btn-primary[data-order-id]").bind("click", function () {
    GoToPage_POST("./view_order_detail.php", {
      orderID: $(this).attr("data-order-id"),
    });
  });
  $(".btn-primary[Accept]").bind("click", function () {
    if (DeliveryDate.val() === "") {
      alert("Please enter delivery date");
      return;
    }
    $.ajax({
      url: "./update_order.php",
      type: "POST",
      data: {
        deliveryDate: $("#deliveryDate").val(),
        orderID: $(this).attr("order-id"),
        state: "A",
      },
      success: function (data) {
        location.reload();
      },
    });
  });
  $(".btn-success[data-order-id]").bind("click", function () {
    $(".btn-primary[Accept]").attr("order-id", $(this).attr("data-order-id"));
    $("#deliveryDate").val("");
    myModal.modal("show");
    myModal.on('shown.bs.modal', function () {
      DeliveryDate.focus();
    });
    //DeliveryDate.attr("data-order-id", $(this).attr("data-order-id"));
  });

  $(".btn-danger[data-order-id]").bind("click", function () {
    setState($(this).attr("data-order-id"),"R");
  });

  $(".order-2many-item").bind("click", function () {
    GoToPage_POST("./view_order_detail.php", {
      orderID: $(this).attr("data-order-id"),
    });
  });
});

function setState(orderID,state){
  $.ajax({
    url: "./update_order.php",
    type: "POST",
    data: {
      orderID: orderID,
      state: state,
    },
    success: function (data) {
      location.reload();
    },
  });
}