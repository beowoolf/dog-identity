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
            $stmt = $mysql->prepare("DELETE FROM RASA WHERE RASA.ID=(?)");
            $stmt->bind_param("i", $id);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            
            if($stmt->affected_rows > 0) {
                $stmt->close();
                echo("Usunięto dane z bazy.</br>");
            } else {
                $stmt->close();
                header("Location: usun_rasa.php?id=$id");                
                die();
            }
        ?>    

        <a href="rasy.php">Powrót do listy ras</a>
        <script>
            setTimeout(function () {
                window.location.href = 'rasy.php'; // the redirect goes here
            },5000); // 5 seconds
        </script>
        
<?php include "footer.php" ?> 