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
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            $stmt = $mysql->prepare("SELECT hodowla.NAZWA, hodowla.O_ID, hodowla.H_ID, hodowca.nazwisko "
                    . "FROM hodowla "
                    . "JOIN hodowca ON hodowla.h_id = hodowca.id "
                    . "WHERE hodowla.id=(?)");
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
    </body>
</html>
