<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include('functions.php');

session_start();
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>

<?php include "header.php";                  
    $mysql = dbConnect();
    $login = $_POST["login"];
    $newPass1 = $_POST["newPass1"];
    $newPass2 = $_POST["newPass2"];

    $newPass1 = hash('sha512', $newPass1);
    $newPass2 = hash('sha512', $newPass2);
    
    if ($newPass1 != $newPass2) {
        echo 'Błąd: wpisane hasła nie zgadzają się.';
        die();
    }
    
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $stmt = $mysql->prepare("UPDATE UZYTKOWNICY "
                . "SET LOGIN = ?, HASLO = ? "
                . "WHERE ID = ?");
        $stmt->bind_param("ssi", $login, $newPass1, $id);
    } else {
        $stmt = $mysql->prepare("INSERT INTO UZYTKOWNICY (LOGIN, HASLO) "
                    . "VALUES (?, ?)");
        $stmt->bind_param("ss", $login, $newPass1);
    }
    if (!$stmt) {
        die();
    }
    $stmt->execute();
    $stmt->close();
    $mysql->close();  
    if (isset($_POST["id"])) {
        echo '<p> Zmodyfikowano dane </p>';
    } else {
        echo '<p> Użytkownik został dodany </p>';
    }
?>         
        <a href="uzytkownicy.php">Powrót do listy użytkowników</a>
        <script>
            setTimeout(function () {
                window.location.href= 'uzytkownicy.php'; // the redirect goes here
            },5000); // 5 seconds
        </script>
<?php include "footer.php" ?> 

