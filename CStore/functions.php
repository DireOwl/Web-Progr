<?php
function checkForSession($privilege, $DBconn){
    if($_SESSION['login']){
        $login = $_SESSION['login'];
        $getPriv = mysqli_query($DBconn, "SELECT privilege FROM users WHERE login = '$login'");
        $getPriv = mysqli_fetch_array($getPriv);
        if($getPriv['privilege'] != $privilege){
            header("Location: ../index.php");
        }
    }else{
        header("Location: ../index.php");
    }
}
?>