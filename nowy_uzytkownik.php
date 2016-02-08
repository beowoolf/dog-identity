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
    
    if(isset($_GET["id"])) {
            echo "<H1>Edycja użytkownika:</H1><br>";
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            $mysql3 = dbConnect();        
            $stmt = $mysql3->prepare("SELECT UZYTKOWNICY.LOGIN "
                    . "FROM UZYTKOWNICY "
                    . "WHERE UZYTKOWNICY.ID=(?)");
            $stmt->bind_param("i", $id);
            $stmt->bind_result($login);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            $stmt->fetch();

        } else {
            echo "<H1>Nowy użytkownik:</H1><br>";
            $login = "";
        }
?>       
        <div class="form-style">
            <form action="wstawianie_nowego_uzytkownika.php" method="POST" id="form">                  
                <label for="login"><span>Login:</span><input type="text" name="login" value="<?php echo htmlspecialchars($login); ?>"></label><br />
                <label for="newPass1"><span>Nowe hasło:</span><input id="newPass1" type="password" name="newPass1"></label><br />
                <label for="newPass2"><span>Nowe hasło (powtórz):</span><input id="newPass2" type="password" name="newPass2"></label><br />
                <?php
                    if (isset($_GET["id"])) {
                        echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />";
                    }
                ?>
                <label><span>&nbsp;</span><input id="submitbutton" type="button" value="Zapisz"></label>                                   
            </form>
        </div>
        <script type="text/javascript" src="sha512.js"></script>
        <script type="text/javascript" src="newUser.js"></script>
<?php include "footer.php" ?> 

