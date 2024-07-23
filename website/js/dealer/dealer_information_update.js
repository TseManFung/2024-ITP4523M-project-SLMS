function confirmEdition(CName, CNumber, FNumber, DAddress, dealerID) {
    $.ajax({
        type: "POST",
        url: "./update_information.php",
        data: {
            contactName: CName,
            contactNumber: CNumber,
            faxNumber: FNumber,
            deliveryAddress: DAddress,
            dealerID: dealerID
        },
        success: function (response) {
            //console.log("Success:", response);
            showmyModal("Success!", "Edition Success!", "./dealer_information_update.php");
        },
        error: function (xhr, status, error) {
            //console.error("Error:", status, error);
        }
    });
}

function showmyModal(tTitle, tbody, redirectUrl = null) {
    document.getElementById("exampleModalLongTitle").innerHTML = tTitle;
    document.getElementById("modal-body").innerHTML = tbody;
  
    if (redirectUrl) {
      $('#myModal').on('hidden.bs.modal', function () {
        window.location.href = redirectUrl;
      });
    } else {
      $('#myModal').off('hidden.bs.modal');
    }
  
    $('#myModal').modal('show');
  }