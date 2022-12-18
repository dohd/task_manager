<!DOCTYPE html>
<html>
<head>
<title>Tasks</title>
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
}
</style>
</head>

<body>
<div class="container">
    <h3>Tasks</h3>
    <table class="table table-dark table-striped table-hover">
        <thead>
            <tr> 
                <th>Task</th> 
                <th>Start Date</th> 
                <th>End Date</th> 
                <th>Assigned</th> 
                <th>Status</th>
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
                    <td><?php echo $row['status'] ?></td>
                    <td>
                        <a href="<?php echo 'taskStatusEdit.php?project_id=' . $_GET['project_id'] . '&task_id=' . $row['id']; ?>">Change Status</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="container">
            <a href="home.php" class="btn btn-secondary col-sm-1">Back</a>
        </div>
</body>

</html> 