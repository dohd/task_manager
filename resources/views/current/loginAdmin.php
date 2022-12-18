<?php
//connect to the database
require("configuration.php");
//initialize session
session_start(); 

//login and operation
$error="";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
   // extract form request inputs and sanitize
   $email = mysqli_real_escape_string($db,$_POST['email']);
   $password = mysqli_real_escape_string($db,$_POST['password']);

   // encrypted password hash
   $hash = md5($password); 

   // query database
    $sql = "SELECT * FROM users WHERE email = '". $email ."' AND password = '". $hash ."' AND emp_rank = 'admin'";
    $user = mysqli_fetch_array(mysqli_query($db,$sql), MYSQLI_ASSOC);

    if (!$user) $error = "Your Login credentials are incorrect!";
    else {
        // set session variable
        $_SESSION['login_user'] = $user['email'];
        $_SESSION['emp_rank'] = $user['emp_rank'];
        header("location: addUser.php");
   }
}
?>

<!DOCTYPE html>
<html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
            body {
                background-color: #767c82;
             }
            .container {
                margin-top: 3%;
            }
            button:hover {
             opacity: 0.8;
             }
        </style>
        <title>Admin Login</title>
    </head>

<body>
    <div class="container">
        <h3>Admin Login</h3>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="row mb-4">
                <label for="inputemail" class="col-sm-1 col-form-label">Email:</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control"  name="email" required>
               </div>
            </div>
            <div class="row mb-4">
                <label for="inputPassword" class="col-sm-1 col-form-label">Password:</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" name="password" required>
                </div>
                <p class="text-danger"> <?= $error?: $error; ?> </p>
            </div>
            <a href="login.php" class="btn btn-dark col-sm-1.2" >Back</a>
            <button type="submit" class="btn btn-dark col-sm-1" name="login" style="margin-left:200px";>Sign in</button>           
            <div><a href="passwordReset.php" style="color: black; margin-left:110px;">Forgot Password?</a></div>
            </form>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>