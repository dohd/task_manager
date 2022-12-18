<?php
// Using database connection file here
include('configuration.php'); 

// Get id through query string
$id = $_GET['id']; 
// Delete query
$deleted = mysqli_query($db, "DELETE FROM users WHERE id=".$id); 

if($deleted)
{
    // Close database connection
    $db->close(); 
    // Redirects to users page
    header("location:addUser.php"); 
    echo "User deleted successfully";
    exit;
} 
else 
{
    echo "Error deleting record: " . $db->error;
    echo mysqli_connect_error();
}

$db->close();
?>