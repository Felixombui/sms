<?php
session_start();
if(empty($_SESSION['customername'])){
    header('location:login.php');
}else{
    header('location:home.php');
}
?>