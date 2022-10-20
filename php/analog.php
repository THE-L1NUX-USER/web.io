<?php
    ob_start();
    include 'connection.php';

  $name=$_POST['name'];
  $name = mysqli_real_escape_string($conn , $name);
  
  $board=$_POST['board'];
  $board = mysqli_real_escape_string($conn , $board);

  
  $gpio=$_POST['gpio'];
  $gpio = mysqli_real_escape_string($conn , $gpio);

  
  $value=$_POST['value'];
  $value = mysqli_real_escape_string($conn , $value);
  $value=$value+2;

  $query="INSERT INTO Outputs (name,board,gpio,state,type) VALUES ('$name','$board','$gpio','$value',1)";
  echo $query;

  $result=mysqli_query($conn , $query) or die(mysqli_error($conn));
  header("location:inputs_display.php");
  ob_end_flush();
    
?>