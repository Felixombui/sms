<?php
include 'headers.php';
$mysmsqry=mysqli_query($config,"SELECT * FROM messages WHERE sender='$username' ORDER BY id DESC");
function custom_echo($x, $length)
{
  if(strlen($x)<=$length)
  {
    echo $x;
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    echo $y;
  }
}
?>
<body background="images/bgimg.jpg">
<table><tr><td align="left"><a href="newsms.php"><img src="images/newmessage.png" width="23" height="23" align="left">Send Message</a></td></tr></table>
<table width="50%"><tr><td>To</td><td>Message</td><td>Status</td><td>Units</td></tr>
<?php
while($mysms=mysqli_fetch_assoc($mysmsqry)){
    $id=$mysms['id'];
    echo '<tr><td align="left">'.$mysms['PhoneNo'].'</td><td align="left"><a href="readmessage.php?id='.$id.'">';
    custom_echo($mysms['Message'],14);
    echo '</a></td><td>'.$mysms['Status'].'</td><td>'.$mysms['units'].'</td></tr>';
}
?>
</table>
</body>