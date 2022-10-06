<?php
include 'connection.php';

if(!isset($_SESSION['id']))
{
    header("location:index.php");
}
?>


<?php
include 'Navbar.php';
?>
<h1 class="text-center text-dark pb-3 mt-2 mb-2"><span style="color: red;">Logout<span></h1>
    <br>
    <h3 class="text-center">
    <a href="logout_Script.php" >Click here to logout</a>
    </h3>