<?php
    include_once('esp-database.php');
    



    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $action = test_input($_GET["action"]);
        if ($action == "inputs_state") {
            $board = test_input($_GET["board"]);
            $result = getAllinputStates($board);
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $rows[$row["gpio"]] = $row["state"];
                }
            }
            echo json_encode($rows);
        }
    if($action == "inputs_update") {
            $board = test_input($_GET["board"]);
            //echo $board;

            $gpio = test_input($_GET["gpio"]);
            //echo $gpio.'<br>';
            $value = test_input($_GET["value"]);
            
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            
            $sql = "UPDATE `Inputs` SET `value` = '$value' WHERE `Inputs`.`board` = '$board' AND `Inputs`.`gpio` = '$gpio';";
            //echo $sql.'<br>';
            if ($conn->query($sql) === TRUE) {
                echo "New record Updates successfully";
            } 
            else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        
            $conn->close();
        }
    }
    else {
        echo "No data posted with HTTP POST.";
    }


    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>