<?php
include 'config.php';
$names=$_GET['names'];
$phonenumber=$_GET['phonenumber'];
$owner=$_GET['owner'];
//check if contact exists
$chkqry=mysqli_query($config,"SELECT * FROM contacts WHERE names='$names' AND phonenumber='$phonenumber' AND `owner`='$owner' ");
if(mysqli_num_rows($chkqry)>0){
    echo 'Status: Duplicate found<br>';
}else{
    $entrydate=date('Y-m-d');
    mysqli_query($config,"INSERT INTO contacts (names,phonenumber,`owner`,entrydate) VALUES('$names','$phonenumber','$owner','$entrydate')");
    echo 'Status: Success<br>';
}
?>