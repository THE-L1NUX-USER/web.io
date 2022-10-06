<?php
ob_start();
$conn=mysqli_connect("db","user","password","database")
or die(mysqli_error($conn));
if(!isset($_SESSION['id'])){ 
    session_start();
}
ob_end_flush();
?>


