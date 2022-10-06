<?php
    ob_start();
    include 'connection.php';
    $id=$_GET['id'];
    $sql = "DELETE FROM Inputs WHERE id=$id";
    //echo $sql;
    if ($conn->query($sql) === TRUE) {
        header('location:readings.php');
    ob_end_flush();
}