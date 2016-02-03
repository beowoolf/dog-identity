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
    
        echo("Czy na pewno chcesz usunąć następujące elementy?");
        echo("<ul>");
        
            $mysql = dbConnect();
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            $stmt = $mysql->prepare("SELECT PIES.ID, PIES.IMIE, PIES.SUKA, PIES.OZNACZENIE "
                    . "FROM PIES "
                    . "WHERE PIES.ID=(?)");
            $stmt->bind_param("i", $id);
            $stmt->bind_result($id, $imie, $suka, $oznaczenie);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            
            if ($stmt->fetch()) {
                echo '<li>';
                echo 'Pies: ' . $id . ', ';
                echo 'Imię: ' . $imie . ', ';
                echo 'Płeć: ' . getSex($suka) . ', ';
                echo 'Oznaczenie: ' . $oznaczenie . ', ';
            } else {
                echo 'Nie znaleziono psa';
            }
            $stmt->close();
            
            echo("</ul>");
            echo("<a href=\"usun_pies_zatwierdz.php?id=$id\">Usuń</a>");
        ?>    

<?php include "footer.php" ?> 