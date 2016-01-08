<?php
include('functions.php');

session_start();
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>

<?php include "header.php" ?>         
    <H1>Nowy hodowca:</H1><br>
    <div class="form-style">
        <form action="wstawianie_nowego_hodowcy.php" method="POST">                  
            <label for="name"><span>Imię:</span><input type="text" name="name"></label>                
            <label for="surname"><span>Nazwisko:</span><input type="text" name="surname"></label>                 
            <label for="adress"><span>Adres:</span><input type="text" name="adress"></label>              
            <label for="phone_number"><span>Telefon:</span><input type="text" name="phone_number"></label>                      
            <label><span>&nbsp;</span><input type="submit" value="Dodaj"></label>                                   
        </form>
    </div>
<?php include "footer.php" ?> 

