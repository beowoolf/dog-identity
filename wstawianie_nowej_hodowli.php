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
    $breeder = $_POST["breeder"];
    $division = $_POST["division"];  
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $stmt = $mysql->prepare("UPDATE HODOWLA "
                . "SET NAZWA = ?, H_ID = ?, O_ID = ? "
                . "WHERE ID = ?");
        $stmt->bind_param("sssi", $name, $breeder, $division, $id);
    } else {
        $stmt = $mysql->prepare("INSERT INTO HODOWLA (NAZWA, H_ID, O_ID) "
                    . "VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $name, $breeder, $division);
    }
    if (!$stmt) {
        die();
    }
    $stmt->execute();
    $stmt->close();
    $mysql->close();  
    if (isset($_POST["id"])) {
        echo '<p> Zmodyfikowano dane hodowli </p>';
    } else {
        echo '<p> Hodowla została dodana </p>';
    }
?>         
        <a href="hodowle.php">Powrót do listy hodowli</a>
        <script>
            setTimeout(function () {
                window.location.href= 'hodowle.php'; // the redirect goes here
            },5000); // 5 seconds
        </script>
<?php include "footer.php" ?> 

