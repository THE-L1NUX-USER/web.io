<?php
    ob_start();
    include 'connection.php';


    $email = $_POST['email'];
    $email = mysqli_real_escape_string($conn , $email);

    $password = $_POST['password'];
    $password = mysqli_real_escape_string($conn , $password);
    //$password = md5($password);

    $login_select_query = "SELECT id ,user , email from adminpanel WHERE email = '$email' AND password = '$password'";


    $login_select_query_result = mysqli_query($conn , $login_select_query) or die(mysqli_error($conn));

    $total_rows_fetched = mysqli_num_rows($login_select_query_result);
    //echo $total_rows_fetched;
    if($total_rows_fetched!=0){
        $row = mysqli_fetch_array($login_select_query_result);
        $_SESSION['type'] = $row['user'];
        $_SESSION['id']=$row['id'];
        echo $_SESSION['type'];
        //header("location:Profile_Page.php");
        header("location:esp-outputs.php");
    }
    else{
        $error = "<span style='color: red;'>Invalid Credentials</span>";
        header("location:index.php?m1=".$error);
        echo 'invalid credentials';
    }
    ob_end_flush();
?>