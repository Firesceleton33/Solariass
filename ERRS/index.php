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

    $selected_essay = $_GET["selected_essay"];


    $sqlStatement1 = "SELECT Essay, Essay_Title FROM `Essays` WHERE User_Id='$User_Id' AND Essay_id='$selected_essay'";
    $result = mysqli_query($conn, $sqlStatement1);
    

    if ($result->num_rows < 1) {
        header("Location: https://solariass.infinityfreeapp.com");  
        exit();
    } else{
        $essaydata = mysqli_fetch_assoc($result);

        $essayData = json_encode($essaydata);
    }
?>

<?php

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     // Handle AJAX request
//     $data = $_POST['data'];
//     $responseData = "Received: " . $data;

//     header('Content-Type: application/json'); // Set response type to JSON
//     echo json_encode(['response' => $responseData]);
//     exit; // Make sure to exit to prevent further HTML rendering
// }

// $data = json_decode(file_get_contents("php://input"), true);
// echo $data;
if (array_key_exists('essay_Title', $_POST) & array_key_exists('essay', $_POST)) {
// if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $essay = mysqli_real_escape_string($conn, $_POST['essay']);
    $essay = str_replace(array('%'), '', $essay);
    
    $essay_Title = mysqli_real_escape_string($conn, $_POST['essay_Title']);
    $essay_Title = str_replace(array('%'), '', $essay_Title);

     
    $sqlStatement = "UPDATE Essays SET Essay = '$essay', Essay_Title = '$essay_Title' WHERE Essay_id='$selected_essay'";
    // $sqlStatement = "UPDATE Essays (User_Id, Essay_Title, Essay) VALUES ('$User_Id','$essay_Title', '$essay')";
    if (mysqli_query($conn, $sqlStatement)) {
        echo '<script type="text/javascript">';
        echo 'DisplaySelectedEssay(essayData);';
        echo '</script>'; 
        header("Refresh:0");
    }else{
        echo "Error: Essay could not be created";

    }
}
?>

<?php


// Uncoment this to make synonyms work
$key = 'bc64fd4bd0mshc030990613a14bep1f5b44jsn4e53ab9af454';
$host = 'synonyms-word-info.p.rapidapi.com';
$array = [$key, $host];
$array = json_encode($array);


// if (array_key_exists('Synonyms_btn', $_POST)) {
//     $Synonym_search = mysqli_real_escape_string($conn, $_POST['Synonyms_btn']);
//     $Synonym_search = str_replace(array('%'), '', $Synonym_search);
//     echo "did1";
    
// }


?>
<script>
    var data = <?php echo $array ?>;
</script>



<script>
    var essayData = <?php echo $essayData ?>;
</script>

<?php
    // $servername = "sql301.infinityfree.com";
    // $username = "if0_34713213";
    // $password = "khtku3X9hi";

    // $conn = new mysqli($servername, $username, $password, 'if0_34713213_Users');

    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // $sqlStatement1 = "SELECT Thread_Id FROM `Essays` WHERE User_Id='$User_Id' AND Essay_id='$selected_essay'";
    $sqlStatement1 = "SELECT Thread_Id FROM `Essays` WHERE User_Id='$User_Id' AND Essay_id='$selected_essay'";
    // echo $sqlStatement1; 
    $result = mysqli_query($conn, $sqlStatement1);
    
    $result = mysqli_fetch_assoc($result);
    // $result = json_encode($result);
    // $result = '{"null"}';

    // echo $result;
    // echo is_null($result['Thread_Id']);

    if (is_null($result['Thread_Id']) == 1) {   
        // echo "<script>async function openThread(){console.log('Calling GPT3'); const url = 'https://api.openai.com/v1/threads';const options = {method: 'POST',headers: {'Content-Type': 'application/json','Authorization': 'Bearer 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','OpenAI-Beta' : 'assistants=v1'}};try {const response = await fetch(url, options);const result = await response.text();const parsedData = JSON.parse(result);console.log(parsedData);input = document.getElementById('thread_number');input.value = parsedData['id'];document.getElementById('Virtual_Assistant').submit();} catch (error){console.error(error);}}openThread();</script>";
        echo '<script src="js/script.js"></script>';
        echo "<script>openThread();</script>";
    }else{
        $_SESSION['Thread_Id'] = $result['Thread_Id'];
        $thread = json_encode($result['Thread_Id']);
    };
       
?>

<script>
    var thread_id = <?php echo $thread ?>;
</script>

