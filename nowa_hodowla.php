<?php
include('functions.php');

session_start();
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>

<?php include "header.php";
        $mysql = dbConnect();
        $breeder_stmt = $mysql->prepare("SELECT HODOWCA.ID, HODOWCA.IMIE, HODOWCA.NAZWISKO "
                . "FROM HODOWCA");
        $breeder_stmt->bind_result($breeder_id, $breeder_name, $breeder_surname);
        if (!$breeder_stmt) {
            die();
        }
        $breeder_stmt->execute();
        
        $mysql2 = dbConnect();
        $division_stmt = $mysql2->prepare("SELECT ODDZIAL.ID, ODDZIAL.NAZWA "
                . "FROM ODDZIAL");
        $division_stmt->bind_result($division_id, $division_name);
        if (!$division_stmt) {
            die();
        }
        $division_stmt->execute();
        
        if(isset($_GET["id"])) {
            echo "<H1>Edycja hodowli:</H1><br>";
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            $mysql3 = dbConnect();        
            $stmt = $mysql3->prepare("SELECT HODOWLA.NAZWA, HODOWLA.H_ID, HODOWLA.O_ID "
                    . "FROM HODOWLA "
                    . "WHERE HODOWLA.ID=(?)");
            $stmt->bind_param("i", $id);
            $stmt->bind_result($name, $current_breeder_id, $current_division_id);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            $stmt->fetch();
            $stmt->close();
            $mysql3->close();

        } else {
            echo "<H1>Nowa hodowla:</H1><br>";
            $name = "";
            $current_breeder_id = 0;
            $current_division_id = 0;
        }
            
        ?>       
        <div class="form-style">
            <form action="wstawianie_nowej_hodowli.php" method="POST">                  
                <label for="name"><span>Nazwa:</span><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></label><br />
                <label for="breeder"><span>Hodowca:</span>
                    <select name="breeder">
                        <?php while ($breeder_stmt->fetch()) {
                            echo "<option value=\"$breeder_id\" ";
                            if ($breeder_id == $current_breeder_id) {
                                echo "selected=\"selected\"";
                            }
                            echo ">$breeder_name $breeder_surname</option>";
                        } 
                        $breeder_stmt->close(); ?>
                    </select>
                </label><br />
                <label for="division"><span>Oddział:</span> 
                    <select name="division">
                        <?php while ($division_stmt->fetch()) {
                            echo "<option value=\"$division_id\" ";
                            if ($division_id == $current_division_id) {
                                echo "selected=\"selected\"";
                            }
                            echo ">$division_name</option>";
                        } 
                        $division_stmt->close();
                        $mysql->close();
                        $mysql->close(); ?>
                    </select>
                </label><br />
                <?php
                    if (isset($_GET["id"])) {
                        echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />";
                    }
                ?>
                <label><span>&nbsp;</span><input type="submit" value="Zapisz"></label>                                   
            </form>
        </div>
<?php include "footer.php" ?> 

