<?php
//using database connection file here
include('configuration.php'); 
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Projects</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>

<body>
<div class="container">
<h1>Manage Projects</h1>

<div class="sidenav">
    <a href="home.php">Home</a>
    <a href="addProject.php" style="margin-top: 15px;">Add Project</a>
    <a href="manageProjects.php" style="color: white; margin-top: 15px;">Manage Projects</a>
    <a href="calendar/index.php" style="margin-top: 15px;">Event Calendar</a>
    <a href="projectReport.php" style="margin-top: 15px;">Project Reports</a>
    <a href="visualization.php" style="margin-top: 15px;">Project Visualization</a>
    <a href="account.php" style="margin-top: 15px;">Account</a>
    <a href="logout.php" style="margin-top: 150px;">Logout</a>
</div>

<h5>Projects</h5>

<table class="table table-dark table-hover">
<tr> <th>Project Name</th> <th>Institution</th> <th>Implementation Date</th> <th>Status</th><th></th><th></th><th></th></tr>

<?php
	$str = '';
	$sql = "SELECT * FROM project ORDER BY implementation_date";
	$result = mysqli_query($db,$sql);
	$count = mysqli_num_rows($result);

	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
	$str .= "<tr>
	<td>".$row['name']."</td>
	<td>".$row['institution']."</td>
	<td>".$row['implementation_date']."</td>
    <td>".$row['status']."</td>
	<td> <a href='editProject.php?project_id=".$row['id']."' class='btn btn-light btn-sm'>Edit Project</a> </td>
	<td> <a href='addTask.php?project_id=".$row['id']."' class='btn btn-light btn-sm'>Add tasks</a> </td>
	<td> <a href='deleteProject.php?project_id=".$row['id']."' class='btn btn-light btn-sm'>Delete</a> </td>
	</tr>";
	}
	echo $str;
?>

</table>
</div>

</body>
</html>   