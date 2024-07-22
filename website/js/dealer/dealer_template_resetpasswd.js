function ShowCurrentPassword() {
    var x = document.getElementById("ShowCurrentPW");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
function ShowNewPassword() {
    var x = document.getElementById("ShowNewPW");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
function ShowConfirmPassword() {
    var x = document.getElementById("ShowConfirmPW");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
function showmyModal(tTitle,tbody){
    document.getElementById("exampleModalLongTitle").innerHTML=tTitle;
    document.getElementById("modal-body").innerHTML=tbody;
    $('#myModal').modal('show')
}
function ResetPS(USID) {
    var currentPWElement = document.getElementById("ShowCurrentPW");
    var newPWElement = document.getElementById("ShowNewPW");
    var confirmPWElement = document.getElementById("ShowConfirmPW");


    // 檢查三個輸入框是否都有值
    if (currentPWElement.value === "" || newPWElement.value === "" || confirmPWElement.value === "") {
        //alert("All fields are required.");
        showmyModal("Fail!","All fields are required.");
        return false;
    }
    if (currentPWElement.value === newPWElement.value) {
        //alert("All fields are required.");
        showmyModal("Fail!","This is the same as the current password.");
        return false;
    }
    var CPS = currentPWElement.value;  // 獲取用戶輸入的當前密碼

    //alert(hashedCPS);  // 顯示哈希後的密碼

    $.ajax({
        url: './checkPassword.php',
        type: 'POST',
        data: {
            UserID: USID,
            Password: CPS  // 發送哈希後的密碼
        },
        success: function (result) {
            if (result.password) {
                //alert(result.password);  // 顯示獲取到的密碼
                var NPW = newPWElement.value;
                var CfPW = confirmPWElement.value;
                if (NPW === CfPW) {
                    //alert("Passwords match.");
                    $.ajax({
                        type: "POST",
                        url: "./reset_password.php",
                        data: {
                            UserID: USID,
                            hashedNewPW: NPW,
                        },
                        success: function (response) {
                            console.log("Success:", response);
                            //alert("Edition Success!");
                            showmyModal("Success!","Edition Success!");
                            window.location.href = "../../index.php";
                        },
                        error: function (xhr, status, error) {
                            console.error("Error:", status, error);
                        }
                    });
                } else {
                    //alert("New password and confirm password do not match.");
                    showmyModal("Fail!","New password and confirm password do not match.");
                    return;
                }
            } else {
                //alert("Error from server: " + result.error);  // 顯示伺服器返回的錯誤信息
                showmyModal("Fail!",result.error);
                return;
            }
        },
        error: function (xhr, status, error) {
            console.error("Failed to fetch password. Status:", status, "Error:", error);  // 顯示請求失敗的錯誤信息
        }
    });
}
// st=>start: 用戶觸發 ResetPS 函數
// e=>end: 流程結束
// op1=>operation: 發送 AJAX 請求
// op2=>operation: 檢查 UserID
// op3=>operation: 執行 SQL 查詢
// op4=>operation: 返回查詢結果
// op5=>operation: 顯示密碼或錯誤信息

// cond1=>condition: 是否設置 UserID?
// cond2=>condition: 查詢是否成功?
// cond3=>condition: 是否查詢到密碼?

// st->op1->op2->cond1
// cond1(yes)->op3->cond2
// cond1(no)->op4
// cond2(yes)->cond3
// cond2(no)->op4
// cond3(yes)->op4
// cond3(no)->op4
// op4->op5->e