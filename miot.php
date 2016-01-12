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
            $stmt = $mysql->prepare("SELECT MIOT.ID, MIOT.URODZONY, MIOT.ZNAKOWANY, MIOT.POZYCJA, MIOT.H_ID, HODOWLA.NAZWA "
                    . "FROM MIOT "
                    . "JOIN HODOWLA ON HODOWLA.ID = MIOT.H_ID "
                    . "WHERE MIOT.ID=(?)");
            $stmt->bind_param("i", $id);
            $stmt->bind_result($id, $urodzony, $znakowany, $pozycja, $h_id, $hodowlaNazwa);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            if ($stmt->fetch()) {
                echo 'Miot:<br>';
                echo 'ID: ' . $id . '<br>';
                echo 'Urodzony: ' . $urodzony . '<br>';
                echo 'Znakowany: ' . $znakowany . '<br>';
                echo 'Pozycja: ' . $pozycja . '<br>';
                echo 'Hodowla: ' . foreignKeyLink('hodowla', $h_id, $hodowlaNazwa) . '<br>';
                echo "<a href=\"nowy_miot.php?id=$id\">edytuj<a>";
                echo '<hr>';
                showTablePies("WHERE PIES.M_ID = " . $id);
            } else {
                echo 'Nie znaleziono miotu';
            }
            $stmt->close();
        ?>
    </body>
</html>
