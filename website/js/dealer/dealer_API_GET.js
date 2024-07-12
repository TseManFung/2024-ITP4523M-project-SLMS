function addToCartqty() {
    const itemID = "<?php echo $detail['sparePartNum']; ?>";
    const Qty = document.getElementById('quantityInput').value;
    $.ajax({
      type: "POST",
      url: "./addToCart.php",
      data: {
        sparePartNum: itemID,
        qty: Qty
      },
      success: function (data) {
        location.reload();
      }
    });
  }