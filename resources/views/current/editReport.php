<?php
// Using database connection file here
include('configuration.php'); 

// get id through query string
$id = $_GET['project_id']; 
$url = 'addReport.php?project_id=' . $id;

// select query fetch data
$query = mysqli_query($db, "SELECT * FROM project WHERE id = ".$id); 
$data = mysqli_fetch_array($query); 

// when click on Update button
if(isset($_POST['update'])) 
{
    $comments = $_POST['comments'];
    $suggestions = $_POST['suggestions'];
    $rating = $_POST['rating'];

    $stmt = $db->prepare('UPDATE project SET comments = ?, suggestions = ?,  rating = ? WHERE id = ?');
    $stmt->bind_param('ssss', $comments, $suggestions, $rating, $id);
    $result = $stmt->execute();

    if(!$result) echo "<span style='color:red'>Error while editing report</span>";
    if (!mysqli_affected_rows($db)) echo "<span style='color:red'>Something went wrong! Update failed</span>";
    else {
        // close connection and redirect
        $db->close(); 
        header("location:" . $url);  
        exit;
    } 
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Update Report</title>
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
<h3>Update Report</h3>
</body>
</html> 

<form method="POST">
<div class="row mb-4">
   <label for="inputComments" class="col-sm-2 col-form-label">Comments:</label>
   <div class="col-sm-3">
   <input type="text" class="form-control"  name="comments" value="<?php echo $data['comments'] ?>" placeholder="Enter Comments">
   </div>
</div>
<div class="row mb-4">
   <label for="inputSuggestions" class="col-sm-2 col-form-label">Suggestions:</label>
   <div class="col-sm-3">
   <input type="text" class="form-control" name="suggestions" value="<?php echo $data['suggestions'] ?>" placeholder="Suggestions">
   </div>
</div>
<div class="row mb-4">
<label for="rating" class="col-sm-2 col-form-label">Rating:</label>
<div class="col-sm-3">
<select name="rating" class="form-control" >
    <?php foreach (['low', 'medium', 'high','excellent'] as $value): ?>
        <option value="<?php echo $value ?>" <?php echo $value == $data['rating']? 'selected' : '' ?>>
            <?php echo ucfirst($value) ?>
        </option>
    <?php endforeach; ?>
</select>
</div>

</div>

<a href="<?php echo 'addReport.php?project_id=' . $_GET['project_id'] ; ?>" class="btn btn-secondary col-sm-1">Back</a>
<button type="submit" class="btn btn-primary col-sm-1" style="margin-left: 260px;" name="update">Update</button>
</form>

</div>