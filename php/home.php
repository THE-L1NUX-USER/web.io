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
<head>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<title>Team</title>
<style type="text/css">
    	body{
    margin-top:20px;
    color: #1a202c;
    text-align: left;
    background-color: #e2e8f0;
}
.main-body {
    padding: 15px;
}
.card {
    box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0,0,0,.125);
    border-radius: .25rem;
}

.card-body {
    flex: 1 1 auto;
    min-height: 1px;
    padding: 1rem;
}

.gutters-sm {
    margin-right: -8px;
    margin-left: -8px;
}

.gutters-sm>.col, .gutters-sm>[class*=col-] {
    padding-right: 8px;
    padding-left: 8px;
}
.mb-3, .my-3 {
    margin-bottom: 1rem!important;
}

.bg-gray-300 {
    background-color: #e2e8f0;
}
.h-100 {
    height: 100%!important;
}
.shadow-none {
    box-shadow: none!important;
}
table{
  width: 100%;
}

    </style>
</head>
<body>
<?php
include 'Navbar.php';
?>

<h1 class="text-center text-Dark pb-3 pt-3 ml-0">Team Details</h1>
  <div class="container">
  <table>
  <tr>
    <th></th>
    <th></th>
  </tr>
  <?php
            $search="SELECT id,Name,user,email,Department,Mobile,Address,image_path FROM adminpanel";
            $query_result=mysqli_query($conn,$search) or die(mysqli_error($conn));
            $no_of_rows=mysqli_num_rows($query_result);
            while($row=mysqli_fetch_array($query_result))
            {
        ?>


  <tr>
    <td>
      <div class="card" style="border: none;">
      <div class="card-body">
        <div class="d-flex flex-column align-items-center text-center">
          <img src="<?=$row['image_path'];?>" alt="Admin" class="rounded-circle" width="150">
        </div>
      </div>
    </div></td>

    <td><div class="card mb-3">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-3">
            <h6 class="mb-0">Full Name</h6>
          </div>
          <div class="col-sm-9 text-secondary">
          <?=$row['Name'];?>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-3">
            <h6 class="mb-0">Email</h6>
          </div>
          <div class="col-sm-9 text-secondary">
          <?=$row['email'];?>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-3">
            <h6 class="mb-0">Department</h6>
          </div>
          <div class="col-sm-9 text-secondary">
          <?=$row['Department'];?>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-3">
            <h6 class="mb-0">User</h6>
          </div>
          <div class="col-sm-9 text-secondary">
          <?php
          if($row['user']){
            echo '<strong>Admin</strong>';
          }
          else
          echo 'Viewer';
          
          ?>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-3">
            <h6 class="mb-0">Address</h6>
          </div>
          <div class="col-sm-9 text-secondary">
          <?=$row['Address'];?>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-3">
            <h6 class="mb-0">Mobile</h6>
          </div>
          <div class="col-sm-9 text-secondary">
          <?=$row['Mobile'];?>
          </div>
        </div>
      </div>
    </div></td>

  </tr>
  <?php   }  ?>
  </table>
  </div>
</body>
</html>
<?php ob_end_flush(); ?>