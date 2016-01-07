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
            $stmt = $mysql->prepare("SELECT RASA.ID, RASA.NAZWA, RASA.FCI_ID, FCI.NAZWA "
                    . "FROM RASA "
                    . "JOIN FCI ON FCI.ID = RASA.FCI_ID");
            $stmt->bind_result($id, $nazwa, $fci_id, $fciNazwa);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            echo 'Rasy:<br>';
            echo '<table class="data">';
            echo '<tr class="tableheader">';
            echo '<th>ID</th>';
            echo '<th>Nazwa</th>';
            echo '<th>FCI</th>';
            echo '</tr>';
            
            while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $id . "</td>";
                echo "<td>" . $nazwa . "</td>";
                echo '<td>' . $fciNazwa . '</td>';
                echo "</tr>\n";
            }
            echo "</table>\n";
            $stmt->close();
        
        ?>
    </body>
</html>
