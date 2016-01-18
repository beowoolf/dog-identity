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
    $breed_stmt = $mysql->prepare("SELECT RASA.ID, RASA.NAZWA "
            . "FROM RASA");
    $breed_stmt->bind_result($breed_id, $breed_name);
    if (!$breed_stmt) {
        die();
    }
    $breed_stmt->execute();
    $mysql2 = dbConnect();
    $brood_stmt = $mysql2->prepare("SELECT MIOT.ID, MIOT.URODZONY, MIOT.ZNAKOWANY "
            . "FROM MIOT");
    $brood_stmt->bind_result($brood_id, $birthDate, $markupDate);
    if (!$brood_stmt) {
        die();
    }
    $brood_stmt->execute();
    if(isset($_GET["id"])) {
            echo "<H1>Edycja psa:</H1><br>";
            $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);
            $mysql3 = dbConnect();        
            $stmt = $mysql3->prepare("SELECT PIES.IMIE, PIES.MATKA, PIES.OJCIEC, PIES.OZNACZENIE, PIES.R_ID, PIES.M_ID, PIES.SUKA "
                    . "FROM PIES "
                    . "WHERE PIES.ID=(?)");
            $stmt->bind_param("i", $id);
            $stmt->bind_result($name, $mother, $father, $markup, $breed, $brood, $gender);
            if (!$stmt) {
                die();
            }
            $stmt->execute();
            $stmt->fetch();

        } else {
            echo "<H1>Nowy pies:</H1><br>";
            $name = "";
            $mother = "";
            $father = "";
            $markup = "";
            $breed = 0;
            $brood = 0;
            $gender = 0;
        }
?>       
        <div class="form-style">
            <form action="wstawianie_nowego_psa.php" method="POST">                  
                <label for="name"><span>Imię:</span><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"></label><br />
                <label for="mother"><span>Matka:</span><input type="text" name="mother" value="<?php echo htmlspecialchars($mother); ?>"></label><br />
                <label for="father"><span>Ojciec:</span><input type="text" name="father" value="<?php echo htmlspecialchars($father); ?>"></label><br />
                <label for="markup"><span>Oznaczenie:</span><input type="text" name="markup" value="<?php echo htmlspecialchars($markup); ?>"></label><br />
                <label for="breed"><span>Rasa:</span>
                        <select name="breed"> 
                        <?php while ($breed_stmt->fetch()) {                            
                            echo "<option value=\"$breed_id\" ";
                            if ($breed_id == $breed) {
                                echo "selected=\"selected\"";
                            }
                            echo ">$breed_name</option>";
                        } 
                        $breed_stmt->close();
                        $mysql->close() ?>
                    </select>
                </label><br />
                <label for="brood"><span>Miot:</span>
                    <select name="brood">                       
                        <?php while ($brood_stmt->fetch()) {                           
                            echo "<option value=\"$brood_id\" ";
                            if ($brood_id == $brood) {
                                echo "selected=\"selected\"";
                            }
                            echo ">ID: $brood_id Urodzony: $birthDate Znakowany: $markupDate</option>";
                        } 
                        $brood_stmt->close();
                        $mysql2->close() ?>
                    </select>
                </label><br />
                <label for="gender"><span>Płeć:</span>
                    <select name="gender">                       
                        <option value="0">Pies</option>
                        <option value="1">Suka</option>                       
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

