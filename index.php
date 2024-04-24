<!-- <?php
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
$url = "https://";   
else  
$url = "http://";   

$url.= $_SERVER['HTTP_HOST'];  

$url.= $_SERVER['REQUEST_URI'];    

echo $_SERVER['HTTP_HOST']."<br>";
echo $_SERVER['REQUEST_URI']."<br>";  
echo 'Hello ' . htmlspecialchars($_GET["name"]) . '!<br>';
echo $url;
?> -->








<!DOCTYPE html>
<html lang="en">

<head>
    <title>Log in</title>

    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- google fonts -->
    <link href="//fonts.googleapis.com/css2?family=Jost:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="css/style.css">

        <!-- fontawesome v5 -->
        <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

<?php
    session_start();
    ini_set('session.gc_maxlifetime', 600);
    ini_set('session.cookie_lifetime', 600);
    
    $servername = "sql301.infinityfree.com";
    $username = "if0_34713213";
    $password = "khtku3X9hi";

    $conn = new mysqli($servername, $username, $password, 'if0_34713213_Users');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
        // echo '<script>alert("Connected successfully")</script>';
?>

<?php

    if (array_key_exists('LogIn', $_POST)) {
        $name = mysqli_real_escape_string($conn, $_POST['Username_Log']);
        $pass = mysqli_real_escape_string($conn, $_POST['Password_Log']);
        $name = str_replace(array('_','%'), '', $name);
        $pass = str_replace(array('_','%'), '', $pass);


        if ($name != ""){
            $sqlStatement = "SELECT Password,Id FROM `Users` WHERE Username='$name'";
            $result = mysqli_query($conn, $sqlStatement);
            
            $Password_Match = FALSE;

            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $stored_hash = $row['Password'];
                    if(password_verify($pass, $stored_hash)) {
                        $Password_Match = TRUE;
                        $_SESSION['User_Id'] = $row['Id'];
                        $_SESSION['User_Name'] = $name;
                        header("Location: https://solariass.infinityfreeapp.com/select");
                        exit();
                    }
                }
            }else{
                echo '<style type="text/css">
                #Username_Log{
                    background-image: linear-gradient(to bottom, #e60023 0%, #d92b1d 90%), linear-gradient(to bottom, #e1e1e1, #e1e1e1);
                }
                </style>';
                echo '<style type="text/css">
                #Password_Log{
                    background-image: linear-gradient(to bottom, #e60023 0%, #d92b1d 90%), linear-gradient(to bottom, #e1e1e1, #e1e1e1);
                }
                </style>';
            }

            if($Password_Match == FALSE){
                echo '<style type="text/css">
                #Password_Log{
                    background-image: linear-gradient(to bottom, #e60023 0%, #d92b1d 90%), linear-gradient(to bottom, #e1e1e1, #e1e1e1);
                }
                </style>';
            }
        }
        
    }
?>

<?php
    function createAccount($username, $email, $password){
        echo 'Hello';
        $unique = uniqid();
        $sqlStatement = "INSERT INTO Users (Username, Email, Password, Account_type, Id) VALUES ('$username', '$email', '$password', 1, '$unique')";
        global $conn;
        if (mysqli_query($conn, $sqlStatement)) {
            echo "New record created successfully";
            return $unique;
        }else{
            echo "Error: Account could not be created";
            // echo "Error: " . $sqlStatement . "<br>" . mysqli_error($conn);
        }
    }

    if (array_key_exists('CreateAccount', $_POST)) {
        echo "ui";
        $name = mysqli_real_escape_string($conn, $_POST['Username_Sign']);
        $name = str_replace(array('_','%'), '', $name);
        $email = mysqli_real_escape_string($conn, $_POST['Email_Sign']);
        $email = str_replace(array('_','%'), '', $email);
        $pass1 = mysqli_real_escape_string($conn, $_POST['Password1_Sign']);
        $pass1 = str_replace(array('_','%'), '', $pass1);
        $pass2 = mysqli_real_escape_string($conn, $_POST['Password2_Sign']);
        $pass2 = str_replace(array('_','%'), '', $pass2);
        echo $name,$email,$pass1,$pass2;

        $sqlStatement = "SELECT Password,Email,Username FROM `Users` WHERE Username='".$name."'";
        $result = mysqli_query($conn, $sqlStatement);
        echo "pass";
        if ($pass1 == $pass2){
            if ($name != "" and $pass1 != "" and $email != ""){
                echo "pass1";
                if ($result->num_rows > 0) {
                    $same_pass = 0;
                    $same_email = 0;
                    echo "pass2";
                    while($row = $result->fetch_assoc()) {
                        echo "pass3";
                        $stored_hash = $row["Password"];
                        if(password_verify($pass1, $stored_hash)) {
                            echo "pass4";
                            $same_pass++;
                        }
                        if($email == $row["Email"]){
                            echo "The email is in use"; 
                            echo '<input type="email" class="form-text" id="Email_Sign" name="Email_Sign"'."That Email already is in use.".'>';
                            $same_email++;
                        }
                    }
                    if ($same_pass == 0){
                        if ($same_email == 0){
                            $password = password_hash($pass1, PASSWORD_DEFAULT);

                            
                            
                            $_SESSION['User_Id'] = createAccount($name, $email, $password);
                            $User_Id = $_SESSION['User_Id'];
                            $_SESSION['User_Name'] = $name;

                            $unique = uniqid();
                            $sqlStatement = "INSERT INTO Essays (Essay_Id, User_Id, Essay_Title) VALUES ('$unique', '$User_Id', 'Untitled Essay')";

                            if (mysqli_query($conn, $sqlStatement)) {
                                header("Location: https://solariass.infinityfreeapp.com/ERRS/?selected_essay=".$unique);  
                            }else{
                                echo "Error: Essay could not be created";
                        
                            }

                            // exit();
                        }else{
                            echo "That email is in use";
                        }
                        
                    }else{
                        echo "That Account already exists";
                    }    
                }else{
                    $password = password_hash($pass1, PASSWORD_DEFAULT);

                    $_SESSION['User_Id'] = createAccount($name, $email, $password);
                    $User_Id = $_SESSION['User_Id'];
                    $_SESSION['User_Name'] = $name;

                    $unique = uniqid();
                    $sqlStatement = "INSERT INTO Essays (Essay_Id, User_Id, Essay_Title) VALUES ('$unique', '$User_Id', 'Untitled Essay')";

                    if (mysqli_query($conn, $sqlStatement)) {
                        header("Location: https://solariass.infinityfreeapp.com/ERRS/?selected_essay=".$unique);  
                    }else{
                        echo "Error: Essay could not be created";
                
                    }
                    // exit();
                }
            }else{
                echo "Please fill out all the fields";
            }
        }else{
            echo "Passwords are not the same";
        }
    }


