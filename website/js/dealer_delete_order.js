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
        $('#myModal').on('hidden.bs.modal', function() {
            window.location.href = redirectUrl;
        });
    } else {
        $('#myModal').off('hidden.bs.modal'); // 移除以前的重定向绑定
    }

    $('#myModal').modal('show');
}

function closeModal() {
    $('#myModal').modal('hide');
}

function deleteOrder(USID, orderID) {
    var PWElement = document.getElementById("Password_delete");

    // 检查输入字段是否有值
    if (PWElement.value === "") {
        showmyModal("Fail!", "All fields are required.");
        return false;
    }

    var PW = PWElement.value;  // 获取用户输入的当前密码
    var hashedPW = CryptoJS.SHA256(PW).toString();  // 使用 SHA-256 哈希密码
    hashedPW = "0" + hashedPW;

    // 验证密码
    $.ajax({
        url: './checkPassword.php',
        type: 'POST',
        data: {
            UserID: USID,
            Password: hashedPW  // 发送哈希密码
        },
        dataType: 'json',
        success: function (result) {
            if (result.password) {
                // 密码正确，继续删除订单
                $.ajax({
                    type: "POST",
                    url: "./delete_order.php",
                    data: {
                        orderID: orderID  // 确保与 PHP 键匹配
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            console.log("Success:", response);
                            showmyModal("Successfully", "Order successfully cancelled!", "./search_item.php");
                        } else {
                            showmyModal("Fail!", response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error:", status, error);
                        console.log("Response:", xhr.responseText);
                        showmyModal("Fail!", "An error occurred while processing your request. Please try again later.");
                    }
                });
            } else {
                showmyModal("Fail!", result.error);
            }
        },
        error: function (xhr, status, error) {
            console.error("Failed to fetch password. Status:", status, "Error:", error);
            showmyModal("Fail!", "An error occurred while fetching the password. Please try again later.");
        }
    });
}