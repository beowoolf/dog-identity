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

<?php include "header.php" ?> 
        Hello DogIdentity WOW<br />
        <?php echo 'Witaj użytkowniku ' . $_SESSION['user']; ?> <br />
        <a href="mioty.php">Mioty</a>
        <a href="hodowle.php">Hodowle</a>
        <a href="hodowcy.php">Hodowcy</a>
        <a href="oddzialy.php">Oddziały</a>
        <form method="POST">
            <input type="submit" name="logout" value="Wyloguj">
        </form>
<?php include "footer.php" ?> 
