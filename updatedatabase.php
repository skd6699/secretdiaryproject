<?php
session_start();
if(array_key_exists("content",$_POST))
{   
   include("connection.php");
    $dcon = mysqli_real_escape_string($db,$_POST['content']);
    $sql = "UPDATE users SET diary ='$dcon' WHERE id = ".mysqli_real_escape_string($db,$_SESSION['id'])." LIMIT 1";
}
mysqli_query($db,$sql);
 

?>