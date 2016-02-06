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
    $name = $_POST["name"];
    $fci = $_POST["fci"];
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $stmt = $mysql->prepare("UPDATE RASA "
                . "SET NAZWA = ?, FCI_ID = ? "
                . "WHERE ID = ?");
        $stmt->bind_param("ssi", $name, $fci, $id);
    } else {
        $stmt = $mysql->prepare("INSERT INTO RASA (NAZWA, FCI_ID) "
                    . "VALUES (?, ?)");
        $stmt->bind_param("si", $name, $fci);
    }
    if (!$stmt) {
        die();
    }
    $stmt->execute();
    $stmt->close();
    $mysql->close();  
    if (isset($_POST["id"])) {
        echo '<p> Zmodyfikowano dane rasy </p>';
    } else {
        echo '<p> Rasa została dodana </p>';
    }
?>         
        <a href="rasy.php">Powrót do listy ras</a>
        <script>
            setTimeout(function () {
                window.location.href= 'rasy.php'; // the redirect goes here
            },5000); // 5 seconds
        </script>
<?php include "footer.php" ?> 

