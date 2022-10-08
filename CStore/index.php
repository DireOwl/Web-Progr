<?php
session_start();

include "mysql.php";

if($_SESSION['login']){
    switch($_SESSION['privilege']){
        case 'admin':
            header("Location: admin");
            break;
                    
        case 'user':
            header("Location: user");
            break;
    }
}

if(isset($_POST['login_form_button'])){
    $login =  $_POST['login'];
    $password =  $_POST['password'];
    
    $getUsersToLogin = mysqli_query($link, "SELECT * FROM users WHERE login='$login' AND password='$password'");
	
    if($getUsersToLogin){
		if(mysqli_num_rows($getUsersToLogin) == 1){
			$user = mysqli_fetch_array($getUsersToLogin);
            $_SESSION['login'] = $user['login'];
            $_SESSION['privilege'] = $user['privilege'];
            
            switch($_SESSION['privilege']){
                case 'admin':
                    header("Location: admin");
                    break;
                    
                case 'user':
                    header("Location: user");
                    break;
            }
		}else{
            echo '<div class="alert"><p>Неверный логин или пароль</p></div>';
        }
	} 
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="style.css" rel="stylesheet">
    </head>
    
    <body style="margin: 0px; height: 100%;">
        <div class="container"> 
            <div class="login_form_handler">
                <form method="POST">
                    <p>Ведите логин и пароль</p>
                    <p><input class="login_form_input" name="login" type="text" placeholder="Логин"></p>
                    <p><input class="login_form_input" name="password" type="password" placeholder="Пароль"></p>
                    <p><input class="login_form_button" name="login_form_button" type="submit" value="Войти"></p>
                </form>
            </div>
        </div>
    </body>
</html>