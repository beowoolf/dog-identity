<?php
include('functions.php');

session_start();
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>

<?php include "header.php" ?> 
        <?php
            $mysql = dbConnect();
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            $stmt = $mysql->prepare("SELECT HODOWCA.ID, HODOWCA.IMIE, HODOWCA.NAZWISKO, HODOWCA.TELEFON, HODOWCA.ADRES "
                    . "FROM HODOWCA "
                    . "WHERE HODOWCA.ID=(?)");
            $stmt->bind_param("i", $id);
            $stmt->bind_result($id, $imie, $nazwisko, $telefon, $adres);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            if ($stmt->fetch()) {
                echo 'Hodowca:<br>';
                echo 'ID: ' . $id . '<br>';
                echo 'Imię: ' . $imie . '<br>';
                echo 'Nazwisko: ' . $nazwisko . '<br>';
                echo 'Telefon: ' . $telefon . '<br>';
                echo 'Adres: ' . $adres . '<br>';
                echo "<a href=\"nowy_hodowca.php?id=$id\">edytuj</a> \ ";
                echo "<a href=\"usun_hodowca.php?id=$id\">usuń</a>";
                echo '<hr>';
                showTableHodowla("WHERE HODOWLA.H_ID = " . $id);
            } else {
                echo 'Nie znaleziono hodowcy';
            }
            $stmt->close();
        ?>
    </body>
</html>
