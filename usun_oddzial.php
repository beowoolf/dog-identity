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
           
    $stmt = $mysql->prepare("SELECT HODOWLA.ID "
        . "FROM HODOWLA "
        . "WHERE HODOWLA.O_ID=(?)");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($id1);
    if (!$stmt) {
        die();
    }
    $stmt->execute();
            
    if ($stmt->fetch()) {
           
        $stmt->close();
        echo("Nie można usunąć oddziału, ponieważ istnieją przypisane do niego hodowle.</br>");
        echo("<a href=\"oddzial.php?id=$id\">Powrót</a>");
                
    } else {
                
        $stmt->close();
                
        $stmt = $mysql->prepare("SELECT ODDZIAL.ID, ODDZIAL.NAZWA FROM ODDZIAL WHERE ODDZIAL.ID=(?)");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id2, $nazwa);
        if (!$stmt) {
            die();
        }
        $stmt->execute();

        if ($stmt->fetch()) {
            echo('Czy na pewno chcesz usunąć następujący wpis?<ul><li>');
            echo 'Oddzial: ' . $id2 . ', ';
            echo 'Nazwa: ' . $nazwa . '</li></ul>';
            echo("<a href=\"usun_oddzial_zatwierdz.php?id=$id\">Usuń</a>");
        } else {
            echo('Nie znaleziono oddziału</br>');
            echo('<a href="oddzialy.php">Powrót do listy oddziałów</a>');
        }
        $stmt->close();
    }
?>    

<?php include "footer.php" ?> 