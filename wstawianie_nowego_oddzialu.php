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
    $number = $_POST["number"];
    $tatoo = $_POST["tatoo"];
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $stmt = $mysql->prepare("UPDATE ODDZIAL "
                . "SET NAZWA = ?, NUMER = ?, TATUAZ = ?, ADRES = ?, TELEFON = ? "
                . "WHERE ID = ?");
        $stmt->bind_param("sssssi", $name, $number, $tatoo, $address, $phone_number, $id);
    } else {
        $stmt = $mysql->prepare("INSERT INTO ODDZIAL (NAZWA, NUMER, TATUAZ, ADRES, TELEFON) "
                    . "VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $number, $tatoo, $address, $phone_number);
    }
    if (!$stmt) {
        die();
    }
    $stmt->execute();
    $stmt->close();
    $mysql->close();
    if (isset($_POST["id"])) {
        echo '<p> Zmodyfikowano dane oddziału </p>';
    } else {
        echo '<p> Oddział został dodany </p>';
    }
?>         
        <a href="oddzialy.php">Powrót do listy oddziałów</a>
        <script>
            setTimeout(function () {
                window.location.href= 'oddzialy.php'; // the redirect goes here
            },5000); // 5 seconds
        </script>
<?php include "footer.php" ?> 

