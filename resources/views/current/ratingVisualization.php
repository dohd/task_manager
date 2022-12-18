<?php
include('configuration.php');

// fetch project ratings
$query = mysqli_query($db, "SELECT rating FROM project WHERE status = 'completed'");
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) $projects [] = $row;

// count initializer for each rating type
$init_rating_count = [['low', 0], ['medium', 0], ['high', 0], ['excellent', 0]];

// dynamically count and update rating type
$rating_type_count = array_reduce($projects, function($init, $row) {
  return array_map(function ($v) use($row) {
    if ($row['rating'] == $v[0]) $v[1] += 1; 
    return $v;
  }, $init);
}, $init_rating_count);

// parse rating_count array to json
$rating_type_count = json_encode($rating_type_count);

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
    <a href="visualization.php" class="btn btn-dark col-sm-1">Status</a>
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
    let ratingTypeCount = <?php echo $rating_type_count ?>;

    function drawChart() {
      let data = google.visualization.arrayToDataTable([
        ['Project', 'Rating'],
        // unpack array values using spread operator
        ...ratingTypeCount
      ]);

      let options = {
        title: 'Ratings of Completed Projects',
        is3D: true,
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
      chart.draw(data, options);
    }
</script>

</html>