<?php
    //using database connection file here
    include('configuration.php'); 

    $task_values = array();

    if (isset($_GET['project_id'])) {
        // project tasks
        $query = mysqli_query($db, "SELECT * FROM project_task WHERE project_id=" . $_GET['project_id']);
        while ($row = mysqli_fetch_array($query)) $project_tasks[] = $row;

        // map project tasks to return column values
        $task_values = array_map(function ($v) {
            $row = array_intersect_key($v, array_flip([
                'id', 'name', 'start_date', 'end_date', 'assigned'
            ]));
            return array_values($row);
        }, $project_tasks);
    }
?>

<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
            body{
                background-color:#767c82;
            }

            .container{
                margin-top:3%;
            }
                
            button, a:hover{
                opacity: 0.8;
            }
        </style>
        <title>Gantt Chart</title>
    </head>
    <body>
        <div class="container">
            <div id="chart" style="border: 1px solid #ccc"></div>
        </div>
        <?php include('taskStatus.php'); ?>
    </body>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        // parse php variable
        let taskValues = <?php echo json_encode($task_values) ?>;

        // google ganttchart
        google.charts.load('current', {'packages':['gantt']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Task ID');
            data.addColumn('string', 'Task Name');
            data.addColumn('string', 'Resource');
            data.addColumn('date', 'Start Date');
            data.addColumn('date', 'End Date');
            data.addColumn('number', 'Duration');
            data.addColumn('number', '% Complete');
            data.addColumn('string', 'Dependencies');

            if (!taskValues) return; 
            // map task values to match chart column atrributes
            taskValues = taskValues.map(v => {
                let a = [...v];
                // resource (same as task name)
                a[2] = v[1];
                // start date
                a[3] = new Date(v[2]); 
                // end date
                a[4] = new Date(v[3]);
                // duration
                a[5] = Number(a[4]);
                // complete percentage
                a[6] = 0;
                // dependencies (required and must be null)
                a[7] = null;
                return a;
            });

            data.addRows(taskValues);

            var options = {
                height: 400,
                gantt: {
                    trackHeight: 30
                }
            }

            var chart = new google.visualization.Gantt(document.getElementById('chart'));
            chart.draw(data, options);
        }
    </script>
</html>