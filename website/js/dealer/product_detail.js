document.addEventListener('DOMContentLoaded', function() {
    const priceElement = document.getElementById('price');
    const priceValue = priceElement.getAttribute('data-value');
    const maxQty = parseInt(document.getElementById('quantityInput').max, 10);
  
    document.getElementById('quantityInput').addEventListener('input', function() {
      const quantityInput = document.getElementById('quantityInput');
      const quantity = parseInt(quantityInput.value, 10);
  
      if (quantity > maxQty) {
        quantityInput.value = maxQty;
      }
      if (quantity < 1) {
        quantityInput.value = 1;
      }
    });
  });

  function addToCartqty(id) {
    const itemID = id;
    const Qty = document.getElementById('quantityInput').value;
    $.ajax({
      type: "POST",
      url: "./product_detail_add.php",
      data: {
        sparePartNum: itemID,
        qty: Qty
      },
      success: function (data) {
        location.reload();
      }
    });
  }
