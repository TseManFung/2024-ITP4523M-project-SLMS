$(document).ready(function () {
  $('button:contains("Add to cart")').bind("click", function (e) {
    console.log(e);
    console.log("add to cart clicked");
  });


});
function productDetail(itemID) {
  window.location.href = `./product_detail.php?spnum=${itemID}`;
}
function addToCart(itemID) {
  $.ajax({
    type: "POST",
    url: "./addToCart.php",
    data: {
      sparePartNum: itemID,
      quantity: 1
    },
    success: function (data) {
      //console.log(data);
    }
  });
}