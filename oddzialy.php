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
            $stmt = $mysql->prepare("SELECT ODDZIAL.ID, ODDZIAL.NAZWA, ODDZIAL.NUMER, ODDZIAL.TATUAZ, ODDZIAL.ADRES, ODDZIAL.TELEFON "
                    . "FROM ODDZIAL ");
            $stmt->bind_result($id, $nazwa, $numer, $tatuaz, $adres, $telefon);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            echo 'Oddziały:<br>';
            echo '<a href="nowy_oddzial.php">Dodaj nowy oddział</a>';
            echo '<table class="data">';
            echo '<tr class="tableheader">';
            echo '<th>ID</th>';
            echo '<th>Nazwa</th>';
            echo '<th>Numer</th>';
            echo '<th>Wzór tatuażu</th>';
            echo '<th>Adres</th>';
            echo '<th>Telefon</th>';
            echo '</tr>';
            
            while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $id . "</td>";
                echo "<td>" . $nazwa . "</td>";
                echo "<td>" . $numer . "</td>";
                echo "<td>" . $tatuaz . "</td>";
                echo "<td>" . $adres . "</td>";
                echo "<td>" . $telefon . "</td>";
                echo "</tr>\n";
            }
            echo "</table>\n";
            $stmt->close();
        
        ?>
<?php include "footer.php" ?> 
