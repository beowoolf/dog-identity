<?php
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
        showTableHodowla("");
         ?>
    </body>
</html>
