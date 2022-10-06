<?php
ob_start();
    include 'connection.php';
    $id=$_GET['id'];
    echo $id;
    $sql = "DELETE FROM Outputs WHERE id=$id";
    //echo $sql;
    if ($conn->query($sql) === TRUE) {
        header('location:esp-outputs.php');
ob_end_flush();        
}