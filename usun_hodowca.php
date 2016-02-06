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
        . "WHERE HODOWLA.H_ID=(?)");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($id1);
    if (!$stmt) {
        die();
    }
    $stmt->execute();
            
    if ($stmt->fetch()) {
           
        $stmt->close();
        echo("Nie można usunąć hodowcy, ponieważ istnieją przypisane do niego hodowle.</br>");
        echo("<a href=\"hodowca.php?id=$id\">Powrót</a>");
                
    } else {
                
        $stmt->close();
                
        $stmt = $mysql->prepare("SELECT HODOWCA.ID, HODOWCA.IMIE, HODOWCA.NAZWISKO FROM HODOWCA WHERE HODOWCA.ID=(?)");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id2, $imie, $nazwisko);
        if (!$stmt) {
            die();
        }
        $stmt->execute();

        if ($stmt->fetch()) {
            echo('Czy na pewno chcesz usunąć następujący wpis?<ul><li>');
            echo 'Hodowca: ' . $id2 . ', ';
            echo 'Imię i nazwisko: ' . $imie . ' ' . $nazwisko . '</li></ul>';
            echo("<a href=\"usun_hodowca_zatwierdz.php?id=$id\">Usuń</a>");
        } else {
            echo('Nie znaleziono hodowcy</br>');
            echo('<a href="hodowcy.php">Powrót do listy hodowców</a>');
        }
        $stmt->close();
    }
?>    

<?php include "footer.php" ?> 