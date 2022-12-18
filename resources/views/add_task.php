<?php
    //using database connection file here
    include('configuration.php'); 

    // handle posted form data
    if (!empty($_POST['name']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        // extract request input
        $project_id = $_POST['project_id'];
        $name =  $_POST['name'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $assigned = $_POST['assigned'];

        // prepare sql statement
        $stmt = $db->prepare("INSERT INTO project_task (project_id, name, start_date, end_date, assigned) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $project_id, $name, $start_date, $end_date, $assigned);
        $result = $stmt->execute();

        // close connection and redirect to url
        if($result) {
            $db->close(); 
            header("location:" . 'addTask.php?project_id=' . $project_id);
            echo "Task added successfully";
            exit;
        } else echo "<span style='color:red'>Error while adding task</span>";
    }
?>


<!DOCTYPE html>
<html>
<head>
<title>New Task</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="container">
<h3>Add a new task</h3>

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
}
</style>
</head>

<body>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<input type="hidden" name="project_id" value="<?php echo $_GET['project_id']; ?>">
<div class="row mb-4">
    <label for="inputName" class="col-sm-2 col-form-label">Task Name:</label>
    <div class="col-sm-3">
    <input type="name" id="inputName" placeholder="Task Name" name="name" class="form-control">
    </div>
</div>
<div class="row mb-4">
    <label for="inputStartDate" class="col-sm-2 col-form-label">Start Date:</label>
    <div class="col-sm-3">
    <input type="date" id="inputStartDate" placeholder="Start Date" name="start_date" class="form-control" >
    </div>
</div>
<div class="row mb-4">
    <label for="inputEndDate" class="col-sm-2 col-form-label">End Date:</label>
    <div class="col-sm-3">
    <input type="date" id="inputEndDate" placeholder="Date" name="end_date" class="form-control" >
    </div>
</div>
<div class="row mb-4">
    <label for="assigned" class="col-sm-2 col-form-label">Assigned:</label>
    <div class="col-3">
        <select name="assigned" class="form-control">
            <option value="">-- Select User --</option>
            <?php $query = mysqli_query($db, "SELECT * FROM users") ?>
            <?php while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)): ?>
                <option value="<?php echo $row['id'] ?>">
                    <?php echo $row['first_name'] . ' ' . $row['last_name'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
</div>
    <a href="manageProjects.php" class="btn btn-secondary col-sm-1">Back</a>
    <button id="save_btn" type="save" class="btn btn-primary col-sm-1" style="margin-left: 260px;" name="save">Save</button>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<div class="container">
    <h3>Tasks</h3>
    <table class="table table-dark table-hover">
        <thead>
            <tr> 
                <th>Task</th> 
                <th>Start Date</th> 
                <th>End Date</th> 
                <th>Assigned</th> 
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $projects_query = mysqli_query($db, "SELECT * FROM project_task WHERE project_id=" . $_GET['project_id']) ?>
            <?php while ($row = mysqli_fetch_array($projects_query, MYSQLI_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['start_date'] ?></td>
                    <td><?php echo $row['end_date'] ?></td>
                    <td>
                        <?php 
                            $users_query = mysqli_query($db, "SELECT * FROM users");
                            while ($row1 = mysqli_fetch_array($users_query, MYSQLI_ASSOC)) {
                                if ($row1['id'] == $row['assigned']) {
                                    echo $row1['first_name'] . ' ' . $row1['last_name'];
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <a href="<?php echo 'editTask.php?project_id=' . $_GET['project_id'] . '&task_id=' . $row['id']; ?>" class='btn btn-light btn-sm'>Edit Task</a>
                    </td>
                    <td><a href="deleteTask.php?task_id=<?php echo $row['id'] . '&project_id=' . $_GET['project_id']; ?>" class='btn btn-light btn-sm'>Delete Task</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html> 