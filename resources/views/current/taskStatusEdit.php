<?php
// Using database connection file here
include('configuration.php'); 

// extract query string parameter task_id
$task_id = $_GET['task_id']; 

// construct url
$project_id = $_GET['project_id'];
$url = 'gantt.php?project_id=' . $project_id . '&task_id=' . $task_id;

// select query
$query = mysqli_query($db,"SELECT * FROM project_task WHERE id = ".$task_id); 
// fetch data
$data = mysqli_fetch_array($query); 

// handle form data on clicking update
if(isset($_POST['update'])) {
    // extract request input
    $status = $_POST['status'];
	// db insert
    $edit = mysqli_query($db,"UPDATE project_task SET status='$status' where id='$task_id'");
	// close connection and redirect to url
    if($edit) {
        $db->close();
        header("location:" . $url); 
        exit;
    } else  echo mysqli_connect_error();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<style>
body{
  background-color:#F0EFE7;
}

.container{
  margin-top:3%;
}
    
button, a:hover{
  opacity: 0.8;
}

a{
  display: inline-block;
  padding: 8px 16px;
  background-color: #212529;
}
</style>
<title>Task Status</title>
</head>
<body>
<div class="container">
<h3>Update Task Status</h3>

<form method="POST">
<div class="row mb-4">
<label for="status" class="col-sm-2 col-form-label">Project Status:</label>
<div class="col-sm-3">
<select name="status" class="form-control" >
    <?php foreach (['ongoing', 'completed'] as $value): ?>
        <option value="<?php echo $value ?>" <?php echo $value == $data['status']? 'selected' : '' ?>>
            <?php echo ucfirst($value) ?>
        </option>
    <?php endforeach; ?>
</select>
</div>
</div>
<a href="<?php echo $url ?>" class="btn btn-dark col-sm-1">Back</a>
<button type="submit" class="btn btn-dark col-sm-1" name="update">Update</button>
</form>
</div>
</body>
</html> 