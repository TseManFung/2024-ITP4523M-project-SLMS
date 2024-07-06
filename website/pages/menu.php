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
if ($row['resultNum'] == 1) {
    session_start();
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);

    $_SESSION['userID'] = $row['userID'];
    if ($row['salesManagerID'] != null) {
        $_SESSION['salesManagerID'] = $row['salesManagerID'];
        header('Location: sale_manager/view_order.php');
    } else {
        $_SESSION['dealerID'] = $row['dealerID'];
        header('Location: dealer/search_item.php');
    }
    
} else {
    header('Location: ../');
}