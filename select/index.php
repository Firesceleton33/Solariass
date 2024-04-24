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
?>


<?php
    
    if (array_key_exists('ERRS', $_POST)) {
        $sqlStatement = "SELECT Essay FROM `Essays` WHERE User_Id='$User_Id'";
        $result = mysqli_query($conn, $sqlStatement);
        if ($result->num_rows > 0) {
            header("Location: https://solariass.infinityfreeapp.com/ERRS/essay_select");
            exit();
        }else{
            header("Location: https://solariass.infinityfreeapp.com/ERRS");
            exit();
        }
        
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Screen</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <form method="post" class="select-form">
        <div class="select-screen">
            <h1>Select App</h1>
            <div class="character-list">
                <div class="character">
                    <img src="ERRS.png" alt="ERRS">
                    <h2>ERRS</h2>
                    <button class="select-button" name="ERRS">Select</button>
                </div>
                <div class="character">
                    <img src="APP 2.png" alt="APP 2">
                    <h2>APP 2(In progress)</h2>
                    <button class="select-button">Select</button>
                </div>
                <div class="character">
                    <img src="character3.png" alt="Character 3">
                    <h2>APP 3(In progress)</h2>
                    <button class="select-button">Select</button>
                </div>
            </div>
        </div>
    </form>
<!-- 
    <script src="js/app.js"></script> -->
</body>
</html>
