function editItem(itemID) {
  GoToPage_POST("./edit_delete_item.php", {"spnum": itemID});
}

function itemReport(itemID) {
  window.location.href = `./item_report_condition.php?spnum=${itemID}`;
}
