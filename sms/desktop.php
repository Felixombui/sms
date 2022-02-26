<?php
include 'config.php';
//cURL function
function get_web_page( $myurl )
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
    );

    $ch      = curl_init( $myurl );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}
//end of function
$phonenumbers=$_GET['phonenumbers'];
$username=$_GET['username'];
$message=$_GET['message'];
//$senderid=$_GET['senderid'];
//find sender id
$custqry=mysqli_query($config,"SELECT * FROM customers WHERE username='$username'");
if(mysqli_num_rows($custqry)>0){
    $custrow=mysqli_fetch_assoc($custqry);
    $senderid=$custrow['senderID'];
    $phonenumber=explode(',',$phonenumbers);
$phonecount=count($phonenumber);
echo 'Phone Numbers: '.$phonecount.'<br>';
for ($i=0; $i < $phonecount; $i++) { 
    //convert phone number
    $chars=strlen($phonenumber[$i]);
    if($chars<11){
        $stripper=ltrim($phonenumber[$i],'0');
        $standardphone='254'.$stripper;
    }else{
        $standardphone=$phonenumber[$i];
    }
    $url='http://sms.macrasystems.com/sendsms/index.php?username='.$username.'&senderid='.$senderid.'&phonenumber='.$standardphone.'&message='.$message;
    if(get_web_page($url)){
        echo 'Success';
    }
}
}

?>