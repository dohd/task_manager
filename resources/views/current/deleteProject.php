<?php
//using database connection file here
include('configuration.php'); 

//get id through query string
$id = $_GET['project_id']; 

// delete query
$deleted = mysqli_query($db, "DELETE FROM project WHERE id=".$id); 

if($deleted)
{
  //close connection
  $db->close(); 
  //redirects to manage projects page
  header("location:manageProjects.php"); 
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