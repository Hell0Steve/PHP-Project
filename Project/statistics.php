<?php
    require_once('includes/init.php');
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="CSS/statistics.css">

    <title>Fitness and lifestyle statistics</title>
</head>

<body>
    <?php 
        include_once 'common/_navbar.php';
    ?>

    <h1 style="text-align: center" ;>Statistics:</h1>

    <div class="chart_wrapper">

        <?php
        global $database;
        if ($results = $database->query("SELECT g.*, p.workout, p.activity, d.meals, d.diet FROM poll_general_info as g LEFT JOIN poll_physical_shape as p ON p.poll_id = g.poll_id LEFT JOIN poll_diet as d ON d.poll_id = g.poll_id")) {
            $php_data_array = Array(); // create PHP array
            echo '<table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Age</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Workout</th>
                    <th scope="col">Activity</th>
                    <th scope="col">Meals per day</th>
                    <th scope="col">Diet</th>
                </tr>
            </thead>
            <tbody>';
            
            while ($row = $results->fetch_row()) { // Filling data in the table.
                $php_data_array[] = $row;
                echo '<tr>
                    <th scope="row">'.$row[0].'</th>
                    <td>'.$row[1].'</td>
                    <td>'.$row[2].'</td>
                    <td>'.$row[3].'</td>
                    <td>'.$row[4].'</td>
                    <td>'.$row[5].'</td>
                    <td>'.$row[6].'</td>
                    <td>'.$row[7].'</td>
                </tr>';
            }

            echo "</tbody></table>";

            //Transfer PHP array to JavaScript two dimensional array 
            echo "<script>
            var my_2d = ".json_encode($php_data_array)."
            </script>";
        }
    ?>

        <div id="chart_diet"></div>
    </div>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    // Draw the pie chart when Charts is loaded.
    google.charts.setOnLoadCallback(draw_my_chart);
    // Callback that draws the pie chart
    function draw_my_chart() {
        // Create the data table .
        var data = new google.visualization.DataTable();

        data.addColumn('string', 'diet');
        data.addColumn('number', 'count');

        let omnivoreCount = 0;
        let vegetarianCount = 0;
        let veganCount = 0;

        for (i = 0; i < my_2d.length; i++) { // Counting how many from each type for the chart.
            if (my_2d[i][7] === 'omnivore') {
                omnivoreCount += 1;
            } else if (my_2d[i][7] === 'vegetarian') {
                vegetarianCount += 1;
            } else if (my_2d[i][7] === 'vegan') {
                veganCount += 1;
            }
        }

        data.addRow(['Omnivore', parseInt(omnivoreCount)]);
        data.addRow(['Vegetarian', parseInt(vegetarianCount)]);
        data.addRow(['Vegan', parseInt(veganCount)]);

        // above row adds the JavaScript two dimensional array data into required chart format
        var options = {
            is3D: true,
            legend: 'left',
            title: 'Chart by Diet',
            width: 500,
            height: 500
        };

        // Instantiate and draw the chart
        var chart = new google.visualization.PieChart(document.getElementById('chart_diet'));
        chart.draw(data, options);
    }
    </script>
</body>

</html>