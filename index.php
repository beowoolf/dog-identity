<?php

session_start();

if (!empty($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            echo 'Hello DogIdentity WOW<br>';
            echo 'Witaj użytkowniku ' . $_SESSION['user'];
        ?>
        <form method="POST">
            <input type="submit" name="logout" value="Wyloguj">
        </form>
    </body>
</html>
