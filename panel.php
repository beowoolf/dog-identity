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
        <form method="POST">
            <input type="submit" name="logout" value="Wyloguj">
        </form>
<?php include "footer.php" ?> 
