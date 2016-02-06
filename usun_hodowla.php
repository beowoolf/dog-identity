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
           
    $stmt = $mysql->prepare("SELECT MIOT.ID "
        . "FROM MIOT "
        . "WHERE MIOT.H_ID=(?)");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($id1);
    if (!$stmt) {
        die();
    }
    $stmt->execute();
            
    if ($stmt->fetch()) {
           
        $stmt->close();
        echo("Nie można usunąć hodowli, ponieważ istnieją przypisane do niej mioty.</br>");
        echo("<a href=\"hodowla.php?id=$id\">Powrót</a>");
                
    } else {
                
        $stmt->close();
                
        $stmt = $mysql->prepare("SELECT HODOWLA.ID, HODOWLA.NAZWA FROM HODOWLA WHERE HODOWLA.ID=(?)");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($id2, $nazwa);
        if (!$stmt) {
            die();
        }
        $stmt->execute();

        if ($stmt->fetch()) {
            echo('Czy na pewno chcesz usunąć następujący wpis?<ul><li>');
            echo 'Hodowla: ' . $id2 . ', ';
            echo 'Nazwa: ' . $nazwa . '</li></ul>';
            echo("<a href=\"usun_hodowla_zatwierdz.php?id=$id\">Usuń</a>");
        } else {
            echo('Nie znaleziono hodowli</br>');
            echo('<a href="hodowle.php">Powrót do listy hodowli</a>');
        }
        $stmt->close();
    }
?>    

<?php include "footer.php" ?> 