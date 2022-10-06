<?php
include 'connection.php';

if(!isset($_SESSION['id']))
{
    header("location:index.php");
}
?>


<?php
    include_once('esp-database.php');

    $result = getAllOutputs();
    $html_buttons = null;
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            if($row["type"]==0)
            {
            if ($row["state"] == "1"){
                $button_checked = "checked";
            }
            else {
                $button_checked = "";
            }
            
            $html_buttons .='<h3>' .'<span style="color: Red;">'. $row["name"] ."</span>". ' - Board '. $row["board"] . ' - GPIO ' . $row["gpio"] . ' (<i><a onclick="deleteOutput(this)" href="javascript:void(0);" id="' . $row["id"] . '">Delete</a></i>)</h3><label class="switch"><input type="checkbox" onchange="updateOutput(this)" id="' . $row["id"] . '" ' . $button_checked . '><span class="slider"></span></label>';
            }
        }
    }

    $result2 = getAllBoards();
    $html_boards = null;
    if ($result2) {
        $html_boards .= '';
        while ($row = $result2->fetch_assoc()) {
            $row_reading_time = $row["last_request"];
            // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
            //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));

            // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
            //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 7 hours"));
            $html_boards .= '<p style=" font-size: 25px;"><strong>Board ' . $row["board"] . '</strong> - Last Request Time:<span style="color:green;"><strong> '. $row_reading_time . '</strong></span></p>'.'<br>';
        }
    }
?>

<!DOCTYPE HTML>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="refresh" content="15">
        
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="esp-style.css">
<title>Output Control</title>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart']
        });
    </script>
</head>
<body>
<?php
include 'Navbar.php';
?>
<div class="container-fluid" style="width: 100%;">

    <div>
    <h1 class="text-center text-Dark pb-3 pt-3 ml-0">Butt<i class="fa fa-bomb" aria-hidden="true"></i>ns</h1>
    <hr style="width: 70%; border-width: 3px;">
            <div class="text-center bg-white">
                <?php echo $html_buttons; ?>
            </div>
    </div>
<!--
    <br>

    <div>
    <h1 class="text-center text-Dark pb-3 pt-3 ml-0">Readings <i class="fa fa-line-chart" aria-hidden="true"></i></h1>
    <hr style="width: 70%; border-width: 3px;">
    <div class="text-center">
    
    </div>

    <div id="container" style="width: 550px; height: 400px; margin: 0 auto"></div>
    <script language="JavaScript">
        function drawChart() {
            /* Define the chart to be drawn.*/
            var data = google.visualization.arrayToDataTable([
                ['Page Vist', 'Students Tutorial'],
                ['2012', 10000],
                ['2013', 23000],
                ['2014', 46000],
                ['2015', 49000],
                ['2016', 55000],
                ['2017', 100000]
            ]);
            var options = {
                title: 'Page visit per year',
                isStacked: true
            };
            /* Instantiate and draw the chart.*/
            var chart = new google.visualization.BarChart(document.getElementById('container'));
            chart.draw(data, options);
        }
        google.charts.setOnLoadCallback(drawChart);
    </script>
-->
    </div>

    <br>

    <div>
    <h1 class="text-center text-Dark pb-3 pt-3 ml-0">Sliders <i class="fa fa-cogs" aria-hidden="true"></i></h1>
    <hr style="width: 70%; border-width: 3px;">
    <div class="text-center">
    <div class="form-group">
        <input type="text" class="text-center" id="textInput" value="" style="width: 25%; border-top: 0px; border-right: 0px; border-left: 0px; font-size:large;">
        </div>
    <?php
    $query="SELECT * FROM `Outputs` WHERE type=1";
    $rows = mysqli_query($conn , $query) or die(mysqli_error($conn));

    $num = mysqli_num_rows($rows);
    while($row=mysqli_fetch_array($rows))
    {

        $a=$row['state']-2;
        echo '<p style=" font-size: 25px;"><span style="color:red;"><strong>'.$row['name'].'</strong></span>';
        echo '<strong>  Board ' . $row["board"] .' - GPIO '.$row["gpio"]. '</strong> - Lastest value:<span style="color:green;"><strong> '. $a . '</strong></span>';
        echo '<strong> (<a href="delete_output.php?id='.$row['id'].'">Delete</a>)</strong></p><br>';
    ?>
        
        <form action="update.php" method="POST">
        <div class="form-group">
        <input  id="change" type="range" name="rangeInput" min="0" max="255"  onchange="updateTextInput(this.value);" value='<?=$row["state"]-2;?>' style="width: 30%;">
        </div>
        
        <input type="Number" id="id" name='id'value='<?=$row["id"];?>' style="display:none">
        <div class="form-group">
        <button type="submit" class="btn btn-dark" value="login_submit" style=" width: 10%"><i class="fa fa-check "></i> Submit</button>
        </div>
        </form>
        <br>
        <script>
        function updateTextInput(val) {
          document.getElementById('textInput').value=val; 
        }
        </script>
    <?php }; ?>
    
    </div>

    </div>
</div>
<script>
        function updateTextInput(val) {
          document.getElementById('textInput').value=val; 
        }
</script>
<script>
$(document).ready(function(){
  $(".nav-tabs a").click(function(){
    $(this).tab('show');
  });
});
</script>

    <script>
        function updateOutput(element) {
            var xhr = new XMLHttpRequest();
            if(element.checked){
                xhr.open("GET", "esp-outputs-action.php?action=output_update&id="+element.id+"&state=1", true);
            }
            else {
                xhr.open("GET", "esp-outputs-action.php?action=output_update&id="+element.id+"&state=0", true);
            }
            xhr.send();
        }

        function deleteOutput(element) {
            var result = confirm("Want to delete this output?");
            if (result) {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "esp-outputs-action.php?action=output_delete&id="+element.id, true);
                xhr.send();
                alert("Output deleted");
                setTimeout(function(){ window.location.reload(); });
            }
        }

        function createOutput(element) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "esp-outputs-action.php", true);

            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    alert("Output created");
                    setTimeout(function(){ window.location.reload(); });
                }
            }
            var outputName = document.getElementById("outputName").value;
            var outputBoard = document.getElementById("outputBoard").value;
            var outputGpio = document.getElementById("outputGpio").value;
            var outputState = document.getElementById("outputState").value;
            var httpRequestData = "action=output_create&name="+outputName+"&board="+outputBoard+"&gpio="+outputGpio+"&state="+outputState;
            xhr.send(httpRequestData);
        }
    </script>
</body>
</html>
