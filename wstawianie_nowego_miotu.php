<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include('functions.php');

session_start();
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title></title>
    </head>
    <body>
        <?php           
            $mysql = dbConnect();
            $birthDate = $_POST["birthDate"];
            $markupDate = $_POST["markupDate"];
            $markupPosition = $_POST["markupPosition"];
            $breeding = $_POST["breeding"];
            $stmt = $mysql->prepare("INSERT INTO MIOT (URODZONY, ZNAKOWANY, POZYCJA, H_ID) "
                        . "VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $birthDate, $markupDate, $markupPosition, $breeding);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            $stmt->close();
            $mysql->close();          
        ?> 
        <p> Miot został dodany </p>
    </body>
</html>

