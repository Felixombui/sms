<?php
include 'config.php';
if($_POST['submit']){
    $username=$_POST['username'];
    $infoqry=mysqli_query($config,"SELECT * FROM smscounter WHERE username='$username'");
    $inforow=mysqli_fetch_assoc($infoqry);
    $bal=$inforow['availablebalance'];
    $phonenumber=$inforow['phonenumber'];
    $newitems=$_POST['amount'];
    $available=$bal+$newitems;
    $updateinfo=mysqli_query($config,"UPDATE smscounter SET EntriesPurchased='$newitems',PrevBal='$bal',TotalEntries='$available',Usedentries='0',availablebalance='$available',`status`='Purchase' WHERE username='$username'");
    if($updateinfo){
        $sms=urlencode('Dear '.$username.', You have received '.$newitems.' SMS items. New sms balance is '.$available.'. Thank you for choosing Macra Systems.' );
        $url='http://sms.macrasystems.com/sendsms/index.php?username=Macra&senderid=SMARTLINK&phonenumber='.$phonenumber.'&message='.$sms.'';
        file_get_contents($url);
        $msg='<img src="images/tick.png" width="20" height="20">Purchase of sms was successful';
    }else{
        $msg='<img src="images/error.png" width="20" height="20">Purchase of sms failed!';
    }


}

include 'styles.html';
?>
<form name="smsform" method="post">
<select name="username">
<?php
$customerqry=mysqli_query($config,"SELECT * FROM customers");
while($customerRow=mysqli_fetch_assoc($customerqry)){
    echo '<option>'.$customerRow['username'].'</option>';
}
?>
</select><p>
    <input type="number" name="amount" placeholder="SMS Items purchased"></p>
    <p><input type="submit" name="submit" value="Next"></p>
    <?php echo $msg ?>
</form>