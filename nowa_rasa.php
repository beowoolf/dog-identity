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
    $fci_stmt = $mysql->prepare("SELECT FCI.ID, FCI.NAZWA "
            . "FROM FCI "
            . "ORDER BY FCI.ID");
    $fci_stmt->bind_result($fci_id, $fci_name);
    if (!$fci_stmt) {
        die();
    }
    $fci_stmt->execute();
    
    if(isset($_GET["id"])) {
            echo "<H1>Edycja rasy:</H1><br>";
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            $mysql3 = dbConnect();        
            $stmt = $mysql3->prepare("SELECT RASA.NAZWA, RASA.FCI_ID "
                    . "FROM RASA "
                    . "WHERE RASA.ID=(?)");
            $stmt->bind_param("i", $id);
            $stmt->bind_result($name, $currentFci);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            $stmt->fetch();

        } else {
            echo "<H1>Nowa rasa:</H1><br>";
            $name = "";
            $currentFci = "";
        }
?>       
        <div class="form-style">
            <form action="wstawianie_nowej_rasy.php" method="POST">                  
                <label for="name"><span>Nazwa:</span><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></label><br />
                <label for="fci"><span>Grupa FCI:</span>
                        <select name="fci"> 
                        <?php while ($fci_stmt->fetch()) {                            
                            echo "<option value=\"$fci_id\" ";
                            if ($fci_id == $currentFci) {
                                echo "selected=\"selected\"";
                            }
                            echo ">$fci_id: $fci_name</option>";
                        } 
                        $fci_stmt->close();
                        $mysql->close() ?>
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

