<?php
include('functions.php');

session_start();
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<?php include "header.php" ?> 
        <?php
            $mysql = dbConnect();
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            $stmt = $mysql->prepare("SELECT RASA.ID, RASA.NAZWA, RASA.FCI_ID, FCI.NAZWA "
                    . "FROM RASA "
                    . "JOIN FCI ON FCI.ID = RASA.FCI_ID "
                    . "WHERE RASA.ID=(?)");
            $stmt->bind_param("i", $id);
            $stmt->bind_result($id, $nazwa, $fci_id, $fciNazwa);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            if ($stmt->fetch()) {
                echo 'Rasa:<br>';
                echo 'ID: ' . $id . '<br>';
                echo 'Nazwa: ' . $nazwa . '<br>';
                echo 'FCI: ' . $fciNazwa . '<br>';
                echo '<hr>';
                showTablePies("WHERE PIES.R_ID = " . $id);
            } else {
                echo 'Nie znaleziono rasy';
            }
            $stmt->close();
        ?>
    </body>
</html>
