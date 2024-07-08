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
            console.log("Success:", response);
            alert("Edition Success!");
            window.location.href = "./dealer_information_update.php";
        },
        error: function (xhr, status, error) {
            console.error("Error:", status, error);
        }
    });
}

