<?php
//using database connection file here
include('configuration.php'); 

//get id through query string
$id = $_GET['task_id']; 

// construct url
$project_id = $_GET['project_id'];
$url = 'addTask.php?project_id=' . $project_id;

// delete query
$deleted = mysqli_query($db, "DELETE FROM project_task WHERE id=".$id); 

if($deleted)
{
  //close connection
  $db->close(); 
  //redirects to projects page
  header("location:" . $url); 
  echo "Deletion done successfully";
  exit;
} 
else 
{
  echo "Error while deleting record: " . $db->error;
  echo mysqli_connect_error();
}

$db->close();
?>