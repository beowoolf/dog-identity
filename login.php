<?php
include('functions.php');

session_start();
if (!empty($_SESSION['user'])) {
    header("Location: panel.php");
    exit();
}

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$passwordRaw = null;
if (!empty($_POST['password'])) {
    $passwordRaw = $_POST['password'];
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
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>DogIdentity</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script type="text/javascript" src="sha512.js"></script>
        <script type="text/javascript">
            function onSubmit() {
                document.getElementById('password').value = CryptoJS.SHA512(document.getElementById('password').value);
                document.getElementById('loginform').submit();
            }
        </script>
    </head>
    <body>       
        <form method="POST" id="loginform">           
            <fieldset
                <legend>Logowanie</legend><br>
                <label>Użytkownik:</label> <input type="text" name="username"><br>
                <label>Hasło:</label> <input type="password" id="password" name="password"><br>
                <input type="button" value="Zaloguj" onclick="onSubmit()">
            </fieldset>
        </form>
        <?php
        if (!$empty) {
            echo 'Zła nazwa użytkownika lub hasło.<br>';
        }
        ?>
        <a href="index.php">Strona główna</a>
    </body>
</html>
