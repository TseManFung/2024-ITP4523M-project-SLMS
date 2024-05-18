function SPassword_delete() {
    var x = document.getElementById("Password_delete");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
function SCPassword_delete() {
    var x = document.getElementById("CPassword_delete");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

