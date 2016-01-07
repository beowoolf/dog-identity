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
            $stmt = $mysql->prepare("SELECT HODOWCA.ID, HODOWCA.IMIE, HODOWCA.NAZWISKO, HODOWCA.TELEFON, HODOWCA.ADRES "
                    . "FROM HODOWCA ");
            $stmt->bind_result($id, $imie, $nazwisko, $telefon, $adres);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            echo 'Hodowcy:<br>';
            echo '<a href="nowy_hodowca.php">Dodaj nowego hodowcę</a>';
            echo '<table class="data">';
            echo '<tr class="tableheader">';
            echo '<th>ID</th>';
            echo '<th>Imię</th>';
            echo '<th>Nazwisko</th>';
            echo '<th>Telefon</th>';
            echo '<th>Adres</th>';
            echo '</tr>';
            
            while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . primaryKeyLink('hodowca', $id) . "</td>";
                echo "<td>" . $imie . "</td>";
                echo "<td>" . $nazwisko . "</td>";
                echo "<td>" . $telefon . "</td>";
                echo "<td>" . $adres . "</td>";
                echo "</tr>\n";
            }
            echo "</table>\n";
            $stmt->close();
        
        ?>
<?php include "footer.php" ?> 
