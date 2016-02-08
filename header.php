<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>DogIdentity</title>
    </head>
    <body>    
        
        <div class="menu">
            <ul>
                <li><a href="index.php">Strona główna</a></li>
                
                <?php
                    if (empty($_SESSION['user'])) {
                        
                        // Wariant dla niezalogowanych
                        echo "<li><a href=\"login.php\">Zaloguj się jako pracownik</a></li>";
                        
                    } else {
                        
                        // Wariant dla zalogowanych
                        echo "<li><a href=\"mioty.php\">Mioty</a></li>";
                        echo "<li><a href=\"hodowle.php\">Hodowle</a></li>";
                        echo "<li><a href=\"hodowcy.php\">Hodowcy</a></li>";
                        echo "<li><a href=\"oddzialy.php\">Oddziały</a></li>";
                        echo "<li><a href=\"rasy.php\">Rasy</a></li>";
                        echo "<li><a href=\"psy.php\">Psy</a></li>";
                        echo "<li><a href=\"uzytkownicy.php\">Użytkownicy</a></li>";
                        echo "<li><a href=\"logout.php\">Wyloguj</a></li>";
                        
                    }
                ?>
                
            </ul>
        </div>
        
        <div class="content">