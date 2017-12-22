<?php


$server = '*******';
$user = '********';
$password = '*********';
$db='*********';

//Attempt to connect.
$connection = mysqli_connect($server, $user, $password, $db);

//Check if we are connected.
if(!$connection ){
    die("conn failed: ".mysqli_connect_error());
}/* else{
    echo 'We are connected!';
}*/
 


?>