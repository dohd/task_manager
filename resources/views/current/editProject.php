<?php
// Using database connection file here
include('configuration.php'); 

// get id through query string
$id = $_GET['project_id']; 

// select query fetch data
$query = mysqli_query($db, "SELECT * FROM project WHERE id = ".$id); 
$data = mysqli_fetch_array($query); 

// when click on Update button
if(isset($_POST['update'])) 
{
    $name = $_POST['name'];
    $institution = $_POST['institution'];
    $implementation_date = $_POST['implementation_date'];
    $status = $_POST['status'];

    $stmt = $db->prepare('UPDATE project SET name = ?, institution = ?,  implementation_date = ?, status = ? WHERE id = ?');
    $stmt->bind_param('sssss', $name, $institution, $implementation_date, $status, $id);
    $result = $stmt->execute();

    if(!$result) echo "<span style='color:red'>Error while editing project</span>";
    if (!mysqli_affected_rows($db)) echo "<span style='color:red'>Something went wrong! Update failed</span>";
    else {
        // close connection and redirect
        $db->close(); 
        header("location:manageProjects.php"); 
        exit;
    } 
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
    background-color:#ffffff;
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
<div class="container">
<h3>Update Project</h3>
</body>
</html> 

<form method="POST">
<div class="row mb-4">
   <label for="inputName" class="col-sm-2 col-form-label">Project Name:</label>
   <div class="col-sm-3">
   <input type="text" class="form-control"  name="name" value="<?php echo $data['name'] ?>" placeholder="Enter Project Name">
   </div>
</div>
<div class="row mb-4">
   <label for="inputInstitution" class="col-sm-2 col-form-label">Name of Institution:</label>
   <div class="col-sm-3">
   <input type="text" class="form-control" name="institution" value="<?php echo $data['institution'] ?>" placeholder="Enter Name of Institution">
   </div>
</div>
<div class="row mb-4">
   <label for="inputImplementationDate" class="col-sm-2 col-form-label">Implementation Date:</label>
   <div class="col-sm-3">
   <input type="date" class="form-control" name="implementation_date" value="<?php echo $data['implementation_date'] ?>" placeholder="Enter Implementation Date">
   </div>
</div>
<div class="row mb-4">
<label for="status" class="col-sm-2 col-form-label">Project Status:</label>
<div class="col-sm-3">
<select name="status" class="form-control" >
    <?php foreach (['current', 'completed', 'suspended'] as $value): ?>
        <option value="<?php echo $value ?>" <?php echo $value == $data['status']? 'selected' : '' ?>>
            <?php echo ucfirst($value) ?>
        </option>
    <?php endforeach; ?>
</select>
</div>

</div>

<a href="manageProjects.php" class="btn btn-secondary col-sm-1">Back</a>
<button type="submit" class="btn btn-primary col-sm-1" style="margin-left: 260px;" name="update">Update</button>
</form>

</div>