<?php
ob_start();
include 'connection.php';

if(!isset($_SESSION['id']))
{
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="esp-style.css">
<title>Insert More</title>
</head>
<body>
<?php
include 'Navbar.php';
?>
<div class="container-fluid" style="width: 100%;">
    <h1 class="text-center text-Dark pb-3 pt-3 ml-0">Insert More<i class="fa fa-eye" aria-hidden="true" style="font-size: 35px;"></i></h1>
    
    <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="navi">
    <li class="nav-item btn btn-secondary btn-info mr-2 mb-1 ml-1 btn-sm">
      <a class="nav-link text-dark" href="#Outputs" style="border: none !important;">Outputs </a>
    </li>
    <li class="nav-item btn btn-secondary btn-info mr-2 mb-1 ml-1 btn-sm">
    <a class="nav-link text-dark" href="#Inputs">Inputs</a>
    </li>
  </ul>
</div>

<div class="tab-content">

      <div id="Outputs" class="container-fluid tab-pane active"><br>
      <!--<h1 class="text-center text-dark pb-3 mt-2 mb-2">Insert OutPut</h1>-->
            
      <div class="container-fluid" >
        <div class="row justify-content-center">
            <div class="col-lg-5 bg-dark text-light rounded px-4">
            <h3 class="text-center pt-2">Create New Digital Output</h3>
            <hr style="border: 1px solid white;"><br>
        <form onsubmit="return createOutput();">
        <div class="form-group bg-dark text-white">
        <label for="outputName">Name</label>
        <input type="text" name="name" id="outputName"><br>
        </div>
        <div class="form-group bg-dark text-white">
        <label for="outputBoard">Board ID</label>
        <input type="number" name="board" min="0" id="outputBoard">
        </div>
        <div class="form-group bg-dark text-white">
        <label for="outputGpio">GPIO Number</label>
        <input type="number" name="gpio" min="0" id="outputGpio">
        </div>
        <div class="form-group bg-dark text-white">
        <label for="outputState">Initial GPIO State</label>
        <select id="outputState" name="state">
          <option value="0">OFF</option>
          <option value="1">ON</option>
        </select>
        </div>
        <div class="form-group bg-dark text-white">
        <input type="submit" value="Create Output">
        </div>
        
    </form>
    </div>
        </div>
      </div>
<br>
      <div class="container-fluid" >
        <div class="row justify-content-center">
            <div class="col-lg-5 bg-dark text-light rounded px-4">
            <h3 class="text-center pt-2">Create New PWM Output</h3>
            <hr style="border: 1px solid white;"><br>
        <form action="analog.php" method="POST">
        <div class="form-group bg-dark text-white">
        <label for="outputName">Name</label>
        <input type="text" name="name" id="outputName"><br>
        </div>
        <div class="form-group bg-dark text-white">
        <label for="outputBoard">Board ID</label>
        <input type="number" name="board" min="0" id="board">
        </div>
        <div class="form-group bg-dark text-white">
        <label for="outputGpio">GPIO Number</label>
        <input type="number" name="gpio" min="0" id="gpio">
        </div>
        <div class="form-group bg-dark text-white">
        <label for="outputState">GPI0 Value</label>
        <input type="number" name="value" min="0" max="255" value=0 id="value">
        </div>
        <div class="form-group bg-dark text-white">
        <input type="submit" value="Create Output">
        </div>
        
    </form>
    </div>
        </div>
      </div>
      


      </div>

      <div id="Inputs" class="container-fluid tab-pane"><br>
      <!--<h1 class="text-center text-dark pb-3 mt-2 mb-2">Insert Inputs</h1>-->


      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-5 bg-dark text-light rounded px-4">
            <h3 class="text-center pt-2">Create New Input</h3>
            <hr style="border: 1px solid white;"><br>
        <form action="input_adder.php" method="POST">
        <div class="form-group bg-dark text-white">
        <label>Name</label>
        <input type="text" name="name" id="name"><br>
        </div>
        <div class="form-group bg-dark text-white">
        <label>Board ID</label>
        <input type="number" name="inputboard" min="0" id="inputboard">
        </div>
        <div class="form-group bg-dark text-white">
        <label for="outputGpio">GPIO Number</label>
        <input type="number" name="inputgpio" min="0" id="inputgpio">
        </div>
        <div class="form-group bg-dark text-white">
        <label for="outputState">Type of Sensor</label>
        <select id="inputtype" name="inputtype">
          <option value="0">Analog</option>
          <option value="1">Digital</option>
        </select>
        </div>
        <div class="form-group bg-dark text-white">
        <input type="submit" value="Create Input">
        </div>
        
    </form>
    </div>
    </div>



      </div>

</div>

<script>
$(document).ready(function(){
  $(".nav-tabs a").click(function(){
    $(this).tab('show');
  });
});
</script>



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
<?php ob_end_flush(); ?>