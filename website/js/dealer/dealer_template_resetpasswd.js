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



    if (currentPWElement.value === "" || newPWElement.value === "" || confirmPWElement.value === "") {
        //alert("All fields are required.");
        showmyModal("Fail!","All fields are required.");
        return false;
    }
    if (currentPWElement.value === newPWElement.value) {
        //alert("All fields are required.");
        showmyModal("Fail!","This is a invalid password.");
        return false;
    }
    var CPS = currentPWElement.value;  // get user intered passwd

    //alert(hashedCPS);  // 

    $.ajax({
        url: './checkPassword.php',
        type: 'POST',
        data: {
            UserID: USID,
            Password: CPS  // 
        },
        success: function (result) {
            if (result.password) {
                //alert(result.password);  
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
                            //console.log("Success:", response);
                            //alert("Edition Success!");
                            showmyModal("Success!","Edition Success!");
                            window.location.href = "../../index.php";
                        },
                        error: function (xhr, status, error) {
                            //console.error("Error:", status, error);
                        }
                    });
                } else {
                    //alert("New password and confirm password do not match.");
                    showmyModal("Fail!","New password and confirm password do not match.");
                    return;
                }
            } else {
                //alert("Error from server: " + result.error);
                showmyModal("Fail!",result.error);
                return;
            }
        },
        error: function (xhr, status, error) {
            //console.error("Failed to fetch password. Status:", status, "Error:", error);
        }
    });
}
