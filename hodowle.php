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
        showTableHodowla("");
         ?>
<?php include "footer.php" ?> 
