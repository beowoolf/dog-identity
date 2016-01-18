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
    $stmt = $mysql->prepare("SELECT HODOWLA.ID, HODOWLA.NAZWA "
            . "FROM HODOWLA");
    $stmt->bind_result($id, $breeding_name);
    if (!$stmt) {
        die();
    }
    $stmt->execute();
    if(isset($_GET["id"])) {
        echo "<H1>Edycja hodowcy:</H1><br>";
        $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
        $mysql = dbConnect();        
        $stmt = $mysql->prepare("SELECT MIOT.URODZONY, MIOT.ZAKOWANY, MIOT.POZYCJA, MIOT.H_ID "
                . "FROM MIOT "
                . "WHERE MIOT.ID=(?)");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($birthDate, $markupDate, $markupPosition, $breeding);
        if (!$stmt) {
            die();
        }
        $stmt->execute();
        $stmt->fetch();
        
    } else {
        $birthDate = "";
        $markupDate = "";
        $markupPosition = "";
        $breeding = "";
        echo '<H1>Nowy miot:</H1><br>';
    }
?>
        <style type="text/css"> @import url("//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css")</style>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>  
        <script type="text/javascript" src="datepicker-pl.js"></script>
        <script>
            $.datepicker.setDefaults(
            $.extend(
                {},
                $.datepicker.regional["pl"],  
                { dateFormat: "yy-mm-dd" } 
            )
          );
            $(function() {
              $( "#birthDate" ).datepicker();
	      $( "#markupDate" ).datepicker();              
            });
        </script>
        
        <div class="form-style">
            <form action="wstawianie_nowego_miotu.php" method="POST">                  
                <label for="birthDate"><span>Data urodzenia:</span><input type="text" name="birthDate" id="birthDate" value="<?php echo htmlspecialchars($birthDate); ?>"></label><br />
                <label for="markupDate"><span>Data znakowania:</span><input type="text" name="markupDate" id="markupDate" value="<?php echo htmlspecialchars($markupDate); ?>"></label><br />
                <label for="markupPosition"><span>Pozycja znakowania:</span><input type="text" name="markupPosition" value="<?php echo htmlspecialchars($markupPosition); ?>"></label><br />
                <label for="breeding"><span>Hodowla:</span> 
                    <select name="breeding"> 
                        <?php while ($stmt->fetch()) {
                            echo "<option value=\"$id\"";
                            if ($breeding_name == $breeding) {
                                echo "selected=\"selected\"";
                            }
                            echo ">$breeding_name</option>";
                        } 
                        $stmt->close(); ?>
                    </select>
                </label><br />
                <?php
                    if (isset($_GET["id"])) {
                        echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />";
                    }
                ?>
                <label><span>&nbsp;</span><input type="submit" value="Dodaj"></label>                                   
            </form>
        </div>
        
<?php include "footer.php" ?> 
