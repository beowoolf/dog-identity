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
           
    $stmt = $mysql->prepare("SELECT PIES.ID "
        . "FROM PIES "
        . "WHERE PIES.R_ID=(?)");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($id1);
    if (!$stmt) {
        die();
    }
    $stmt->execute();
            
    if ($stmt->fetch()) {
           
        $stmt->close();
        echo("Nie można usunąć rasy, ponieważ istnieją przypisane do niej psy.</br>");
        echo("<a href=\"rasa.php?id=$id\">Powrót</a>");
                
    } else {
                
        $stmt->close();
                
        $stmt = $mysql->prepare("SELECT RASA.ID, RASA.NAZWA FROM RASA WHERE RASA.ID=(?)");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id2, $nazwa);
        if (!$stmt) {
            die();
        }
        $stmt->execute();

        if ($stmt->fetch()) {
            echo("Czy na pewno chcesz usunąć następujący wpis?");
            echo("<ul>");
            echo '<li>';
            echo 'Rasa: ' . $id2 . ', ';
            echo 'Nazwa: ' . $nazwa . '</li>';
            echo("</ul>");
            echo("<a href=\"usun_rasa_zatwierdz.php?id=$id\">Usuń</a>");
        } else {
            echo('Nie znaleziono rasy</br>');
            echo('<a href="rasy.php">Powrót do listy ras</a>');
        }
        $stmt->close();
    }
?>    

<?php include "footer.php" ?> 