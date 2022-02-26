<?php
include 'config.php';
include 'styles.html';

if($_POST['submit']){
    $phonenumber=addslashes($_POST['phonenumber']);
    $chars=strlen($phonenumber);
    if($chars<11){
        $editphone=ltrim($phonenumber,'0');
        $phonenumber2='254'.$editphone;
    }else{
        $phonenumber2=$phonenumber;
    }
    $qry=mysqli_query($config,"SELECT * FROM customers WHERE PhoneNumber='$phonenumber' or PhoneNumber='$phonenumber2'");
    if(mysqli_num_rows($qry)>0){
        $row=mysqli_fetch_assoc($qry);
        $username=$row['username'];
        $senderid=$row['SenderId'];
        
        $permitted_chars = '0123456789';
        $randomstring= substr(str_shuffle($permitted_chars), 0, 4).'';
        $password=md5($randomstring,false);
        $resetqry=mysqli_query($config,"UPDATE customers SET `password`='$password' WHERE PhoneNumber='$phonenumber' or PhoneNumber='$phonenumber2'");
        if($resetqry){
            $message=urlencode('Dear '.$username.', Your password has been reset successfully. Your new pasword is: '.$randomstring.' Thank you for choosing Macra Systems.');
            $url='http://sms.macrasystems.com/sendsms/index.php?username=Macra&senderid=SMARTLINK&phonenumber='.$phonenumber2.'&message='.$message.'';
            file_get_contents($url);
            $msg='<span class="error"><img src="images/success.png" width="20" height="20">Password has been sent to your phone. <a href="login.php">Go to Login</a></span>';
        }else{
            $msg='<span class="error"><img src="images/error.png" width="20" height="20">Password reset failed! Please contact admin.</a></span>';
        }

    }else{
        $msg='<span class="error"><img src="images/error.png" width="20" height="20">The phone number you entered does not exist!</a></span>';
    }
}
?>
<body background="images/bgimg.jpg">
<div id="parent">
<form id="form_login" method="post">
<img src="images/logo.JPG" width="250" height="120"><br>
    <input type="text" name="phonenumber" placeholder="Enter your phone number">
    <p><input type="submit" name="submit" value="Reset"></p>
    <?php echo $msg ?>
</form>
</body>