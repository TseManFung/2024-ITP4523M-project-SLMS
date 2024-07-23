function SPassword_delete() {
    var x = document.getElementById("Password_delete");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
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

function closeModal() {
    $('#myModal').modal('hide');
}

function deleteOrder(USID, orderID) {
    var PWElement = document.getElementById("Password_delete");


    if (PWElement.value === "") {
        showmyModal("Fail!", "All fields are required.");
        return false;
    }

    var PW = PWElement.value;  
    // check password
    $.ajax({
        url: './checkPassword.php',
        type: 'POST',
        data: {
            UserID: USID,
            Password: PW  // 
        },
        dataType: 'json',
        success: function (result) {
            if (result.password) {
                
                $.ajax({
                    type: "POST",
                    url: "./delete_order.php",
                    data: {
                        orderID: orderID  
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            showmyModal("Successfully", "Order successfully cancelled!", "./search_item.php");
                        } else {
                            showmyModal("Fail!", response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        showmyModal("Fail!", "An error occurred while processing your request. Please try again later.");
                    }
                });
            } else {
                showmyModal("Fail!", result.error);
            }
        },
        error: function (xhr, status, error) {
            showmyModal("Fail!", "An error occurred while fetching the password. Please try again later.");
        }
    });
}
