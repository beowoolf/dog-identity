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
            $stmt = $mysql->prepare("SELECT UZYTKOWNICY.ID, UZYTKOWNICY.LOGIN "
                    . "FROM UZYTKOWNICY "
                    . "ORDER BY UZYTKOWNICY.LOGIN");
            $stmt->bind_result($id, $login);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            echo 'Użytkownicy:<br>';
            echo '<a href="nowy_uzytkownik.php">Dodaj użytkownika</a>';
            echo '<table class="data">';
            echo '<tr class="tableheader">';
            echo '<th>ID</th>';
            echo '<th>Login</th>';
            echo '</tr>';
            
            while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . primaryKeyLink('uzytkownik', $id) . "</td>";
                echo "<td>" . $login . "</td>";
                echo "</tr>\n";
            }
            echo "</table>\n";
            $stmt->close();
        
        ?>
    </body>
</html>
