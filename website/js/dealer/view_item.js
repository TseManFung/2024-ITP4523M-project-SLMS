$(document).ready(function () {
  $('button:contains("Add to cart")').bind("click", function (e) {
    console.log(e);
    console.log("add to cart clicked");
  });
  itemID = 123; // for test
  $('button:contains("Show more detail")').bind("click", function (e) {
    window.location.href = `./product_detail.html?spnum=${itemID}`;
  });
});
