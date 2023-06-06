
<?php
 
 require_once "config.php";

 $username=$password=$confirm_password="";
 $username_err=$password_err=$confirm_password_err="";




 if($_SERVER["REQUEST_METHOD"]=="POST"){
     if(empty(trim($_POST["username"])))
         $username_err= "hey you enter a valid username";
     else{
      $sql="SELECT id from users where username=?";
     
    if($stmt=mysqli_prepare($link,$sql)){
        $param_username="";


        mysqli_stmt_bind_param($stmt,"s",$param_username);
        $param_username=trim($_POST["username"]);  



        if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt)==1){
              $username_err="this username already taken";
          }
          else
              $username=trim($_POST["username"]);
        }
        else{
          echo "Oops try again later...Some issues !!!";
        }

        mysqli_stmt_close($stmt);
    }
 }



if(empty(trim($_POST["password"])))
     $password_err="Please enter a password";
else if(strlen(trim($_POST["password"])<6))
    $password_err="password must be atleast 6 characters";
else
    {
      $password=$_POST["password"];
    }

if(empty(trim($_POST["confirm_password"])))
     $confirm_password_err="please confirm your password";
else {
  $confirm_password=trim($_POST["confirm_password"]);
  if(empty($password_err) && ($password != $confirm_password)){
       $confirm_password_err="password does not match";
  }
}
if(empty($password_err) && empty($confirm_password_err) && empty($username_err)){
     $sql="INSERT INTO users(username,password) VALUES(?,?)";

     if($stmt=mysqli_prepare($link,$sql)){
         mysqli_stmt_bind_param($stmt,"ss",$param_username,$param_password);
         $param_username=$username;
         $param_password=password_hash($password, PASSWORD_DEFAULT);
         if(mysqli_stmt_execute($stmt)){
             header("login.html");

         }
         else
              echo "Something went wrong ya";


        mysqli_stmt_close($stmt);
     }
    
}
mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">
  <link href="css/register.css" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>

</head>
<body>
   

    <div class="wrapper">
        <h2 style="color:white">Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label><b>Username</b></label>
                <input type="text" name="username" >
                
            </div>    
            <div class="form-group">
                <label><b>Password</b></label>
                <input type="password" name="password" >
               
            </div>
            <div class="form-group">
                <label><b>Confirm Password</b></label>
                <input type="password" name="confirm_password">
               
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </div>
            <p style="font-size: 16px; ">Already have an account? <a href="login.html" style="color:brown;">Login here</a></p>
        </form>
    </div>    
</body>
</html>















