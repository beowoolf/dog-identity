<?php
include('functions.php');

session_start();
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>

<?php include "header.php";        
    $mysql = dbConnect();
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
    $stmt = $mysql->prepare("SELECT ODDZIAL.ID, ODDZIAL.NAZWA, ODDZIAL.NUMER, ODDZIAL.TATUAZ, ODDZIAL.ADRES, ODDZIAL.TELEFON "
            . "FROM ODDZIAL "
            . "WHERE ODDZIAL.ID=(?)");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($id, $nazwa, $numer, $tatuaz, $adres, $telefon);
    if (!$stmt) {
        die();
    }
    $stmt->execute();
    if ($stmt->fetch()) {
        echo 'Oddział:<br>';
        echo 'ID: ' . $id . '<br>';
        echo 'Nazwa: ' . $nazwa . '<br>';
        echo 'Numer: ' . $numer . '<br>';
        echo 'Tatuaż: ' . $tatuaz . '<br>';
        echo 'Adres: ' . $adres . '<br>';
        echo 'Telefon: ' . $telefon . '<br>';
        echo "<a href=\"nowy_oddzial.php?id=$id\">edytuj</a>";
        echo '<hr>';
        showTableHodowla("WHERE ODDZIAL.ID = " . $id);
    } else {
        echo 'Nie znaleziono oddziału';
    }
    $stmt->close();
?>
    </body>
</html>
