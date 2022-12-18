<?php  
// Using database connection file here
include('../configuration.php'); 

$str = 'SELECT name as title, implementation_date as start, implementation_date as end FROM project';
$query = mysqli_query($db, $str); 
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) $events[] = $row;

echo json_encode($events);
