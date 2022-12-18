<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function() {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var calendar = $('#calendar').fullCalendar({
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: <?php include('events.php') ?>,
                eventRender: function(event, element, view) {
                    return true;
                },
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    var title = prompt('Event Title:');
                    if (title) {
                        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                        $.ajax({
                            url: 'add_events.php',
                            data: 'title=' + title + '&start=' + start + '&end=' + end,
                            type: "POST",
                            success: function(json) {
                                alert('Added Successfully');
                            }
                        });
                        calendar.fullCalendar('renderEvent', {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay
                            },
                            true
                        );
                    }
                    calendar.fullCalendar('unselect');
                },
                editable: true,
                eventDrop: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: 'update_events.php',
                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                        type: "POST",
                        success: function(json) {
                            alert("Updated Successfully");
                        }
                    });
                },
                eventClick: function(event) {
                    var decision = confirm("Do you really want to do that?");
                    if (decision) {
                        $.ajax({
                            type: "POST",
                            url: "delete_event.php",
                            data: "&id=" + event.id,
                            success: function(json) {
                                $('#calendar').fullCalendar('removeEvents', event.id);
                                alert("Updated Successfully");
                            }
                        });
                    }
                },
                eventResize: function(event) {
                    var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
                    $.ajax({
                        url: 'update_events.php',
                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                        type: "POST",
                        success: function(json) {
                            alert("Updated Successfully");
                        }
                    });
                }
            });
        });
    </script>
    <style>
h1{
    text-align: center; 
}
   

    body {
            margin-top: 40px;
            font-size: 14px;
            
        
    font-family: "Lato", sans-serif;
    background-color:#F0EFE7;
    margin-left: 300px;
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
}

.sidenav {
  height: 100%;
  width: 300px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

.sidenav a {
  padding: 6px 6px 6px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
}

.sidenav a:hover {
  color: #f1f1f1;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
        

        #calendar {
            width: 650px;
            margin: 0 auto;
            background-color:white;
        }
    </style>
</head>

<body>
    <h1> Event Calendar </h1>
    <br />
    <div id='calendar'></div>

<div class="sidenav">
    <a href="..\home.php">Home</a>
    <a href="..\addProject.php" style="margin-top: 15px;">Add Project</a>
    <a href="..\manageProjects.php" style="margin-top: 15px;">Manage Projects</a>
    <a href="index.php" style="color: white; margin-top: 15px;">Event Calendar</a>
    <a href="..\projectReport.php" style="margin-top: 15px;">Project Reports</a>
    <a href="..\visualization.php" style="margin-top: 15px;">Project Visualization</a>
    <a href="..\account.php" style="margin-top: 15px;">Account</a>
    <a href="logout.php" style="margin-top: 150px;">Logout</a>
</div>
</body>

</html>