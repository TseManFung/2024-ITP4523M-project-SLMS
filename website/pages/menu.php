<?php
require_once 'db/dbconnect.php';
$sql = sprintf("SELECT *,count(*) as resultNum FROM `user` WHERE `LoginName` = '%s' AND `Password` = concat('0',sha2('%s',256));", $_POST['LoginName'], $_POST['Password']);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
// userID, LoginName, password, salesManagerID, dealerID, resultNum
/* btnLogin.addEventListener('click',function(e){
if(accountInput.value === 'D'){
    window.location.href = "pages/dealer/search_item.html";
}else if(accountInput.value === 'SM'){
    window.location.href = "pages/sale_manager/view_order.html";

}
});
}) */
session_start();

if ($row['resultNum'] == 1 && $row['LoginName'] == $_POST['LoginName']) {
    
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);

    $_SESSION['userID'] = $row['userID'];
    if ($row['salesManagerID'] != null) {
        $_SESSION['salesManagerID'] = $row['salesManagerID'];
        header('Location: sale_manager/view_order.php');
    } else {
        $_SESSION['dealerID'] = $row['dealerID'];
        $sql = sprintf("SELECT dealerName FROM dealer where dealerID = %d;", $row['dealerID']);
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['dealerName'] = $row['dealerName'];
        header('Location: dealer/search_item.php');
    }
    
} else {
    $_SESSION["Loginfail"] = "Invalid Login Name or Password";
    header('Location: ../');
}