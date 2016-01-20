<?php
include('functions.php');

session_start();
if (!empty($_SESSION['user'])) {
    header("Location: panel.php");
    exit();
}

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$passwordRaw = null;
if (!empty($_POST['passwordhashed'])) {
    $passwordRaw = $_POST['passwordhashed'];
}

$password = hash('sha512', $passwordRaw);

$empty = false;
$realPassword = '';
$userNotFound = false;

if ($username === null && $passwordRaw === null) {
    $empty = true;
} else {
    $mysql = dbConnect();
    $stmt = $mysql->prepare("SELECT HASLO FROM UZYTKOWNICY WHERE LOGIN=(?)");
    if (!$stmt) {
        die();
    }
    $stmt->bind_param('s', $username);
    $stmt->bind_result($realPassword);
    $stmt->execute();
    if (!$stmt->fetch()) {
        $userNotFound = true;
    }
    $stmt->close();
}

if (!$userNotFound && $password === $realPassword) {
    $_SESSION['user'] = $username;
    header("Location: panel.php");
    exit();    
}


?>

<?php include "header.php" ?> 
        <div class="form-style">
            <form method="POST" id="loginform">                                                                           
                <label for="name"><span>Użytkownik:</span><input type="text" name="username"></label><br />                                                                                                                          
                <label for="password"><span>Hasło:</span><input type="password" id="password" name="password"></label><br />
                <label><span>&nbsp;</span><input id="submitbutton" type="button" value="Zaloguj" ></label>                                                                                                       
            </form>
        </div>
        <?php
        if (!$empty) {
            echo 'Zła nazwa użytkownika lub hasło.<br>';
        }
        ?>
              
        <script type="text/javascript" src="sha512.js"></script>
        <script type="text/javascript" src="login.js"></script>
        
<?php include "footer.php" ?> 
