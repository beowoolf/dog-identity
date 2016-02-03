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
    
        echo("Czy na pewno chcesz usunąć następujące elementy?");
        echo("<ul>");
        
            $mysql = dbConnect();
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            $stmt = $mysql->prepare("DELETE FROM PIES WHERE PIES.ID=(?)");
            $stmt->bind_param("i", $id);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            $stmt->close();

            echo("Usunięto dane z bazy.</br>");
        ?>    

        <a href="psy.php">Powrót do listy psów</a>
        <script>
            setTimeout(function () {
                window.location.href= 'psy.php'; // the redirect goes here
            },5000); // 5 seconds
        </script>
        
<?php include "footer.php" ?> 