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
            $stmt = $mysql->prepare("SELECT HODOWLA.ID, HODOWLA.NAZWA, HODOWCA.IMIE, HODOWCA.NAZWISKO, ODDZIAL.NAZWA "
                    . "FROM HODOWLA "
                    . "JOIN HODOWCA ON HODOWLA.H_ID = HODOWCA.ID JOIN ODDZIAL ON HODOWLA.O_ID = ODDZIAL.ID");
            $stmt->bind_result($id, $nazwaHodowli, $imieHodowcy, $nazwiskoHodowcy, $oddzial);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            echo 'Hodowle:<br>';
            echo '<a href="nowa_hodowla.php">Dodaj nową hodowlę</a>';
            echo '<table class="data">';
            echo '<tr class="tableheader">';
            echo '<th>ID</th>';
            echo '<th>Nazwa hodowli</th>';
            echo '<th>Imię hodowcy</th>';
            echo '<th>Nazwisko hodowcy</th>';
            echo '<th>Oddział</th>';          
            echo '</tr>';
            
            while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $id . "</td>";
                echo "<td>" . $nazwaHodowli . "</td>";
                echo "<td>" . $imieHodowcy . "</td>";
                echo "<td>" . $nazwiskoHodowcy . "</td>";
                echo "<td>" . $oddzial . "</td>";               
                echo "</tr>\n";
            }
            echo "</table>\n";
            $stmt->close();      
        ?>
<?php include "footer.php" ?> 

