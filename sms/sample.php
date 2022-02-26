<?php
function get_web_page( $url )
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

    $ch      = curl_init( $url );
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
if($_POST['send']){
    $myurl="https://sms.movesms.co.ke/api/compose?username=Mandela&api_key=ee68o4oF1PSJM5nBbfRf8IhtBw6zh31ymlapvGR2dlSJPYAGys&sender=MDL&to=254708138498&message=Dear+Kariuki%2C+Your+new+password+for+MDL+App+is%3A+3245.+Thank+you.+To+opt+out+dial++%2A456%2A9%2A5%23&msgtype=5&dlr=0";
    get_web_page($myurl);
}
?>
<form method="post">
    <input type="submit" name="send" Value="Send using cURL">
</form>