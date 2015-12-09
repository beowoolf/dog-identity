<?php
include('functions.php');

function findLostDog($dogid) {
    if (strlen($dogid) > 6) { //chip
        $mysql = dbConnect();
        
        $stmt = $mysql->prepare(
              "SELECT oddzial.nazwa, oddzial.numer, oddzial.adres, oddzial.telefon "
            . "FROM pies "
            . "JOIN miot ON pies.m_id = miot.id "
            . "JOIN hodowla ON miot.h_id = hodowla.id "
            . "JOIN oddzial ON hodowla.o_id = oddzial.id "
            . "WHERE pies.oznaczenie=(?)");
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
              "SELECT oddzial.nazwa, oddzial.numer, oddzial.adres, oddzial.telefon "
            . "FROM oddzial "
            . "WHERE oddzial.tatuaz=(?)");
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
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>DogIdentity</title>
    </head>
    <body>       
        DogIdentity - strona publiczna<br />
        Znalazłeś psa? Sprawdź, czy jest w naszej bazie:<br />
        <?php
        $dogid = filter_input(INPUT_GET, 'dogid', FILTER_SANITIZE_STRING);
        ?>
        <form action="index.php">
            Podaj numer chipa lub tatuażu: <input type="text" name="dogid" value="<?php
            echo $dogid; ?>"><br>
            <input type="submit" value="Szukaj">
        </form>
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
        <a href="login.php">Logowanie dla pracowników</a><br />
    </body>
</html>