<?php
    if (array_key_exists('thread_number', $_POST)){
        $Thread = mysqli_real_escape_string($conn, $_POST['thread_number']);
        // echo $Thread;
        $sqlStatement1 = "UPDATE `Essays` SET Thread_Id='$Thread' WHERE User_Id='$User_Id' AND Essay_id='$selected_essay'";
        mysqli_query($conn, $sqlStatement1);
        
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <!-- <form method="post" class="essay-function"> -->
        <div class="root">
            <div class="header">
                <div class="center">
                    <a href="https://solariass.infinityfreeapp.com/ERRS/essay_select/"><img src="https://framerusercontent.com/images/zndoQO5Ib96e2D5IYa3LYtX1mSk.png" data-testid="logo" data-tourid="logo" alt="Essay logo" style="height: 35px;"></a>
                    <div class="options">
                        <input placeholder="Untitled Essay" class="input_title" id="Essay_Title" type="text" value="">
                        <div class="save_status">
                            <span role="img" aria-label="cloud-server" class="ison_save">
                                <svg viewBox="64 64 896 896" focusable="false" data-icon="cloud-server" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                    <path d="M704 446H320c-4.4 0-8 3.6-8 8v402c0 4.4 3.6 8 8 8h384c4.4 0 8-3.6 8-8V454c0-4.4-3.6-8-8-8zm-328 64h272v117H376V510zm272 290H376V683h272v117z"></path>
                                    <path d="M424 748a32 32 0 1064 0 32 32 0 10-64 0zm0-178a32 32 0 1064 0 32 32 0 10-64 0z"></path>
                                    <path d="M811.4 368.9C765.6 248 648.9 162 512.2 162S258.8 247.9 213 368.8C126.9 391.5 63.5 470.2 64 563.6 64.6 668 145.6 752.9 247.6 762c4.7.4 8.7-3.3 8.7-8v-60.4c0-4-3-7.4-7-7.9-27-3.4-52.5-15.2-72.1-34.5-24-23.5-37.2-55.1-37.2-88.6 0-28 9.1-54.4 26.2-76.4 16.7-21.4 40.2-36.9 66.1-43.7l37.9-10 13.9-36.7c8.6-22.8 20.6-44.2 35.7-63.5 14.9-19.2 32.6-36 52.4-50 41.1-28.9 89.5-44.2 140-44.2s98.9 15.3 140 44.3c19.9 14 37.5 30.8 52.4 50 15.1 19.3 27.1 40.7 35.7 63.5l13.8 36.6 37.8 10c54.2 14.4 92.1 63.7 92.1 120 0 33.6-13.2 65.1-37.2 88.6-19.5 19.2-44.9 31.1-71.9 34.5-4 .5-6.9 3.9-6.9 7.9V754c0 4.7 4.1 8.4 8.8 8 101.7-9.2 182.5-94 183.2-198.2.6-93.4-62.7-172.1-148.6-194.9z"></path>
                                </svg>
                            </span>
                            <span class="save_status_text">Saved</span>
                        </div>
                            <button class="btn_save" onclick="ReadySave()">
                                <span role="img" aria-label="copy" class="icon_dubplicate">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                                    <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                                </svg>
                                </span>
                                <span>Save</span>
                            </button>

                            
                            <button type="button" class="btn_duplicate">
                                <span role="img" aria-label="copy" class="icon_dubplicate">
                                    <svg viewBox="64 64 896 896" focusable="false" data-icon="copy" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                        <path d="M832 64H296c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h496v688c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8V96c0-17.7-14.3-32-32-32zM704 192H192c-17.7 0-32 14.3-32 32v530.7c0 8.5 3.4 16.6 9.4 22.6l173.3 173.3c2.2 2.2 4.7 4 7.4 5.5v1.9h4.2c3.5 1.3 7.2 2 11 2H704c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32zM350 856.2L263.9 770H350v86.2zM664 888H414V746c0-22.1-17.9-40-40-40H232V264h432v624z"></path>
                                    </svg>
                                </span>
                                <span>Duplicate</span>
                            </button>
                            <button type="button" class="btn_export">
                                <span role="img" aria-label="export" class="icon_export">
                                    <svg viewBox="64 64 896 896" focusable="false" data-icon="export" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                        <path d="M888.3 757.4h-53.8c-4.2 0-7.7 3.5-7.7 7.7v61.8H197.1V197.1h629.8v61.8c0 4.2 3.5 7.7 7.7 7.7h53.8c4.2 0 7.7-3.4 7.7-7.7V158.7c0-17-13.7-30.7-30.7-30.7H158.7c-17 0-30.7 13.7-30.7 30.7v706.6c0 17 13.7 30.7 30.7 30.7h706.6c17 0 30.7-13.7 30.7-30.7V765.1c0-4.3-3.5-7.7-7.7-7.7zm18.6-251.7L765 393.7c-5.3-4.2-13-.4-13 6.3v76H438c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h314v76c0 6.7 7.8 10.5 13 6.3l141.9-112a8 8 0 000-12.6z"></path>
                                    </svg>
                                </span>
                                <span>Export</span>
                            </button>
                            <button type="button" class="btn_share">
                                <span role="img" aria-label="share-alt" class="icon_share">
                                    <svg viewBox="64 64 896 896" focusable="false" data-icon="share-alt" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                        <path d="M752 664c-28.5 0-54.8 10-75.4 26.7L469.4 540.8a160.68 160.68 0 000-57.6l207.2-149.9C697.2 350 723.5 360 752 360c66.2 0 120-53.8 120-120s-53.8-120-120-120-120 53.8-120 120c0 11.6 1.6 22.7 4.7 33.3L439.9 415.8C410.7 377.1 364.3 352 312 352c-88.4 0-160 71.6-160 160s71.6 160 160 160c52.3 0 98.7-25.1 127.9-63.8l196.8 142.5c-3.1 10.6-4.7 21.8-4.7 33.3 0 66.2 53.8 120 120 120s120-53.8 120-120-53.8-120-120-120zm0-476c28.7 0 52 23.3 52 52s-23.3 52-52 52-52-23.3-52-52 23.3-52 52-52zM312 600c-48.5 0-88-39.5-88-88s39.5-88 88-88 88 39.5 88 88-39.5 88-88 88zm440 236c-28.7 0-52-23.3-52-52s23.3-52 52-52 52 23.3 52 52-23.3 52-52 52z"></path>
                                    </svg>
                                </span>
                                <span>Share</span>
                            </button>
                    </div>

                    <div class="Avatar" style="gap: 8px;">
                        <button type="button" class="btn_avatar">
                            <span class="name_avatar" style="transform: scale(1) translateX(-50%);">11</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="workspace">
                <div class="phases">
                    <div class="outline">
                        <button onclick="Outline()">
                            <span role="img" aria-label="unordered-list" class="icon_outline">
                                <svg viewBox="64 64 896 896" focusable="false" data-icon="unordered-list" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                    <path d="M912 192H328c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h584c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8zm0 284H328c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h584c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8zm0 284H328c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h584c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8zM104 228a56 56 0 10112 0 56 56 0 10-112 0zm0 284a56 56 0 10112 0 56 56 0 10-112 0zm0 284a56 56 0 10112 0 56 56 0 10-112 0z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="produce">
                        <button onclick="Produce()">
                            <span role="img" aria-label="file-text" class="icon_produce">
                                <svg viewBox="64 64 896 896" focusable="false" data-icon="file-text" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                    <path d="M854.6 288.6L639.4 73.4c-6-6-14.1-9.4-22.6-9.4H192c-17.7 0-32 14.3-32 32v832c0 17.7 14.3 32 32 32h640c17.7 0 32-14.3 32-32V311.3c0-8.5-3.4-16.7-9.4-22.7zM790.2 326H602V137.8L790.2 326zm1.8 562H232V136h302v216a42 42 0 0042 42h216v494zM504 618H320c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h184c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zM312 490v48c0 4.4 3.6 8 8 8h384c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8H320c-4.4 0-8 3.6-8 8z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="rewrite">
                        <span role="img" class="icon_rewrite">
                            <button onclick="Rewrite()">
                                <svg width="1em" height="1em" viewBox="0 0 32 30" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="">
                                    <g clip-path="url(#clip0_137367_182304)">
                                        <path d="M24.8513 5.10082L20.0862 0.33609C19.6446 -0.105472 18.9362 -0.112855 18.5035 0.319918L1.36761 17.4554C1.33386 17.4892 1.30926 17.5317 1.2973 17.5781L0.287615 23.5185C0.0692945 24.3475 0.83992 25.1181 1.6689 24.8998L7.6089 23.8901C7.65566 23.8778 7.69785 23.8535 7.7316 23.8198L24.8675 6.68355C25.2999 6.25113 25.2929 5.54238 24.8513 5.10082ZM6.86816 21.5009L2.64062 22.5464L3.68617 18.3189L19.3191 2.68629L22.5011 5.86828L6.86816 21.5009Z" fill="currentColor"></path>
                                        <path d="M27.3031 23.838C27.2866 24.4529 26.6682 24.937 25.9341 24.937H11.8379C11.5373 24.937 11.3864 24.6322 11.5991 24.4543L13.6118 22.7675C13.6734 22.7159 13.757 22.687 13.8439 22.687H25.9605C26.3314 22.687 26.6671 22.8129 26.91 23.0164C27.1596 23.2256 27.3115 23.5167 27.3027 23.838H27.3031Z" fill="currentColor"></path>
                                        <path d="M29.4996 19.3124C29.4859 19.9273 28.9674 20.4114 28.3525 20.4114L16.2275 20.4374C15.9764 20.4374 15.8506 20.1336 16.0281 19.9561L17.7139 18.2703C17.7669 18.2173 17.8394 18.1874 17.9146 18.1874L28.3753 18.1614C28.6861 18.1614 28.9674 18.2872 29.1709 18.4908C29.3801 18.7 29.5074 18.991 29.5 19.3124H29.4996Z" fill="currentColor"></path>
                                        <path d="M1.375 27.1874H30.625C31.2459 27.1874 31.75 27.6915 31.75 28.3124V29.1551C31.75 29.3108 31.6234 29.4374 31.4677 29.4374H0.532305C0.376562 29.4374 0.25 29.3108 0.25 29.1547V28.312C0.25 27.6912 0.754141 27.1874 1.375 27.1874Z" fill="currentColor"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_137367_182304">
                                            <rect width="31.5" height="29.4374" fill="white" transform="translate(0.25)"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </button>
                        </span>
                    </div>
                    <div class="reorder">
                        <button onclick="Reorder()">
                            <span role="img" aria-label="retweet" class="icon_reorder">
                                <svg viewBox="0 0 1024 1024" focusable="false" data-icon="retweet" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                    <path d="M136 552h63.6c4.4 0 8-3.6 8-8V288.7h528.6v72.6c0 1.9.6 3.7 1.8 5.2a8.3 8.3 0 0011.7 1.4L893 255.4c4.3-5 3.6-10.3 0-13.2L749.7 129.8a8.22 8.22 0 00-5.2-1.8c-4.6 0-8.4 3.8-8.4 8.4V209H199.7c-39.5 0-71.7 32.2-71.7 71.8V544c0 4.4 3.6 8 8 8zm752-80h-63.6c-4.4 0-8 3.6-8 8v255.3H287.8v-72.6c0-1.9-.6-3.7-1.8-5.2a8.3 8.3 0 00-11.7-1.4L131 768.6c-4.3 5-3.6 10.3 0 13.2l143.3 112.4c1.5 1.2 3.3 1.8 5.2 1.8 4.6 0 8.4-3.8 8.4-8.4V815h536.6c39.5 0 71.7-32.2 71.7-71.8V480c-.2-4.4-3.8-8-8.2-8z"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="funcion_screen">
                    <div id="Outline">
                        <article class="Article">Outline</article>
                        <div class="funcion_buttons">
                            <button type="button" class="btn_topic1" onclick="CreateOutline()">
                                <span role="img" aria-label="plus" class="icon_topic">
                                    <svg viewBox="64 64 896 896" focusable="false" data-icon="plus" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                        <path d="M482 152h60q8 0 8 8v704q0 8-8 8h-60q-8 0-8-8V160q0-8 8-8z"></path>
                                        <path d="M176 474h672q8 0 8 8v60q0 8-8 8H176q-8 0-8-8v-60q0-8 8-8z"></path>
                                    </svg>
                                </span>
                                <span>Create outline topic</span>
                            </button>
                            <button type="button" class="btn_topic2">
                                <span role="img" aria-label="expand-alt" tabindex="-1" class="icon_btn_topic2">
                                    <svg viewBox="64 64 896 896" focusable="false" data-icon="expand-alt" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                        <path d="M855 160.1l-189.2 23.5c-6.6.8-9.3 8.8-4.7 13.5l54.7 54.7-153.5 153.5a8.03 8.03 0 000 11.3l45.1 45.1c3.1 3.1 8.2 3.1 11.3 0l153.6-153.6 54.7 54.7a7.94 7.94 0 0013.5-4.7L863.9 169a7.9 7.9 0 00-8.9-8.9zM416.6 562.3a8.03 8.03 0 00-11.3 0L251.8 715.9l-54.7-54.7a7.94 7.94 0 00-13.5 4.7L160.1 855c-.6 5.2 3.7 9.5 8.9 8.9l189.2-23.5c6.6-.8 9.3-8.8 4.7-13.5l-54.7-54.7 153.6-153.6c3.1-3.1 3.1-8.2 0-11.3l-45.2-45z"></path>
                                    </svg>
                                </span>
                            </button>
                            
                        </div>
                        <hr class="separator" role="separator"></hr>
                    </div>
                    <div id="Produce" class="hidden">
                        <article class="Article">Produce</article>
                        
                        <div class="Produce_funcion_buttons">
                            <button type="button" class="btn_topic2">
                                <span role="img" aria-label="expand-alt" tabindex="-1" class="icon_btn_topic2">
                                    <svg viewBox="64 64 896 896" focusable="false" data-icon="expand-alt" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                        <path d="M855 160.1l-189.2 23.5c-6.6.8-9.3 8.8-4.7 13.5l54.7 54.7-153.5 153.5a8.03 8.03 0 000 11.3l45.1 45.1c3.1 3.1 8.2 3.1 11.3 0l153.6-153.6 54.7 54.7a7.94 7.94 0 0013.5-4.7L863.9 169a7.9 7.9 0 00-8.9-8.9zM416.6 562.3a8.03 8.03 0 00-11.3 0L251.8 715.9l-54.7-54.7a7.94 7.94 0 00-13.5 4.7L160.1 855c-.6 5.2 3.7 9.5 8.9 8.9l189.2-23.5c6.6-.8 9.3-8.8 4.7-13.5l-54.7-54.7 153.6-153.6c3.1-3.1 3.1-8.2 0-11.3l-45.2-45z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <hr class="separator" role="separator"></hr>
                        <!-- <form method='post' id="synonyms"> -->
                            <input type="search" id="Synonyms_btn" name="Synonyms_btn"></input>
                            <button onclick="fetchData()">Search</button>
                        <!-- </form> -->

                        <ul id="Synonyms" class="Synonyms">
                        </ul>

                        <hr class="separator" role="separator"></hr>

                        <div class="logo-container">
                            <img class="logo" src="ai.png" alt="VirtualPen Logo">
                            <div class="logo-text">VirtualPen</div>
                            <div>
                                <input id="checkbox-1" type="checkbox">
                                <label for="checkbox-1">
                                <i class="material-icons">Send essay</i></label>
                            </div>
                        </div>
                        <div class="chat-body">
                            <div id="chat-text" class="chat-text">
                                <div class="ai-message">Hello! How can I assist you today?</div>
                            </div>
                            <div class="chat-input">
                                <input type="text" id="user-input" class="user-input" placeholder="Type your message...">
                                <button id="send-button" class="send-button" onclick="SendMessageOpenAi()">Send</button>
                            </div>
                        </div>
                        

                    </div>
                    <!-- <div class="Box">
                        <div class="Outline_title">
                            <article class="ant-typography" value="Untitled outline topic">Untitled outline topic</article>
                            <div class="Outline_Buttons">
                                <button type="button" class="btn_outline_edit">
                                    <span role="img" aria-label="edit" tabindex="-1" class="anticon anticon-edit">
                                        <svg viewBox="64 64 896 896" focusable="false" data-icon="edit" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                            <path d="M257.7 752c2 0 4-.2 6-.5L431.9 722c2-.4 3.9-1.3 5.3-2.8l423.9-423.9a9.96 9.96 0 000-14.1L694.9 114.9c-1.9-1.9-4.4-2.9-7.1-2.9s-5.2 1-7.1 2.9L256.8 538.8c-1.5 1.5-2.4 3.3-2.8 5.3l-29.5 168.2a33.5 33.5 0 009.4 29.8c6.6 6.4 14.9 9.9 23.8 9.9zm67.4-174.4L687.8 215l73.3 73.3-362.7 362.6-88.9 15.7 15.6-89zM880 836H144c-17.7 0-32 14.3-32 32v36c0 4.4 3.6 8 8 8h784c4.4 0 8-3.6 8-8v-36c0-17.7-14.3-32-32-32z"></path>
                                        </svg>
                                    </span>
                                </button>
                                <button type="button" class="btn_outline_more">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" class="css-f7d20k" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.293 9.293 12 13.586 7.707 9.293l-1.414 1.414L12 16.414l5.707-5.707z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div> -->

                </div>
                <div class="page">
                    <div class="blank_page" >
                        <div class="blank_page_center">
                            <div class="outline_holder" id="outline_holder">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="js/script.js"></script>
        </div>
    <!-- </form> -->
    <form method="post" id="essay_submit">
        <input type="hidden" name="essay_Title" id="essay_Title">
        <input type="hidden" name="essay" id="essay">
    </form>
    <form method="post" id="Virtual_Assistant"> 
        <input type="hidden" name="thread_number" id="thread_number">
    </form>
</body>
</html>