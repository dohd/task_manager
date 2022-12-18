<?php
// Using database connection file here
include('configuration.php'); 

// extract query string parameter task_id
$task_id = $_GET['task_id']; 

// construct url
$project_id = $_GET['project_id'];
$url = 'addTask.php?project_id=' . $project_id . '&task_id=' . $task_id;

// select query
$query = mysqli_query($db,"SELECT * FROM project_task WHERE id = ".$task_id); 
// fetch data
$data = mysqli_fetch_array($query); 

// handle form data on clicking update
if(isset($_POST['update'])) {
    // extract request input
    $name = $_POST['name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $assigned = $_POST['assigned'];
	// db insert
    $edit = mysqli_query($db,"UPDATE project_task SET name='$name', start_date='$start_date', end_date='$end_date', assigned='$assigned' where id='$task_id'");
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
<div class="container">
<h3>Update Task</h3>

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

</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>
</html> 

<form method="POST">
<div class="row mb-4">
   <label for="inputName" class="col-sm-2 col-form-label">Task:</label>
   <div class="col-sm-3">
   <input type="text" class="form-control"  name="name" value="<?php echo $data['name'] ?>" placeholder="Task">
   </div>
</div>
<div class="row mb-4">
   <label for="inputStartDate" class="col-sm-2 col-form-label">Start Date:</label>
   <div class="col-sm-3">
   <input type="date" class="form-control" name="start_date" value="<?php echo $data['start_date'] ?>" placeholder="Start Date">
   </div>
</div>
<div class="row mb-4">
   <label for="inputEndDate" class="col-sm-2 col-form-label">End Date:</label>
   <div class="col-sm-3">
   <input type="date" class="form-control" name="end_date" value="<?php echo $data['end_date'] ?>" placeholder="End Date">
   </div>
</div>
<div class="row mb-4">
    <label for="assigned" class="col-sm-2 col-form-label">Assigned:</label>
    <div class="col-3">
        <select name="assigned" class="form-control">
            <option value="">-- Select User --</option>
            <?php 
                $query = mysqli_query($db, "SELECT * FROM users"); 
                while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) $users[] = $row;
            ?>
            <?php foreach ($users as $row): ?>
                <option value="<?php echo $row['id'] ?>" <?php if ($row['id'] == $data['assigned']) echo 'selected'; ?>>
                    <?php echo $row['first_name'] . ' ' . $row['last_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<a href="<?php echo 'addTask.php?project_id=' . $_GET['project_id'] . '&task_id=' . $row['id']; ?>" class="btn btn-secondary col-sm-1">Back</a>
<button type="submit" class="btn btn-primary col-sm-1" style="margin-left: 260px;" name="update">Update</button>
</form>

</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
