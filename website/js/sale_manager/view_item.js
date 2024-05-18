$(document).ready(function () {
  $('button:contains("Manage this item")').bind("click", function () {
    window.location.href = "./edit_delete_item.html";
  });
  itemID = 123; // for test
  $('button:contains("Report of this spare")').bind("click", function (e) {
    console.log(e);
    window.location.href = `./item_report_condition.html?spnum=${itemID}`;
  });
});
