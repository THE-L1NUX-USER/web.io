<?php
ob_start();
include 'connection.php';

$id=$_POST['id'];
$id = mysqli_real_escape_string($conn , $id);

$value=$_POST['rangeInput'];
$value = mysqli_real_escape_string($conn , $value);
$value=$value+2;
echo $id."<br>".$value;
$query=("UPDATE Outputs SET state='$value' WHERE id=$id");
echo $query;

$result=mysqli_query($conn , $query) or die(mysqli_error($conn));
//echo($news);
header('location:esp-outputs.php');
ob_end_flush();
?>