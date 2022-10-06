<?php
ob_start();
include 'connection.php';

if(isset($_SESSION['id']))
{
    //header("location:Profile_Page.php");
    header("location:esp-outputs.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <title>Login Portal</title>
</head>
<body style="background-color: black;">
  <div class="container-fluid" style="margin-top:4%;">
<img class="mx-auto d-block  img-responsive" style="height: 300px;"src="webiologo.png" alt="First slide" style="height: 900px !important;">
     <br>
     <h3 class="text-center text-dark"><b>Login Panel</b></h3>

</div>
<div class="container">
      <div class="row">
        <div class=" col col-sm-4 offset-sm-4">
          <br>
          <form action="admin_login_script.php" method="POST">
            <div class="form-group">
              <input type="emai" class="form-control" name="email" id="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" style="border-top: 0px; border-right: 0px; border-left: 0px;" required>
              </div>
            <div class="form-group">
                <input type="password" class="form-control validate white-text" name="password" id="password" placeholder="Password" pattern=".{6,}" style="border-top: 0px; border-right: 0px; border-left: 0px;"required>
            </div>
            <div class="form-group text-center">
            <button type="submit" class="btn btn-dark" value="login_submit" style="padding-left: 15%; padding-right: 15%;"><i class="fa fa-user-circle "></i> Login</button>
            </div>
            <div class="form-group text-center">
                <?php
                if(isset($_GET['m1'])){
                    echo $_GET['m1'] ;
                    }
                ?>
                </div>
            </form>
        </div>
      </div>
    </div>

</body>
</html>
<?php ob_end_flush(); ?>