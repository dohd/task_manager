<?php
   include('configuration.php');

   //Session to manage
   session_start();

   //Ensure the user is logged in
   if (empty($_SESSION['login_user'])) header("location:login.php");
   $user_check = $_SESSION['login_user'];
   $ses_sql = mysqli_query($db,"select email from users where email = '$user_check' ");
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   $login_session = $row['email'];
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
   }
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="sidenav">
    <a href="home.php">Home</a>
    <a href="addProject.php" style="margin-top: 15px;">Add Project</a>
    <a href="manageProjects.php" style="margin-top: 15px;">Manage Projects</a>
    <a href="calendar/index.php" style="margin-top: 15px;">Event Calendar</a>
    <a href="projectReport.php" style="margin-top: 15px;">Project Reports</a>
    <a href="visualization.php" style="margin-top: 15px;">Project Visualization</a>
    <a href="account.php" style="color: white; margin-top: 15px;">Account</a>
    <a href="logout.php" style="margin-top: 150px;">Logout</a>
</div>

<div class="container">

<div class="main">
  <h1>Account</h1>
</div>

<table class="table table-dark table-hover ">
<tr> <th>Name</th> <th>Email</th> <th>Rank</th></tr>

<?php
	$str = '';
	$sql = "SELECT CONCAT(first_name, ' ',last_name) as name,  email, emp_rank from users where email = '".$_SESSION['login_user']."'";
	$result = mysqli_query($db,$sql);
	$count = mysqli_num_rows($result);

	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
	$str .= "<tr>
	<td>".$row['name']."</td>
	<td>".$row['email']."</td>
    <td>".$row['emp_rank']."</td>
	</tr>";
	}
	echo $str;
?>
</table>

<?php 
    if(isset($_POST['save'])){
    $currentPassword=md5($_POST['currentPassword']); 
    $newPassword=md5($_POST['newPassword']);  
    $confirmPassword=md5($_POST['confirmPassword']); 

    $sql="SELECT id from users WHERE password='$currentPassword' && email='".$_SESSION['login_user']."'";
    $res = mysqli_query($db,$sql);
    $row = mysqli_fetch_assoc($res);
    $count = mysqli_num_rows($res);

    if (empty ($_POST['currentPassword'])){
            echo "The Current Password field can't be empty";
        }
        else if ($count != 1) {
            echo "The Current Password is incorrect";
        }
        else if ( empty ($_POST['newPassword'])){
            echo "The New Password field can't be empty";
        }
        else if (empty ($_POST['confirmPassword'])){
            echo "The Confirm Password field can't be empty";
        }
        else if ($newPassword != $confirmPassword) {
            echo "The two passwords don't match.";
        } else {
            $sql = "UPDATE users SET password = '$newPassword' WHERE email='".$_SESSION['login_user']."' LIMIT 1";
            $query = mysqli_query($db, $sql);
            echo "Your password has been changed successfully!";
        }

    }
 
?> 

<h3>Change Password</h3>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

<div class="row mb-4">
   <label for="inputPassword" class="col-sm-2 col-form-label">Current Password:</label>
   <div class="col-sm-3">
   <input type="password" class="form-control" name="currentPassword">
    </div>
</div>
<div class="row mb-4">
   <label for="inputPassword" class="col-sm-2 col-form-label">New Password:</label>
   <div class="col-sm-3">
   <input type="password" class="form-control" name="newPassword">
   </div>
</div>
<div class="row mb-">
   <label for="inputPassword" class="col-sm-2 col-form-label">Confirm Password:</label>
   <div class="col-sm-3">
   <input type="password" class="form-control" name="confirmPassword">
   </div>
</div>
<button id="save_btn" type="save" class="btn btn-primary col-sm-1" style="margin-top: 20px; margin-left: 330px;" name="save">Save</button>
</form>
</div> 

</div>

</body>
</html>