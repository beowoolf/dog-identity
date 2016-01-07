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
            $stmt = $mysql->prepare("SELECT HODOWLA.NAZWA, HODOWLA.O_ID, HODOWLA.H_ID, HODOWCA.NAZWISKO "
                    . "FROM HODOWLA "
                    . "JOIN HODOWCA ON HODOWLA.H_ID = HODOWCA.ID "
                    . "WHERE HODOWLA.ID=(?)");
            $stmt->bind_param("i", $id);
            $stmt->bind_result($nazwa, $o_id, $h_id, $hodowcaNazwisko);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            if ($stmt->fetch()) {
                echo 'Hodowla:<br>';
                echo 'ID: ' . $id . '<br>';
                echo 'Nazwa: ' . $nazwa . '<br>';
                echo 'Oddział: ' . $o_id . '<br>';
                echo 'Hodowca: ' . foreignKeyLink('hodowca', $id, $hodowcaNazwisko) . '<br>';
            } else {
                echo 'Nie znaleziono hodowli';
            }
            $stmt->close();
        ?>

<?php include "footer.php" ?>  
