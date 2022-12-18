<?php
include('configuration.php');

// fetch project statuses
$query = mysqli_query($db, "SELECT status FROM project");
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) $projects [] = $row;

// count initializer for each status type
$init_status_count = [['current', 0], ['completed', 0], ['suspended', 0]];

// dynamically count and update status type
$status_type_count = array_reduce($projects, function($init, $row) {
  return array_map(function ($v) use($row) {
    if ($row['status'] == $v[0]) $v[1] += 1; 
    return $v;
  }, $init);
}, $init_status_count);

// parse status_count array to json
$status_type_count = json_encode($status_type_count);

?>

<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Visualization</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <link rel="stylesheet" href="style.css">
    <div class="sidenav">
      <a href="home.php">Home</a>
      <a href="addProject.php" style="margin-top: 15px;">Add Project</a>
      <a href="manageProjects.php" style="margin-top: 15px;">Manage Projects</a>
      <a href="calendar/index.php" style="margin-top: 15px;">Event Calendar</a>
      <a href="projectReport.php" style="margin-top: 15px;">Project Reports</a>
      <a href="visualization.php" style="color: white; margin-top: 15px;">Project Visualization</a>
      <a href="account.php" style="margin-top: 15px;">Account</a>
      <a href="logout.php" style="margin-top: 150px;">Logout</a>
    </div>
    <div class="main">
      <h1>Project Visualization</h1>
    </div>
    <div id="piechart_3d" style="width: 1045px; height: 500px;"></div>

    <div class="container">
    <a href="ratingVisualization.php" class="btn btn-dark col-sm-1">Rating</a>
    </div>
   
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // google piechart
    google.charts.load("current", {
      packages: ["corechart"]
    });
    google.charts.setOnLoadCallback(drawChart);

    // parse php variable to javascript
    let statusTypeCount = <?php echo $status_type_count ?>;

    function drawChart() {
      let data = google.visualization.arrayToDataTable([
        ['Project', 'Status'],
        // unpack array values using spread operator
        ...statusTypeCount
      ]);

      let options = {
        title: 'Project Status',
        is3D: true,
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
      chart.draw(data, options);
    }
</script>

</html>