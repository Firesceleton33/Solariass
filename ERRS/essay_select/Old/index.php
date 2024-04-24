<?php
    session_start();
    ini_set('session.gc_maxlifetime', 600);
    ini_set('session.cookie_lifetime', 600);
    $User_Id = $_SESSION['User_Id'];
    $User_Name = $_SESSION['User_Name'];

    if ($User_Name == ""){
        header("Location: https://solariass.infinityfreeapp.com");
        exit();
    }

    $servername = "sql301.infinityfree.com";
    $username = "if0_34713213";
    $password = "khtku3X9hi";

    $conn = new mysqli($servername, $username, $password, 'if0_34713213_Users');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlStatement = "SELECT Username FROM `Users` WHERE Id='$User_Id'";
    $result = mysqli_query($conn, $sqlStatement);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["Username"] != $User_Name){
            header("Location: https://solariass.infinityfreeapp.com");
            exit();
        }
    }
    


    $sqlStatement1 = "SELECT Essay, Essay_Title FROM `Essays` WHERE User_Id='$User_Id'";
    $result = mysqli_query($conn, $sqlStatement1);

    
    $essays = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $essays[] = $row;
        }
    }

    $jsonString = json_encode($essays);
    echo json_encode($essays);
    
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Essay Management</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="https://solariass.infinityfreeapp.com/ERRS">Your Essays</a>
        </div>
    </header>
    <main>
        <div id="essay-list">
            <h1>Choose an Essay to Manage</h1>
            <ul>
                <li>
                    <a href="edit_essay.php?essay_id=1">Essay 1</a>
                    <a href="export_essay.php?essay_id=1">Export</a>
                </li>
                <li>
                    <a href="edit_essay.php?essay_id=2">Essay 2</a>
                    <a href="export_essay.php?essay_id=2">Export</a>
                </li>
                <!-- Add more essays as needed -->
            </ul>
        </div>
    </main>
    <script src="js/essay_display.js"></script>
    
</body>
</html>
