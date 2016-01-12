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
    $birthDate = $_POST["birthDate"];
    $markupDate = $_POST["markupDate"];
    $markupPosition = $_POST["markupPosition"];
    $breeding = $_POST["breeding"];
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $stmt = $mysql->prepare("UPDATE MIOT "
                . "SET URODZONY = ?, ZNAKOWANY = ?, POZYCJA = ?, H_ID = ? "
                . "WHERE ID = ?");
        $stmt->bind_param("ssssi", $birthDate, $markupDate, $markupPosition, $breeding, $id);
    } else {
        $stmt = $mysql->prepare("INSERT INTO MIOT (URODZONY, ZNAKOWANY, POZYCJA, H_ID) "
                    . "VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $birthDate, $markupDate, $markupPosition, $breeding);
    }
    if (!$stmt) {
        die();
    }
    $stmt->execute();
    $stmt->close();
    $mysql->close(); 
    if (isset($_POST["id"])) {
        echo '<p> Zmodyfikowano dane miotu </p>';
    } else {
        echo '<p> Miot został dodany </p>';
    }
?>        
        <a href="mioty.php">Powrót do listy miotów</a>
        <script>
            setTimeout(function () {
                window.location.href= 'mioty.php'; // the redirect goes here
            },5000); // 5 seconds
        </script>
<?php include "footer.php" ?> 

