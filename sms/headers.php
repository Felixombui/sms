<?php
session_start();
if(empty($_SESSION['customername'])){
    header('location:login.php');
}
include 'config.php';
include 'styles.html';
$username=$_SESSION['customername'];
$balqry=mysqli_query($config,"SELECT * FROM smscounter WHERE username='$username'");
if(mysqli_num_rows($balqry)>0){
    $balrow=mysqli_fetch_assoc($balqry);
    $smsbalance=$balrow['availablebalance'];
}else{
    $smsbalance='0';
}
$msgqry=mysqli_query($config,"SELECT * FROM messages WHERE sender='$username'");
$messages=mysqli_num_rows($msgqry);
?>
<table class="heading" width="100%"><tr><td align="left">
   <img src="images/user.png" width="20" height="20" align="left"><?php echo $_SESSION['customername'] ?> [<a href="logout.php">Logout</a>]
</td>
<td width="17%" align="center"><a href="home.php">Home<br></a>&nbsp;</td>
<td width="17%" align="center"><a href="messages.php">Sent<br><?php echo $messages ?></a></td>
<td width="17%" align="center"><a href="buysms01.php">Balance<br><?php echo $smsbalance ?></a></td>

</tr></table>
<p>