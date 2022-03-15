<?php
    $connect = mysqli_connect("localhost","root","","wms");
    $query = "SELECT s_status, count(*) as number FROM slot GROUP BY s_status";
    $result = mysqli_query($connect,$query);
?>
<!DOCTYPE html>
<html> 
    <head>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
        <script type="text/javascript">  
        google.charts.load('current', {'packages':['corechart']});  
        google.charts.setOnLoadCallback(drawChart);
        function drawChart(){
            var data = google.visualization.arraryToDataTable([
                ['Status','Number'],
                <?php
                    if(mysqli_num_rows($query) > 0 ){
                        while($row = mysqli_fetch_arrary($result)){
                            echo "['".$row["s_status"]."',".$row["number"]."]";
                        }
                    }                
                ?>
            ]);

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data,options);
        }
        </script>
    </head>
    <body>
        <div id="donutchart" style="width: 900px; height: 500px;">

        </div>
    </body>
</html>