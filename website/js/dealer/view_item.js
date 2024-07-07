function productDetail(itemID) {
  window.location.href = `./product_detail.php?spnum=${itemID}`;
}
function addToCart1(itemID) {
  $.ajax({
    type: "POST",
    url: "./addToCart.php",
    data: {
      sparePartNum: itemID,
      qty: 1
    },
    success: function (data) {
      location.reload();
    }
  });
  
}

function addToCart(itemID, quantity) {
  $.ajax({
    type: "POST",
    url: "./addToCart.php",
    data: {
      sparePartNum: itemID,
      qty: quantity
    },
    success: function (data) {
      window.location.href = "./dealer_cart.php";
    }
  });
  
}