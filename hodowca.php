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
                echo '<hr>';
                showTableHodowla("WHERE HODOWLA.H_ID = " . $id);
            } else {
                echo 'Nie znaleziono hodowcy';
            }
            $stmt->close();
        ?>
    </body>
</html>
