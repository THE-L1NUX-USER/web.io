<?php
    ob_start();
    include 'connection.php';

  $name=$_POST['name'];
  $name = mysqli_real_escape_string($conn , $name);
  
  $board=$_POST['inputboard'];
  $board = mysqli_real_escape_string($conn , $board);

  
  $gpio=$_POST['inputgpio'];
  $gpio = mysqli_real_escape_string($conn , $gpio);

  
  $type=$_POST['inputtype'];
  $type = mysqli_real_escape_string($conn , $type);

  $query="INSERT INTO Inputs (name,board,gpio,digital) VALUES ('$name','$board','$gpio','$type')";
  echo $query;

  $result=mysqli_query($conn , $query) or die(mysqli_error($conn));
  header("location:inputs_display.php");
  ob_end_flush();  
?>