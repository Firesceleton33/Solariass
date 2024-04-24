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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $unique = uniqid();

    
    // $sqlStatement = "UPDATE Essays SET Essay = '$essay', Essay_Title = '$essay_Title' WHERE Essay_id='$selected_essay'";
    $sqlStatement = "INSERT INTO Essays (Essay_Id, User_Id, Essay_Title) VALUES ('$unique', '$User_Id', 'Untitled Essay')";
    if (mysqli_query($conn, $sqlStatement)) {
        header("Location: https://solariass.infinityfreeapp.com/ERRS/?selected_essay=".$unique);  
    }else{
        echo "Error: Essay could not be created";

    }
}
?>

<?php

    $sqlStatement1 = "SELECT Essay, Essay_Title, Essay_Id FROM `Essays` WHERE User_Id='$User_Id'";
    $result = mysqli_query($conn, $sqlStatement1);

    
    $essays = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $essays[] = $row;
        }
    }
 

    $jsonString = json_encode($essays);
    // echo $jsonString;

    

?>
    <script>
    var userData = <?php echo $jsonString ?>;
    </script>





<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Select screen</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body class="framer-body-DF9F4vYaI">
        <div id="main" data-framer-hydrate-v2="{&quot;routeId&quot;:&quot;DF9F4vYaI&quot;,&quot;localizationId&quot;:&quot;default&quot;,&quot;localeId&quot;:&quot;default&quot;}" data-framer-ssr-released-at="2023-11-07T11:04:20.666Z" data-framer-page-optimized-at="2023-11-27T19:50:45.436Z">
            <!--$-->
            <div class="framer-e7Cwi" style="display:contents">
                <div class="framer-73mbp5" style="min-height:100vh;width:auto">
                    <div class="framer-13bflq9" data-framer-name="Testimonials 3" name="Testimonials 3">
                        <div class="framer-le3gyu">
                            <div class="columb-1"></div>
                            <div class="columb-2"></div>
                            <div class="columb-3"></div>
                        </div>
                        <div>
                            <form method='post'>
                                <button type="submit" name="New_Essay">New Essay</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="overlay"></div>
            </div>
            <!--/$-->
        </div>
        <script src="js/script.js"></script>
    </body>
</html>
