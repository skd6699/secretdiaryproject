<?php
session_start();
if(array_key_exists("content",$_POST))
{   
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $database = "diary";
    $dbport = 3306;
    // Create connection
    $db = new mysqli($servername, $username, $password, $database, $dbport);

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    } 
    $dcon = mysqli_real_escape_string($db,$_POST['content']);
    $sql = "UPDATE users SET diary ='$dcon' WHERE id = ".mysqli_real_escape_string($db,$_SESSION['id'])." LIMIT 1";
}
mysqli_query($db,$sql);
 

?>