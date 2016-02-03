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
            $stmt = $mysql->prepare("SELECT PIES.ID, PIES.IMIE, PIES.SUKA, PIES.OZNACZENIE, PIES.OJCIEC, PIES.MATKA, PIES.M_ID, PIES.R_ID, "
            . "MIOT.URODZONY, RASA.NAZWA "
                    . "FROM PIES "
                    . "JOIN MIOT ON MIOT.ID = PIES.M_ID "
                    . "JOIN RASA ON RASA.ID = PIES.R_ID "
                    . "WHERE PIES.ID=(?)");
            $stmt->bind_param("i", $id);
            $stmt->bind_result($id, $imie, $suka, $oznaczenie, $ojciec, $matka, $m_id, $r_id, $urodzony, $rasa);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            if ($stmt->fetch()) {
                echo 'Pies:<br>';
                echo 'ID: ' . $id . '<br>';
                echo 'Imię: ' . $imie . '<br>';
                echo 'Płeć: ' . getSex($suka) . '<br>';
                echo 'Oznaczenie: ' . $oznaczenie . '<br>';
                echo 'Ojciec: ' . $ojciec . '<br>';
                echo 'Matka: ' . $matka . '<br>';
                echo 'ID miotu / data urodzenia:' . foreignKeyLink('miot', $m_id, $urodzony) . '<br>';
                echo 'Rasa: ' .foreignKeyLink('rasa', $r_id, $rasa) . '<br>';
                echo "<a href=\"nowy_pies.php?id=$id\">edytuj</a> / ";
                echo "<a href=\"usun_pies.php?id=$id\">usuń</a>";
            } else {
                echo 'Nie znaleziono psa';
            }
            $stmt->close();
        ?>
<?php include "footer.php" ?> 
