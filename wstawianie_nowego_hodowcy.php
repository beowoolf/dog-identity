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
    $surname = $_POST["surname"];
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $stmt = $mysql->prepare("UPDATE HODOWCA "
                . "SET IMIE = ?, NAZWISKO = ?, ADRES = ?, TELEFON= ? "
                . "WHERE ID = ?");
        $stmt->bind_param("ssssi", $name, $surname, $address, $phone_number, $id);
    } else {
        $stmt = $mysql->prepare("INSERT INTO HODOWCA (IMIE, NAZWISKO, ADRES, TELEFON) "
                    . "VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $surname, $address, $phone_number);
    }
    if (!$stmt) {
        die();
    }
    $stmt->execute();
    $stmt->close();
    $mysql->close(); 
    if (isset($_POST["id"])) {
        echo '<p> Zmodyfikowano dane hodowcy </p>';
    } else {
        echo '<p> Hodowca został dodany </p>';
    }
?>     
    <a href="hodowcy.php">Powrót do listy hodowców</a>
    <script>
        setTimeout(function () {
            window.location.href= 'hodowcy.php'; // the redirect goes here
        },5000); // 5 seconds
    </script>
<?php include "footer.php" ?> 

