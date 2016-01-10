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

<?php include "header.php" ?> 
        <?php           
            $mysql = dbConnect();
            $name = $_POST["name"];
            $surname = $_POST["surname"];
            $address = $_POST["address"];
            $phone_number = $_POST["phone_number"];
            $stmt = $mysql->prepare("INSERT INTO HODOWCA (IMIE, NAZWISKO, ADRES, TELEFON) "
                        . "VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $surname, $address, $phone_number);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            $stmt->close();
            $mysql->close();          
        ?> 
        <p> Hodowca został dodany </p>
        <a href="hodowcy.php">Powrót do listy hodowli</a>
        <script>
            setTimeout(function () {
                window.location.href= 'hodowcy.php'; // the redirect goes here
            },5000); // 5 seconds
        </script>
<?php include "footer.php" ?> 

