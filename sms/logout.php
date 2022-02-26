<?php
session_start();
session_destroy();
setcookie('smsuser',"",-3600);
header('location:login.php');
?>