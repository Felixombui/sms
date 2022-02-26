<?php

include 'config.php';
if ( isset( $_COOKIE['smsuser'] ) ) {
    $username = $_COOKIE['smsuser'];
    $loginqry = mysqli_query( $config, "SELECT * FROM customers WHERE username='$username'" );
    if ( mysqli_num_rows( $loginqry )>0 ) {
        $loginrow = mysqli_fetch_assoc( $loginqry );
        session_start();
        $_SESSION['customername'] = $loginrow['Names'];
        $_SESSION['senderid'] = $loginrow['SenderID'];
        $_SESSION['email'] = $loginrow['Email'];
        $_SESSION['phonenumber'] = $loginrow['PhoneNumber'];
        //setcookie( 'smsuser', $username, time()*10*12*30*24*60*60 );
        header( 'location:home.php' );
    } else {
        setcookie( 'smsuser', '', -3600 );
    }
} else {
    if ( $_POST['login'] ) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ( empty( $username ) ) {
            $msg = '<img src="images/error.png" width="25" height="25"> You must enter your username!';
        } else {
            if ( empty( $password ) ) {
                $msg = '<img src="images/error.png" width="25" height="25"> You must enter your password!';

            } else {
                $encpassword = md5( $password, false );
                $loginqry = mysqli_query( $config, "SELECT * FROM customers WHERE username='$username' AND `password`='$encpassword'" );
                if ( mysqli_num_rows( $loginqry )>0 ) {
                    $loginrow = mysqli_fetch_assoc( $loginqry );
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['customername'] = $loginrow['Names'];
                    $_SESSION['senderid'] = $loginrow['SenderID'];
                    $_SESSION['email'] = $loginrow['Email'];
                    $_SESSION['phonenumber'] = $loginrow['PhoneNumber'];
                    setcookie( 'smsuser', $username, time()+60*60*24*30*12*10 );
                    header( 'location:home.php' );
                } else {
                    $msg = '<img src="images/error.png" width="25" height="25"> Login failed! Wrong credentials';
                }
            }
        }
    }
}
include 'styles.html';
?>

<table><tr><td align = 'center'></td></tr></table>
<div id = 'parent'>
<form id = 'form_login' method = 'post'>
<img src = 'images/logo.JPG' width = '250' height = '120'><br>
<input type = 'text' name = 'username' placeholder = 'Please enter your username'>
<p><input type = 'password' name = 'password' placeholder = 'Please enter your password'></p>
<p><input type = 'submit' name = 'login' value = 'Login'>
<p><a href = 'recover.php'>Forgot your password?</a></p>
<p>No account? <a href = 'signup.php'>Join us Now</a></p>
<p><?php echo $msg ?>
</form>
</div>
