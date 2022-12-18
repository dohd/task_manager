<?php
include('configuration.php'); 

// get id through query string
$id = $_GET['project_id'];

// select query fetch data
$query = mysqli_query($db, "SELECT * FROM project WHERE id = ".$id);  

if(isset($_POST['update']))
{
    $comments = $_POST['comments'];
    $suggestions = $_POST['suggestions'];

    $stmt = $db->prepare('UPDATE project SET comments = ?, suggestions = ? WHERE id = ?');
    $stmt->bind_param('sss', $comments, $suggestions, $id);
    $result = $stmt->execute();

    if (!$result) echo "<span style='color:red'>Error while adding report</span>";
    else {
        // close connection and redirect
        $db->close(); 
        header("location:addReport.php"); 
        exit;
    } 
}

?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                background-color: #212529;
            }
        </style>
        <title>View Report</title>
        </head>
        <body>
        <div class="container"> 
            <h3>Report</h3>
            <table class="table table-dark table-hover">
                <thead>
                    <tr> 
                        <th>Project Name</th>
                        <th>Institution</th>
                        <th>Implementation Date</th>
                        <th>Comments</th> 
                        <th>Suggestions</th> 
                        <th>Rating</th> 
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $report_query = mysqli_query($db, "SELECT * FROM project WHERE id=" . $_GET['project_id']) ?>
                    <?php while ($row = mysqli_fetch_array($report_query, MYSQLI_ASSOC)): ?>
                        <tr>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['institution'] ?></td>
                            <td><?php echo $row['implementation_date'] ?></td>
                            <td><?php echo $row['comments'] ?></td>
                            <td><?php echo $row['suggestions'] ?></td>
                            <td><?php echo $row['rating'] ?></td>
                            <td>
                                <a href="<?php echo 'editReport.php?project_id=' . $_GET['project_id']; ?>" class='btn btn-light btn-sm'>Edit Report</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="home.php" class="btn btn-secondary col-sm-1" style="margin-top: 24px;">Back</a>
        </div>
    </body>
</html>