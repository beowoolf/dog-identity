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
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>DogIdentity</title>
    </head>
    <body>       
        Hello DogIdentity WOW<br />
        <?php echo 'Witaj użytkowniku ' . $_SESSION['user']; ?> <br />
        <a href="mioty.php">Mioty</a>
        <a href="hodowle.php">Hodowle</a>
        <a href="hodowcy.php">Hodowcy</a>
        <a href="oddzialy.php">Oddziały</a>
        <form method="POST">
            <input type="submit" name="logout" value="Wyloguj">
        </form>
    </body>
</html>
