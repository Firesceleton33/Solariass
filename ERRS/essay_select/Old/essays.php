<?php
// Connect to your SQL server and retrieve essay data
$servername = "sql301.infinityfree.com";
$username = "if0_34713213";
$password = "khtku3X9hi";

$conn = new mysqli($servername, $username, $password, 'if0_34713213_Essays');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sqlStatement = "SELECT essay_id, title FROM essays";
$result = $conn->query($sqlStatement);

$essays = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $essays[] = $row;
    }
}

$conn->close();
$jsonString = json_encode($essays);
echo $jsonString;
?>
