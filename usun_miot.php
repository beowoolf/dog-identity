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
           
    $stmt = $mysql->prepare("SELECT PIES.ID, PIES.IMIE, PIES.SUKA, PIES.OZNACZENIE "
        . "FROM PIES "
        . "WHERE PIES.M_ID=(?)");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($id1, $imie, $suka, $oznaczenie);
    if (!$stmt) {
        die();
    }
    $stmt->execute();
            
    if ($stmt->fetch()) {
           
        $stmt->close();
        echo("Nie można usunąć miotu, ponieważ istnieją przypisane do niego psy.</br>");
        echo("<a href=\"miot.php?id=$id\">Powrót</a>");
                
    } else {
                
        $stmt->close();
                
        $stmt = $mysql->prepare("SELECT MIOT.ID, MIOT.URODZONY FROM MIOT WHERE MIOT.ID=(?)");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id2, $urodzony);
        if (!$stmt) {
            die();
        }
        $stmt->execute();
                
        echo("Czy na pewno chcesz usunąć następujący wpis?");
        echo("<ul>");

        if ($stmt->fetch()) {
            echo '<li>';
            echo 'Rasa: ' . $id2 . ', ';
            echo 'Nazwa: ' . $urodzony . '</li>';
            echo("</ul>");
            echo("<a href=\"usun_miot_zatwierdz.php?id=$id\">Usuń</a>");
        } else {
            echo('Nie znaleziono rasy</br>');
            echo('<a href="mioty.php">Powrót do listy miotów</a>');
        }
        $stmt->close();
    }
?>    

<?php include "footer.php" ?> 