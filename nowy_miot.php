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
            $stmt = $mysql->prepare("SELECT HODOWLA.ID, HODOWLA.NAZWA "
                    . "FROM HODOWLA");
            $stmt->bind_result($id, $nazwa);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
        ?>
        Nowy miot:<br>
        <form action="wstawianie_nowego_miotu.php" method="POST">
            <fieldset>
                <label>Data urodzenia:</label> <input type="text" name="birthDate"><br>
                <label>Data znakowania:</label> <input type="text" name="markupDate"><br>
                <label>Pozycja znakowania</label> <input type ="text" name="markupPosition"></br>
                <label>Hodowla:</label> 
                <select name="breeding"> 
                    <?php while ($stmt->fetch()) {
                        echo "<option value=\"$id\">$nazwa</option>";
                    } 
                    $stmt->close(); ?>
                </select> <br>
                <input type="submit" value="Dodaj">
            </fieldset>
        </form>
<?php include "footer.php" ?> 

