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
                
    $stmt = $mysql->prepare("SELECT UZYTKOWNICY.ID, UZYTKOWNICY.LOGIN "
            . "FROM UZYTKOWNICY "
            . "WHERE UZYTKOWNICY.ID=(?)");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($id2, $login);
    if (!$stmt) {
        die();
    }
    $stmt->execute();

    if ($stmt->fetch()) {
        echo("Czy na pewno chcesz usunąć następujący wpis?");
        echo("<ul>");
        echo '<li>';
        echo 'Login: ' . $login . '</li>';
        echo("</ul>");
        echo("<a href=\"usun_uzytkownik_zatwierdz.php?id=$id\">Usuń</a>");
    } else {
        echo('Nie znaleziono użytkownika</br>');
        echo('<a href="uzytkownicy.php">Powrót do listy użytkowników</a>');
    }
    $stmt->close();
?>    

<?php include "footer.php" ?> 