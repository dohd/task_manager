<?php
//using database connection file here
include('configuration.php'); 
    
    //save form data
    if (!empty($_POST['name']))
    {
        $name =  $_POST['name'];
        $institution =  $_POST['institution'];
        $implementation_date = $_POST['implementation_date'];
        
        
    $stmt = $db->prepare("INSERT INTO project (name, institution, implementation_date, comments, suggestions) VALUES (?, ?, ?, 'none', 'none')");
    $stmt->bind_param("sss", $name, $inst, $impdate);

    //set parameters and execute
    $name = $name;
    $inst = $institution;
    $impdate = $implementation_date;
  
    if(!$stmt->execute()) 
        echo "<span style='color:white'>Error while adding project</span>";
    else{
        $stmt->close();
        // Close connection
        $db->close(); 
    
        echo "Project added successfully";
        // redirects to home page
        header("location:addProject.php"); 

    exit;
    } 
    }
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Project</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<div class="container">

</head>

<body>
<h1>Add Project</h1>

<div class="sidenav">
    <a href="home.php">Home</a>
    <a href="addProject.php" style="color: white;  margin-top: 15px;">Add Project</a>
    <a href="manageProjects.php" style="margin-top: 15px;">Manage Projects</a>
    <a href="calendar/index.php" style="margin-top: 15px;">Event Calendar</a>
    <a href="projectReport.php" style="margin-top: 15px;">Project Reports</a>
    <a href="visualization.php" style="margin-top: 15px;">Project Visualization</a>
    <a href="account.php" style="margin-top: 15px;">Account</a>
    <a href="logout.php" style="margin-top: 150px;">Logout</a>
</div>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

<div class="row mb-4">
    <label for="inputName" class="col-sm-3 col-form-label">Project Name:</label>
    <div class="col-sm-3">
    <input type="name" id="inputName" placeholder="Project Name" name="name" class="form-control">
    </div>
</div>
<div class="row mb-4">
    <label for="inputInstitution" class="col-sm-3 col-form-label">Name of Institution:</label>
    <div class="col-sm-3">
    <input type="institution" id="inputInstitution" placeholder="Name of Institution" name="institution" class="form-control">
    </div>
</div>
<div class="row mb-4">
    <label for="inputImplementationDate" class="col-sm-3 col-form-label">Implementation Date:</label>
    <div class="col-sm-3">
    <input type="date" id="inputImplementationDate" placeholder="Implementation Date" name="implementation_date" class="form-control" >
    </div>
</div>
    <button id="save_btn" type="save" class="btn btn-primary col-sm-1" name="save">Save</button>
</form>

<table class="table table-dark table-hover mt-5" >
<tr> <th>Project Name</th> <th>Institution</th> <th>Implementation Date</th></tr>
<?php
	$str = '';
	$sql = "SELECT * FROM project WHERE status='current' ORDER BY implementation_date";
	$result = mysqli_query($db,$sql);
	$count = mysqli_num_rows($result);

	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
	$str .= "<tr>
	<td>".$row['name']."</td>
	<td>".$row['institution']."</td>
    <td>".$row['implementation_date']."</td>
	</tr>";
	}
	echo $str;
?>
</table>

</div>
</body>
</html> 