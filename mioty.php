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
            $stmt = $mysql->prepare("SELECT MIOT.ID, MIOT.URODZONY, MIOT.ZNAKOWANY, MIOT.POZYCJA, MIOT.H_ID, HODOWLA.NAZWA "
                    . "FROM MIOT "
                    . "JOIN HODOWLA ON HODOWLA.ID = MIOT.H_ID");
            $stmt->bind_result($id, $urodzony, $znakowany, $pozycja, $h_id, $hodowlaNazwa);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            echo 'Mioty:<br>';
            echo '<a href="nowy_miot.php">Dodaj nowy miot</a>';
            echo '<table class="data">';
            echo '<tr class="tableheader">';
            echo '<th>ID</th>';
            echo '<th>Data urodzenia</th>';
            echo '<th>Data znakowania</th>';
            echo '<th>Pozycja znakowania</th>';
            echo '<th>ID hodowli</th>';
            echo '</tr>';
            
            while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $id . "</td>";
                echo "<td>" . $urodzony . "</td>";
                echo "<td>" . $znakowany . "</td>";
                echo "<td>" . $pozycja . "</td>";
                echo '<td>' . foreignKeyLink('hodowla', $id, $hodowlaNazwa) . '</td>';
                echo "</tr>\n";
            }
            echo "</table>\n";
            $stmt->close();
        
        ?>
    </body>
</html>
