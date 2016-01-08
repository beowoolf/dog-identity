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
            $breeder_stmt = $mysql->prepare("SELECT HODOWCA.ID, HODOWCA.IMIE, HODOWCA.NAZWISKO "
                    . "FROM HODOWCA");
            $breeder_stmt->bind_result($breeder_id, $breeder_name, $breeder_surname);
            if (!$breeder_stmt) {
                die();
            }
            $breeder_stmt->execute();
            $mysql->close();
            $mysql = dbConnect();
            $division_stmt = $mysql->prepare("SELECT ODDZIAL.ID, ODDZIAL.NAZWA "
                    . "FROM ODDZIAL");
            $division_stmt->bind_result($division_id, $division_name);
            if (!$division_stmt) {
                die();
            }
            $division_stmt->execute();
        ?>
        <H1>Nowa hodowla:</H1><br>
        <div class="form-style">
            <form action="wstawianie_nowej_hodowli.php" method="POST">                  
                <label for="name"><span>Nazwa:</span><input type="text" name="name"></label>                
                <label for="breeder"><span>Hodowca:</span>
                    <select name="breeder">
                        <?php while ($breeder_stmt->fetch()) {
                            echo "<option value=\"$breeder_id\">$breeder_name $breeder_surname</option>";
                        } 
                        $breeder_stmt->close(); ?>
                    </select>
                </label> 
                <label for="division"><span>Oddział:</span> 
                    <select name="division">
                        <?php while ($division_stmt->fetch()) {
                            echo "<option value=\"$division_id\">$division_name</option>";
                        } 
                        $division_stmt->close(); 
                        $mysql->close(); ?>
                    </select>
                </label>                                    
                <label><span>&nbsp;</span><input type="submit" value="Dodaj"></label>                                   
            </form>
        </div>
<?php include "footer.php" ?> 

