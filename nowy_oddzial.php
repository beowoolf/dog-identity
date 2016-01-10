<?php
include('functions.php');

session_start();
if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>

<?php include "header.php" ?>    
    <H1>Nowy oddział:</H1><br>
    <div class="form-style">
        <form action="wstawianie_nowego_oddzialu.php" method="POST">                  
            <label for="name"><span>Nazwa:</span><input type="text" name="name"></label>                
            <label for="number"><span>Numer:</span><input type="text" name="number"></label> 
            <label for="tatoo"><span>Tautuaż:</span><input type="text" name="tatoo"></label> 
            <label for="address"><span>Adres:</span><input type="text" name="address"></label>              
            <label for="phone_number"><span>Telefon:</span><input type="text" name="phone_number"></label>                      
            <label><span>&nbsp;</span><input type="submit" value="Dodaj"></label>                                   
        </form>
    </div>
<?php include "footer.php" ?> 

