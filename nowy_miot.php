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
        <H1>Nowy miot:</H1><br>
        <div class="form-style">
            <form action="wstawianie_nowego_miotu.php" method="POST">                  
                <label for="birthDate"><span>Data urodzenia:</span><input type="text" name="birthDate" id="birthDate"></label>                
                <label for="markupDate"><span>Data znakowania:</span><input type="text" name="markupDate" id="markupDate"></label>                
                <label for="markupPosition"><span>Pozycja znakowania:</span><input type="text" name="markupPosition"></label>              
                <label for="breeding"><span>Hodowla:</span> 
                    <select name="breeding"> 
                        <?php while ($stmt->fetch()) {
                            echo "<option value=\"$id\">$nazwa</option>";
                        } 
                        $stmt->close(); ?>
                    </select>
                </label>
                <label><span>&nbsp;</span><input type="submit" value="Dodaj"></label>                                   
            </form>
        </div>
        
<?php include "footer.php" ?> 
