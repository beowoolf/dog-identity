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
                <li><a href="index.php">Strona główna</a><br /></li>
                
                <?php
                    if (empty($_SESSION['user'])) {
                        
                        // Wariant dla niezalogowanych
                        echo "<li><a href=\"login.php\">Zaloguj się jako pracownik</a><br />";
                        
                    } else {
                        
                        // Wariant dla zalogowanych
                        echo "<li><a href=\"mioty.php\">Mioty</a><br />";
                        echo "<li><a href=\"hodowle.php\">Hodowle</a><br />";
                        echo "<li><a href=\"hodowcy.php\">Hodowcy</a><br />";
                        echo "<li><a href=\"oddzialy.php\">Oddziały</a><br />";
                        echo "<li><a href=\"rasy.php\">Rasy</a><br />";
                        echo "<li><a href=\"psy.php\">Psy</a><br />";
                        echo "<li><a href=\"logout.php\">Wyloguj</a><br />";
                        
                    }
                ?>
                
            </ul>
        </div>
        
        <div class="content">