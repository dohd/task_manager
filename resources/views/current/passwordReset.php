<?php
//Connect to the database
require("configuration.php");

//Session to manage
session_start(); 

$error="";

if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
    //Email sent from form using POST method
    $myemail = mysqli_real_escape_string($db,$_POST['email']);
    $newPassword=md5($_POST['newPassword']);  
    $confirmPassword=md5($_POST['confirmPassword']); 
    
    $sql = "SELECT * FROM users WHERE email = '".$myemail."'";
    $result = mysqli_query($db,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    
    //Validating email
    if (empty ($_POST['email'])){
        $error = "You have to enter your email address";
    }
    else if ($count != 1) 
    {   
        $error = "Your Email is incorrect";
    }

    //Reset Password 
    else if (empty ($_POST['newPassword'])){
        $error = "The New Password field can't be empty";
    }
    else if (empty ($_POST['confirmPassword'])){
        $error = "The Confirm Password field can't be empty";
    }
    else if ($newPassword != $confirmPassword) {
        $error = "The two passwords don't match.";
    } else {
        $sql = "UPDATE users SET password = '$newPassword' WHERE email = '".$myemail."' LIMIT 1";
        $query = mysqli_query($db, $sql);
        echo "Your password has been reset successfully!";
    }
    
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<div class="container">
<h3>Reset Password</h3>

<style>
    body{background-color:#767c82;}
    .container{margin-top:3%;}
    button:hover {opacity: 0.8;}
   
</style>
</head>

<body>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

<div class="row mb-4">
    <label for="inputemail" class="col-sm-3 col-form-label">Email:</label>
    <div class="col-sm-3">
    <input type="email" class="form-control"  name="email">
    </div>
</div>
<div class="row mb-4">
    <label for="newPassword" class="col-sm-3 col-form-label">Enter New Password:</label>
    <div class="col-sm-3">
    <input type="password" class="form-control" name="newPassword">
    </div>
</div>
<div class="row mb-4">
    <label for="confirmPassword" class="col-sm-3 col-form-label">Confirm New Password:</label>
    <div class="col-sm-3">
    <input type="password" class="form-control" name="confirmPassword">
    </div>

    <div class=""> 
        <?= $error?: $error; ?>
    </div>
</div>

<a href="login.php" class="btn btn-dark col-sm-1">Back</a>
<button type="submit" class="btn btn-dark col-sm-1" name="submit" style="margin-left:190px";>Submit</button>

</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>