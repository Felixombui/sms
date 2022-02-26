<?php
include 'headers.php';
$senderid=$_SESSION['senderid'];
if(isset($_POST['import'])){
    if($_FILES['file']['name']){
        $filename=explode('.',$_FILES['file']['name']);
        if($filename[1]=='csv'){
            $handle=fopen($_FILES['file']['tmp_name'],"r");
            $sentmessages=0;
           
            while($data=fgetcsv($handle)){
                $phonenumber=addslashes($data[0]);
                $message=addslashes($data[1]);
                $sms=urlencode($message);                                   
                        
                        
                        
                            //new sms api
                        $chars=strlen($phonenumber);
                        if($chars=10){
                            $newnumber=ltrim($phonenumber,'0');
                            $phonenumber='254'.$newnumber;
                        }
                        $url='http://sms.macrasystems.com/sendsms/index.php?username='.$username.'&senderid='.$senderid.'&phonenumber='.$phonenumber.'&message='.$sms.'';
                            file_get_contents($url);
                        //end of new sms api
                        $message=urldecode($sms);
                        $sentmessages=$sentmessages+1;
                        
                    
                            
                }
            $err= '<img src="images/success.png" width="18" height="18"> '.$sentmessages.' messages sent successfully.';
        }else{
            $err='The file you selected is not csv! Please select a valid file.';
        }
    }else{
        $err='Please select a file!';
    }
}

if($_POST['send']){
    $phonenumbers=addslashes($_POST['phonenumbers']);
    $message=addslashes($_POST['message']);
    if(empty($phonenumbers)){
        $err='<img src="images/error.png" width="20" height="20"> Error! Please enter at least 1 phone number.';
    }else{
        if(empty($message)){
            $err='<img src="images/error.png" width="20" height="20"> Error! Please type a message.';
        }else{
            
            $message=urlencode($message);
            $url='http://sms.macrasystems.com/sendsms/index.php?username='.$username.'&senderid='.$senderid.'&phonenumber='.$phonenumbers.'&message='.$message.'';
            file_get_contents($url);
            $err='<img src="images/success.png" width="20" height="20"> Message sent successfully.';
        }
    }
}
?>
<body background="images/bgimg.jpg">
    
<table width="100%"  align="left"><tr><td align="left">
    <form name="import" method="post" enctype="multipart/form-data">Import from CSV:<input type="file" name="file"><br><input type="submit" name="import" value="Send from CSV"></form> Or
    <form action="" method="post">
        <table width="50%"><tr><td><input type="text" name="phonenumbers" placeholder="Phone numbers separated with comma. e.g 254701123456"></td></tr>
        <tr><td><textarea name="message" placeholder="Type Message here..." rows="10"></textarea></td></tr>
        <tr><td><input type="submit" name="send" value="Send Message"></td></tr>
        <tr><td><?php echo $err ?></td></tr>
    </table>
    </form>
</td></tr></table>
</body>