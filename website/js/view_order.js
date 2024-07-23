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
    if ($("#deliveryDate").val() === "") {
      alert("Please enter delivery date");
      return;
    }
  
    let orderID = $(this).attr("order-id");
    let sql = `UPDATE spareQty s
     JOIN (SELECT os.sparePartNum, os.orderQty
           FROM orderSpare os
           JOIN \`order\` o ON os.orderID = o.orderID
           WHERE os.orderID = ${orderID} AND (o.state = 'R' OR o.state = 'U')) o
       ON s.sparePartNum = o.sparePartNum
  SET s.stockItemQty = s.stockItemQty - o.orderQty;`;
  
    $.ajax({
      url: "../db/query.php",
      type: "POST",
      data: {
        query: sql,
      },
      success: function (data) {
        $.ajax({
          url: "./update_order.php",
          type: "POST",
          data: {
            deliveryDate: $("#deliveryDate").val(),
            orderID: orderID,
            state: "A",
          },
          success: function (data) {
            location.reload();
          },
          error: function (error) {
            console.error("Error updating order state:", error);
          }
        });
      },
      error: function (error) {
        console.error("Error updating spareQty:", error);
      }
    });
  });
  $(".btn-success[data-order-id]").bind("click", function () {
    $(".btn-primary[Accept]").attr("order-id", $(this).attr("data-order-id"));
    $("#deliveryDate").val("");
    myModal.modal("show");
    myModal.on("shown.bs.modal", function () {
      DeliveryDate.focus();
    });
    //DeliveryDate.attr("data-order-id", $(this).attr("data-order-id"));
  });

  $(".btn-danger[data-order-id]").bind("click", function () {
    setState($(this).attr("data-order-id"), "R");
  });

  $(".order-2many-item").bind("click", function () {
    GoToPage_POST("./view_order_detail.php", {
      orderID: $(this).attr("data-order-id"),
    });
  });
});

function setState(orderID, state) {
  if (state === "R" || state === "U") {
    let sql = `UPDATE spareQty s
      JOIN (SELECT sparePartNum, orderQty
      FROM orderSpare
      WHERE orderID = ${orderID}) o
      ON s.sparePartNum = o.sparePartNum
      SET s.stockItemQty = s.stockItemQty + o.orderQty;
      UPDATE \`order\` SET \`isPaid\` = 0, \`receipt\` = NULL WHERE (\`orderID\` = ${orderID});`;

    $.ajax({
      url: "../db/query.php",
      type: "POST",
      data: {
        query: sql,
      },
      success: function (data) {
        updateOrderState(orderID, state);
      },
      error: function (error) {
        console.error("Error updating spareQty:", error);
      },
    });
  } else {
    updateOrderState(orderID, state);
  }
}

function updateOrderState(orderID, state) {
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
    error: function (error) {
      console.error("Error updating order state:", error);
    },
  });
}
