<?php
   include('configuration.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="sidenav">
    <a href="home.php" style="color: white;">Home</a>
    <a href="addProject.php" style="margin-top: 15px;">Add Project</a>
	<a href="manageProjects.php" style="margin-top: 15px;">Manage Projects</a>
    <a href="calendar/index.php" style="margin-top: 15px;">Event Calendar</a>
    <a href="projectReport.php" style="margin-top: 15px;">Project Reports</a>
    <a href="visualization.php" style="margin-top: 15px;">Project Visualization</a>
    <a href="account.php" style="margin-top: 15px;">Account</a>
    <a href="logout.php" style="margin-top: 150px;">Logout</a>
</div>

<div class="container">
  <h1>Home</h1>
</div>

<div class="container">
<h5>Completed Projects</h5>
<table class="table table-dark table-hover ">
<tr> <th>Project Name</th> <th>Implementation Date</th> <th>Gantt</th> <th>Report</th></tr>
<?php
	$str = '';
	$sql = "SELECT * FROM project WHERE status='completed' ORDER BY implementation_date";
	$result = mysqli_query($db,$sql);
	$count = mysqli_num_rows($result);

	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
	$str .= "<tr>
	<td>".$row['name']."</td>
	<td>".$row['implementation_date']."</td>
	<td><a href='gantt.php?project_id=".$row['id']."' class='btn btn-light btn-sm'>View</a></td>
	<td><a href='addReport.php?project_id=".$row['id']."' class='btn btn-light btn-sm'>Add Report</a></td>
	</tr>";
	}
	echo $str;
?>
</table>
</div>
  
<div class="container">
<h5>Current Projects</h5>
<table class="table table-dark table-hover ">
<tr> <th>Project Name</th> <th>Implementation Date</th> <th>Gantt</th> <th>Status</th></tr>
<?php
	$str = '';
	$sql = "SELECT * FROM project WHERE status='current' ORDER BY implementation_date";
	$result = mysqli_query($db,$sql);
	$count = mysqli_num_rows($result);

	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
	$str .= "<tr>
	<td>".$row['name']."</td>
	<td>".$row['implementation_date']."</td>
	<td><a href='gantt.php?project_id=".$row['id']."' class='btn btn-light btn-sm'>View</a></td>
	<td><a href='editStatus.php?project_id=".$row['id' ]."' class='btn btn-light btn-sm'>Edit Status</a></td>
	</tr>";
	}
	echo $str;
?>

</table>
</div>

<div class="container">
<h5>Suspended Projects</h5>
<table class="table table-dark table-hover ">
<tr> <th>Project Name</th> <th>Implementation Date</th> <th>Gantt</th> <th>Status</th></tr>
<?php
	$str = '';
	$sql = "SELECT * FROM project WHERE status='suspended' ORDER BY implementation_date";
	$result = mysqli_query($db,$sql);
	$count = mysqli_num_rows($result);

	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
	$str .= "<tr>
	<td>".$row['name']."</td>
	<td>".$row['implementation_date']."</td>
	<td><a href='gantt.php?project_id=".$row['id']."' class='btn btn-light btn-sm'>View</a></td>
	<td><a href='editStatus.php?project_id=".$row['id']."' class='btn btn-light btn-sm'>Edit Status</a></td>
	</tr>";
	}
	echo $str;
?>
</table>
</div>

</body>
</html> 