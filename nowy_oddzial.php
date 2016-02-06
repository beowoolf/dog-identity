<?php
include('functions.php');

session_start();
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>

<?php include "header.php";
    if(isset($_GET["id"])) {
        echo "<H1>Edycja oddziału:</H1><br>";
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
        $mysql3 = dbConnect();        
        $stmt = $mysql3->prepare("SELECT ODDZIAL.NAZWA, ODDZIAL.NUMER, ODDZIAL.TATUAZ, ODDZIAL.ADRES, ODDZIAL.TELEFON "
                . "FROM ODDZIAL "
                . "WHERE ODDZIAL.ID=(?)");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($name, $number, $tatoo, $address, $phone_number);
        if (!$stmt) {
            die();
        }
        $stmt->execute();
        $stmt->fetch();

    } else {
        echo "<H1>Nowy oddział:</H1><br>";
        $name = "";
        $number = "";
        $tatoo = "";
        $address = "";
        $phone_number = "";
    }
?>      
    <div class="form-style">
        <form action="wstawianie_nowego_oddzialu.php" method="POST">                  
            <label for="name"><span>Nazwa:</span><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></label><br />
            <label for="number"><span>Numer:</span><input type="text" name="number" value="<?php echo htmlspecialchars($number); ?>"></label><br />
            <label for="tatoo"><span>Tautuaż:</span><input type="text" name="tatoo" value="<?php echo htmlspecialchars($tatoo); ?>"></label><br />
            <label for="address"><span>Adres:</span><input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>"></label><br />
            <label for="phone_number"><span>Telefon:</span><input type="text" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>"></label><br />
            <?php
                if (isset($_GET["id"])) {
                    echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />";
                }
            ?>
            <label><span>&nbsp;</span><input type="submit" value="Zapisz"></label>                                   
        </form>
    </div>
<?php include "footer.php" ?> 

