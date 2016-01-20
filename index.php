<?php
include('functions.php');

function findLostDog($dogid) {
    if (strlen($dogid) > 6) { //chip
        $mysql = dbConnect();
        
        $stmt = $mysql->prepare(
              "SELECT ODDZIAL.NAZWA, ODDZIAL.NUMER, ODDZIAL.ADRES, ODDZIAL.TELEFON "
            . "FROM PIES "
            . "JOIN MIOT ON PIES.M_ID = MIOT.ID "
            . "JOIN HODOWLA ON MIOT.H_ID = HODOWLA.ID "
            . "JOIN ODDZIAL ON HODOWLA.O_ID = ODDZIAL.ID "
            . "WHERE PIES.OZNACZENIE=(?)");
        if (!$stmt) {
            die();
        }
        $stmt->bind_param('s', $dogid);
    } else { //tatuaż
        $dogid = strtoupper($dogid);
        $last = $dogid[strlen($dogid) - 1];
        $tatoo = "";
        if ('A' <= $dogid[0] && $dogid[0] <= 'Z') {
            //pierwszy znak to litera
            $tatoo = $dogid[0] . "000";
        } else if ('A' <= $last && $last <= 'Z') {
            //ostatni znak to litera
            $tatoo = "000" . $last;
        } else return -1;
        
        $mysql = dbConnect();
        
        $stmt = $mysql->prepare(
              "SELECT ODDZIAL.NAZWA, ODDZIAL.NUMER, ODDZIAL.ADRES, ODDZIAL.TELEFON "
            . "FROM ODDZIAL "
            . "WHERE ODDZIAL.TATUAZ=(?)");
        if (!$stmt) {
            die();
        }
        $stmt->bind_param('s', $tatoo);
    }

    $stmt->bind_result($nazwa, $numer, $adres, $telefon);
    $stmt->execute();
    if (!$stmt->fetch()) {
        $stmt->close();
        return -1;
    }
    $stmt->close();
    return ["nazwa" => $nazwa,
            "numer" => $numer,
            "adres" => $adres,
            "telefon" => $telefon];
}

?>
<?php include "header.php" ?>  
        DogIdentity - strona publiczna<br />
        Znalazłeś psa? Sprawdź, czy jest w naszej bazie:<br />
        <?php
        $dogid = filter_input(INPUT_GET, 'dogid', FILTER_SANITIZE_STRING);
        ?>
        <div class="form-style">
            <label for="dogid"><span>Podaj numer chipa lub tatuażu:</span></label>
        </div>
        
        <div class="form-style">
            <form action="index.php" id="search">
                    <input type="text" name="dogid" value="<?php echo $dogid; ?>"  id="searchbox" autocomplete="off">
                    <div id="autocomplete"></div><input type="submit" value="Szukaj">
            </form>
        </div>
        <?php
            if ($dogid !== null && $dogid !== "") {
                $id = findLostDog($dogid);
                if ($id === -1) {
                    echo 'Nie znaleziono psa.';
                } else {
                    echo 'Znaleziono oddział, gdzie może należeć ten pies: <br>';
                    echo "Oddział " . $id['numer'] . " (" . $id['nazwa'] . ")<br>";
                    echo $id['adres'] . "<br>";
                    echo "Telefon: " . $id['telefon'] . "<br>";
                }
            }
        ?>
        <hr />
        
        <script type="text/javascript" src="jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="autocomplete.js"></script>
        
<?php include "footer.php" ?>    