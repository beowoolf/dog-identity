<?php
include('functions.php');

session_start();
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<?php include "header.php" ?> 
        <?php
            $mysql = dbConnect();
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            $stmt = $mysql->prepare("SELECT UZYTKOWNICY.ID, UZYTKOWNICY.LOGIN "
                    . "FROM UZYTKOWNICY "
                    . "WHERE UZYTKOWNICY.ID=(?)");
            $stmt->bind_param("i", $id);
            $stmt->bind_result($id2, $login);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            if ($stmt->fetch()) {
                echo 'Użytkownik:<br>';
                echo 'ID: ' . $id . '<br>';
                echo 'Login: ' . $login . '<br>';
                echo "<a href=\"nowy_uzytkownik.php?id=$id\">edytuj</a> / ";
                echo "<a href=\"usun_uzytkownik.php?id=$id\">usuń</a>";
                echo '<hr>';
            } else {
                echo 'Nie znaleziono użytkownika';
            }
            $stmt->close();
        ?>
    </body>
</html>
