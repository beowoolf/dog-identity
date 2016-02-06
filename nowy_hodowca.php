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
        echo "<H1>Edycja hodowcy:</H1><br>";
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
        $mysql = dbConnect();        
        $stmt = $mysql->prepare("SELECT HODOWCA.IMIE, HODOWCA.NAZWISKO, HODOWCA.TELEFON, HODOWCA.ADRES "
                . "FROM HODOWCA "
                . "WHERE HODOWCA.ID=(?)");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($name, $surname, $phone_number, $address);
        if (!$stmt) {
            die();
        }
        $stmt->execute();
        $stmt->fetch();
        
    } else {
        echo '<H1>Nowy hodowca:</H1><br>';
        $name = "";
        $surname = "";
        $address = "";
        $phone_number = "";
    }
?> 
           
    <div class="form-style">
        <form action="wstawianie_nowego_hodowcy.php" method="POST"> 
            <label for="name"><span>Imię:</span><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></label><br />
            <label for="surname"><span>Nazwisko:</span><input type="text" name="surname" value="<?php echo htmlspecialchars($surname); ?>"></label><br />
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

