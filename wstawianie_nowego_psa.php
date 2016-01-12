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
            $mother = $_POST["mother"];
            $father = $_POST["father"];
            $markup = $_POST["markup"];
            $breed = $_POST["breed"];
            $brood = $_POST["brood"];
            $gender = $_POST["gender"];
            if (isset($_POST["id"])) {
                $id = $_POST["id"];
                $stmt = $mysql->prepare("UPDATE PIES "
                        . "SET IMIE = ?, MATKA = ?, OJCIEC = ?, OZNACZENIE = ?, R_ID = ?, M_ID = ?, SUKA = ? "
                        . "WHERE ID = ?");
                $stmt->bind_param("ssssiiii", $name, $mother, $father, $markup, $breed, $brood, $gender, $id);
            } else {
                $stmt = $mysql->prepare("INSERT INTO PIES (IMIE, MATKA, OJCIEC, OZNACZENIE, R_ID, M_ID, SUKA) "
                            . "VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssiii", $name, $mother, $father, $markup, $breed, $brood, $gender);
            }
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            $stmt->close();
            $mysql->close(); 
            if (isset($_POST["id"])) {
                echo '<p> Zmodyfikowano dane psa </p>';
            } else {
                echo '<p> Pies został dodany </p>';
            }
        ?>
        <a href="psy.php">Powrót do listy psów</a>
        <script>
            setTimeout(function () {
                window.location.href= 'psy.php'; // the redirect goes here
            },5000); // 5 seconds
        </script>
<?php include "footer.php" ?> 

