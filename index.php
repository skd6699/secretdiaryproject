<?php
session_start();
$error = "";
if(array_key_exists("logout",$_GET)){
    unset($_SESSION);
    setcookie("id","",time() - 60*60);
    $_COOKIE['id'] = "";
}
elseif(($_SESSION['id'] AND array_key_exists("id",$_SESSION)) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE['id'])){
    header("Location: loggedinpage.php");
}
if(array_key_exists("submit",$_POST)){
   include("connection.php");
    // echo "Connected successfully (".$db->host_info.")";
   
   
    
     if(!$_POST['email'])
    {
        $error .=" An email is required.<br> ";
    }
    if(!$_POST['password'])
    {
        $error .=" A password is required.<br> ";
    }
     $email = mysqli_real_escape_string($db,$_POST['email']);
     $password =mysqli_real_escape_string($db,$_POST['password']);
     
    if($error != ""){
        
    }else{
       if($_POST['signup'] == 1)
       {
        $sql = "SELECT id FROM users WHERE email = '$email' LIMIT 1";
        //echo $sql;
        $result = mysqli_query($db,$sql);
        //echo  mysqli_num_rows();
        if(mysqli_num_rows($result) > 0){
            $error = " Email Already Taken.<br> ";
            
        }
        else{
            $sql = "INSERT INTO users (email,password) VALUES ('$email','$password')";
           // echo $sql;
          if (mysqli_query($db, $sql)) {
              $hash = md5(md5(mysqli_insert_id($db)).$password);
             // echo $hash;
              $sql = "UPDATE users SET password = '$hash' WHERE id = ".mysqli_insert_id($db)." LIMIT 1" ;
              //echo $sql;
              mysqli_query($db,$sql);
              $_SESSION['id'] = mysqli_insert_id($db);
              if($_POST['stayloggedin'] == 1){
                  setcookie("id",mysqli_insert_id($db),time() + 60*60*24);
              }
    header("Location: loggedinpage.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
}
            
        }
    }
    else{
        $sql = "SELECT * FROM users WHERE email = '$email'";
        //echo $sql;
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result);
        //print_r($row);
        //echo $password;
        if(isset($row)){
            $hash = md5(md5($row['id']).$password);
          //  echo $hash;
            if(($row['password'] == $hash)) {
                $_SESSION['id'] = $row['id'];
                if($_POST['stayloggedin'] == 1){
                  setcookie("id",$row['id'],time() + 60*60*24);
              }
              
              header("Location: loggedinpage.php");
            } else {
                $error = "Invalid Password";
            }
        
        }
        else{
            $error = "Email/Password is incorrect.";
        }
    }
}
}

?>
<?php include("header.php"); ?>
        <div class="container" id="homePageCont">
            <h1>Secret Diary</h1>
            <h5>Write down your thoughts!</h5>
                <div id="error">
            <?php if($error!=""){
                echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
            } 
            
            
            ?>
        </div>
        <form method="POST" id="signupform">
           <div class="form-group">
            <input class="form-control" type="email" name="email" placeholder="example@example.com"/>
            </div>
            <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password"/>
            </div>
            <div class="form-check form-group">
            <input type="checkbox" name="stayloggedin" value="1"  id="loggedin1" class="form-check-input" />
             <label for="loggedin1" class="form-check-label">Stay Logged In</label>
            <input type="hidden" name="signup" value="1"  />
            </div>
            <div class="form-group">
            <input type="submit" name="submit" value="Sign Up" class="btn btn-success"/>
            </div>
        <p>Already have an Account?<a class="toggleforms">Log in</a><p>
        </form>
        
        <form method="POST" id="loginform">
           <div class="form-group">
            <input type="email" name="email" placeholder="example@example.com" class="form-control" />
            </div>
            <div class="form-group">
            <input type="password" name="password" placeholder="Password" class="form-control" />
            </div>
            <div class="form-group form-check">
            <input type="checkbox" name="stayloggedin" value="1"  id="loggedin" class="form-check-input" />
             <label for="loggedin" class="form-check-label">Stay Logged In</label>
            <input type="hidden" name="signup" value="0"  />
            </div>
            <div class="form-group">
            <input type="submit" name="submit" value="Login" class="btn btn-success" />
            </div>
            <p>Wanna Register?<a class="toggleforms">Sign Up</a><p>
        </form>
        
    </div>
          
       
 <?php  include("footer.php"); ?>
