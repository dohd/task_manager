<?php
//Using database connection file here
include('configuration.php');

//Save form data
if (!empty($_POST['first_name']))
   {
      $first_name =  $_POST['first_name'];
      $last_name =  $_POST['last_name'];
      $email = $_POST['email'];
      $emp_rank = $_POST['emp_rank'];
      $password = $_POST['password'];

      $stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, emp_rank, password) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sssss", $fname, $lname, $email, $erank, $pass);

      //Set parameters and execute
      $fname = $first_name;
      $lname = $last_name;
      $email = $email;
      $erank = $emp_rank;
      $pass = MD5($password);
	
	   if(!$stmt->execute())
      echo "<span style='color:red'>Error while adding new user</span>";
      else 
      $stmt->close();
      $db->close();
       
      echo "User added successfully";
      header("location:addUser.php");
      exit;
   }
?>

<!DOCTYPE html>
<html>
<head>
<title>Add User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>
   body{background-color:#F0EFE7;}
   .container{margin-top:3%;}
</style>
</head>
<body>

<div class="container">
<div class="main">
  <h1>Add New User</h1>
</div>
<div>
<a href="home.php" class="btn btn-dark col-sm-2" style="margin-left: 920px;">Home</a>
</div>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
      
<div class="row mb-4">
   <label for="inputFirstName" class="col-sm-3 col-form-label">First Name:</label>
   <div class="col-sm-3">
   <input type="first_name" id="inputFirstName" name="first_name" class="form-control">
   </div>
</div>
<div class="row mb-4">
   <label for="inputLastName" class="col-sm-3 col-form-label">Last Name:</label>
   <div class="col-sm-3">
   <input type="last_name" id="inputLastName" name="last_name" class="form-control" >
   </div>
</div>
<div class="row mb-4">
   <label for="inputEmail" class="col-sm-3 col-form-label">Email:</label>
   <div class="col-sm-3">
   <input type="email" id="inputEmail" name="email" class="form-control" >
   </div>
</div>
<div class="row mb-4">
   <label for="emp_rank" class="col-sm-3 col-form-label">Rank:</label>
   <div class="col-sm-3">
   <select name="emp_rank" class="form-control" >
      <option value="">-- Select Rank --</option>
      <?php
         // Rank array
         $position = array("admin", "project manager", "user");
         
         // Iterating through the rank array
         foreach($position as $rank){
               echo '<option value="' . strtolower($rank) . '">' . $rank . '</option>';
         }
         ?>
   </select>
   </div>
</div>
<div class="row mb-4">
   <label for="inputPassword" class="col-sm-3 col-form-label">Password:</label>
   <div class="col-sm-3">
   <input type="password" id="inputPassword" name="password" class="form-control" >
   </div>
</div>

	<button type="submit" class="btn btn-dark col-sm-1" name="submit">Add</button>

</form>

<div class="container">
<h5>Users</h5>

<table class="table table-dark table-hover ">
<tr> <th>Name</th> <th>Email</th> <th>Rank</th><th> </th></tr>

<?php
	$str = '';
	$sql = "SELECT id, CONCAT(first_name, ' ',last_name) as name,  email, emp_rank from users ORDER BY name";
	$result = mysqli_query($db,$sql);
	$count = mysqli_num_rows($result);

	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
	$str .= "<tr>
	<td>".$row['name']."</td>
	<td>".$row['email']."</td>
   <td>".$row['emp_rank']."</td>
   <td>
	<a href='deleteUser.php?id=".$row['id']."' class='btn btn-light btn-sm'>Delete</a>
	</td>
	</tr>";
	}
	echo $str;
?>
</table>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html>