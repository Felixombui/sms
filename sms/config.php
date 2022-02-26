<?php
$db_server = 'localhost';
$db_user = 'macrasystems';
$db_pass = 'kasarani';
$dbase = 'macrasys_smsserver';
$config = mysqli_connect( $db_server, $db_user, $db_pass, $dbase );
if ( !$config ) {
    echo 'Error! Connection Failed. Contact admin';
}
?>