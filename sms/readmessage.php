<?php
include 'headers.php';
$id=$_GET['id'];
$msgqry=mysqli_query($config,"SELECT * FROM messages WHERE id='$id'");
$msgrow=mysqli_fetch_assoc($msgqry);
?>
<body background="images/bgimg.jpg">
<table class="notifications" border="1"><tr><td>Message to <?php echo $msgrow['PhoneNo'] ?></td></tr>
<tr><td align="left"><?php echo $msgrow['Message'] ?></td></tr>
</table>
</body>