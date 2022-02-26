<?php
include 'headers.php';
$username = $_COOKIE['smsuser'];
$config2 = mysqli_connect( 'macrasystems.com', 'macrasys', 'playgroundkasa2015', 'macrasys_mpesa' ) or die( 'Error! System failed to initialize' );
if ( $_POST['order'] ) {
    $items = $_POST['items'];

    if ( $items>10000 ) {
        $rate = 0.85;
    } else {
        if ( $items>4999 && $item<10001 ) {
            $rate = 0.9;
        } else {
            if ( $items>999 && $items<5000 ) {
                $rate = 1;
            }
        }

    }

    if ( $items<1000 ) {
        $msg = '<img src="images/error.png" width="20" height="20" align="left"> Your order must be over 1000 sms items!';
    } else {
        $cost = $items*$rate;
        $msg = 'Ordered items: '.$items.'<br> Rate: Ksh.'.$rate.'<br>Go to Mpesa<br>>>Lipa na Mpesa<br>>>Buy Goods<br>>>Enter Till Number: 5354881<br>>>Amount Payable: Ksh.'.$cost.'<br>>>Enter pin and confirm<p>
        <form method="post"><input type="text" name="code" placeholder="Enter Mpesa Transaction Id"><input type="submit" name="confirm" value="Confirm"></form>';

    }
}
if ( isset( $_POST['confirm'] ) ) {
    $code = addslashes( $_POST['code'] );
    $confirmqry = mysqli_query( $config2, "SELECT * FROM mpesa_payments WHERE TransID='$code'" );
    if ( mysqli_num_rows( $confirmqry )>0 ) {
        $confirmrow = mysqli_fetch_assoc( $confirmqry );
        $status = $confirmrow['status'];
        $amountPaid = $confirmrow['TransAmount'];
        if ( $status == 'Unused' ) {
            if ( $amountPaid>1000 ) {
                if ( $amountPaid>10000 ) {
                    $rate = 0.85;
                } else {
                    if ( $amountPaid>4999 && $item<10001 ) {
                        $rate = 0.9;
                    } else {
                        if ( $amountPaid>999 && $items<5000 ) {
                            $rate = 1;
                        }
                    }

                }
                $itemspurchased = $amountPaid/$rate;
                $checkcount = mysqli_query( $config, "SELECT * FROM smscounter WHERE username='$username'" );
                $checkrow = mysqli_fetch_assoc( $checkcount );
                $prev = $checkrow['availablebalance'];
                $total = $itemspurchased+$prev;
                $cstatus = 'Purchase';
                $phonenumber = $checkrow['phonenumber'];
                if ( mysqli_query( $config, "UPDATE smscounter SET EntriesPurchased='$itemspurchased',PrevBal='$prev',TotalEntries='$total',Usedentries='0.0',availablebalance='$total',`status`='Purchase' WHERE username='$username'" ) ) {
                    if ( mysqli_query( $config2, "UPDATE mpesa_payments SET `status`='Used' WHERE TransID='$code'" ) ) {
                        $sms = urlencode( 'Dear '.$username.', You have received '.$itemspurchased.' SMS items. New sms balance is '.$total.'. Thank you for choosing Macra Systems.' );
                        $url = 'http://sms.macrasystems.com/sendsms/index.php?username=Macra&senderid=SMARTLINK&phonenumber='.$phonenumber.'&message='.$sms;
                        file_get_contents( $url );
                        $msg = '<img src="images/tick.png" width="20" height="20" align="left">Transaction was successful';
                    } else {
                        $msg = '<img src="images/tick.png" width="20" height="20" align="left"> Error! Transaction failed at backend. Please contact 0708138498.';
                    }
                } else {
                    $msg = '<img src="images/tick.png" width="20" height="20" align="left"> Error! Transaction failed at counter. Please contact 0708138498.';
                }
            } else {
                $msg = '<img src="images/error.png" width="20" height="20" align="left">You cannot purchase less than 1000 sms items! You paid '.$amountPaid.' Please contact our office on 0708138498';

            }
        } else {
            $msg = '<img src="images/error.png" width="20" height="20" align="left">Your payments were received and the transaction code has been used on another purchase!';
        }
    } else {
        $msg = '<img src="images/error.png" width="20" height="20" align="left">We have not received your payments!';
    }
}
include 'styles.html';
echo 'Check our rates.';

?>
<style>
body {
    color: white;
}

</style>

<body background = 'images/bgimg.jpg'>
<table width = '100%'>
<tr><td>
<form action = '' method = 'POST'>
<table width = '50%'><tr><td>
Items
</td>
<td><input type = 'number' name = 'items'></td>
</tr>
<tr><td></td><td><input type = 'submit' name = 'order' value = 'Check rate'></td></tr>
</table>
</form>
</td></tr>
</table>
<?php echo $msg ?>