?>

<?php
    if (array_key_exists('Guest', $_POST)) {
        $_SESSION['User_Id'] = "6549d6704d48c";
        $_SESSION['User_Name'] = "Guest";
        header("Location: https://solariass.infinityfreeapp.com/select");
        exit();
    }
?>



<!-- New toolbar-->

</div>


    <section class="forms">
        <div class="container">
            <!-- logo -->
            <div class="logo">
                <a class="brand-logo" href="index.html">Solariass login and signup page</a>
            </div>
            <!-- //logo -->
            <div class="forms-grid">

                <!-- login -->
                <div class="login">
                    <span class="fas fa-sign-in-alt"></span>
                    <strong>Welcome!</strong>
                    <span>Sign in to your account</span>

                    <form method="post" class="login-form">
                        <fieldset>
                            <div class="form">
                                <div class="form-row">
                                    <span class="fas fa-user"></span>
                                    <label class="form-label" for="input">Name</label>
                                    <input type="text" class="form-text" name="Username_Log" id="Username_Log">
                                </div>
                                <div class="form-row">
                                    <span class="fas fa-eye"></span>
                                    <label class="form-label" for="input">Password</label>
                                    <input type="password" class="form-text" name="Password_Log" id="Password_Log">
                                </div>
                                <div class="slide" style="background-image: url('image1.jpg');">
                                <label class="switch">
                                    <input type="checkbox" id="Switch" onclick='show_password()' checked>
                                    <span class="slider round"></span>
                                </label>
                                </div>
                                <div class="form-row bottom">
                                    <div class="form-check">
                                        <input type="checkbox" id="remenber" name="remenber" value="remenber">
                                        <label for="remenber"> remember me?</label>
                                    </div>
                                    <a href="#url" class="forgot">forgot password?</a>
                                </div>
                                <div class="form-row button-login">
                                    <button type="submit" name="LogIn" class="btn btn-login">Login 
                                        <span
                                            class="fas fa-arrow-right"></span></button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <!-- //login -->

                <!-- register -->
                <div class="register">
                    <span class="fas fa-user-circle"></span>
                    <strong>Create account!</strong>
                    <form method="post" class="register-form">
                        <fieldset>
                            <div class="form">
                                <div class="form-row">
                                    <span class="fas fa-user"></span>
                                    <label class="form-label" for="input">Name</label>
                                    <input type="text" class="form-text" id="Username_Sign" name="Username_Sign">
                                </div>
                                <div class="form-row">
                                    <span class="fas fa-envelope"></span>
                                    <label class="form-label" for="input">E-mail</label>
                                    <input type="email" class="form-text" id="Email_Sign" name="Email_Sign">
                                </div>
                                <div class="form-row">
                                    <span class="fas fa-lock"></span>
                                    <label class="form-label" for="input">Password</label>
                                    <input type="password" class="form-text" id="Password1_Sign" name="Password1_Sign">
                                </div>
                                <div class="form-row">
                                    <span class="fas fa-lock"></span>
                                    <label class="form-label" for="input">Confirm Password</label>
                                    <input type="password" class="form-text" id="Password2_Sign" name="Password2_Sign">
                                </div>
                                <div class="form-row button-login">
                                    <button class="btn btn-login" name="CreateAccount">Create <span
                                            class="fas fa-arrow-right"></span></button>
                                </div>
                            </div>
                        </fieldset>
                        </form>

                        <!-- <span class="create-account">Or create account using social media!</span>

                        <div class="social-media">
                            <a href="#facebook" class="fb"><span class="fab fa-facebook"></span></a>
                            <a href="#twitter" class="tw"><span class="fab fa-twitter"></span></a>
                            <a href="#pinterest" class="pi"><span class="fab fa-pinterest"></span></a>
                        </div> -->
                </div>
                <!-- //register -->


                


            </div>

        
        </div>
    </section>

    <!-- Guest -->
    <br>
    <div class="guest">
        <form method="post" class="guest-form">
            <div class="form-row button-login">
                <button class="btn btn-guest" name="Guest">Continue as Guest<span
                        class="fas fa-arrow-right"></span></button>
            </div>
        </form>
    </div>
    <script src="js/app.js"></script>
</html>