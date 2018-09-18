<?php

session_start();
$diaryContent = "";
if(array_key_exists("id",$_COOKIE) && $_COOKIE['id']){
    
    $_SESSION['id'] = $_COOKIE['id'];
    
}
if(array_key_exists("id",$_SESSION) && $_SESSION['id']){
    

    //echo "<p> Logged In! <a href='index.php?logout=1'>Log out</a>";
    include("connection.php");
    $sql = "SELECT diary from users WHERE id = ".mysqli_real_escape_string($db,$_SESSION['id'])." LIMIT 1";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result);
    $diaryContent  = $row['diary'];
}
else{
    header("Location: index.php");
}

?>
<?php include("header.php"); ?> 
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Secret Diary</a>
    <ul class="navbar-nav float-right">
      <li class="nav-item active float-right">
        <a class="nav-link " href="index.php?logout=1">Logout <span class="sr-only">(current)</span></a>
      </li>
      </ul>
      
</nav>
<div class="container-fluid" id="loggedincontainer">
    <textarea id="diary" class="form-control" rows="15"><?php echo $diaryContent; ?></textarea>
</div>

<?php include("footer.php"); ?>