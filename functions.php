<?php
include('config.inc.php');

function dbConnect() {
    global $databaseAddress, $databaseUser, $databasePass, $databaseDatabase, $databasePort;
    $mysql = new mysqli($databaseAddress, $databaseUser, $databasePass, $databaseDatabase, $databasePort);
    if ($mysql->connect_error) {
        die();
    }
    $mysql->set_charset("utf8");
    return $mysql;
}

function primaryKeyLink($table, $id) {
    return '<a href="' . $table . '.php?id=' . $id . '">' . $id . '</a>';
}

function foreignKeyLink($table, $id, $text) {
    return '<a href="' . $table . '.php?id=' . $id . '">' . $text . ' (' . $id . ')</a>';
}

//przykład użycia:
//showTableMiot("");
//showTableMiot("WHERE MIOT.H_ID = 2");
function showTableMiot($where) {
    $mysql = dbConnect();
    $stmt = $mysql->prepare("SELECT MIOT.ID, MIOT.URODZONY, MIOT.ZNAKOWANY, MIOT.POZYCJA, MIOT.H_ID, HODOWLA.NAZWA "
            . "FROM MIOT "
            . "JOIN HODOWLA ON HODOWLA.ID = MIOT.H_ID "
            . $where);
    $stmt->bind_result($id, $urodzony, $znakowany, $pozycja, $h_id, $hodowlaNazwa);
    if (!$stmt) {
        die();
    }
    $stmt->execute();
    echo 'Mioty:<br>';
    echo '<a href="nowy_miot.php">Dodaj nowy miot</a>';
    echo '<table class="data">';
    echo '<tr class="tableheader">';
    echo '<th>ID</th>';
    echo '<th>Data urodzenia</th>';
    echo '<th>Data znakowania</th>';
    echo '<th>Pozycja znakowania</th>';
    echo '<th>ID hodowli</th>';
    echo '</tr>';

    while ($stmt->fetch()) {
        echo "<tr>";
        echo "<td>" . primaryKeyLink('miot', $id) . "</td>";
        echo "<td>" . $urodzony . "</td>";
        echo "<td>" . $znakowany . "</td>";
        echo "<td>" . $pozycja . "</td>";
        echo '<td>' . foreignKeyLink('hodowla', $h_id, $hodowlaNazwa) . '</td>';
        echo "</tr>\n";
    }
    echo "</table>\n";
    $stmt->close();
}

function showTableHodowla($where) {
    $mysql = dbConnect();
    $stmt = $mysql->prepare("SELECT HODOWLA.ID, HODOWLA.NAZWA, HODOWLA.O_ID, HODOWLA.H_ID, HODOWCA.NAZWISKO, ODDZIAL.NAZWA "
            . "FROM HODOWLA "
            . "JOIN HODOWCA ON HODOWCA.ID = HODOWLA.H_ID "
            . "JOIN ODDZIAL ON ODDZIAL.ID = HODOWLA.O_ID "
            . $where);
    $stmt->bind_result($id, $nazwa, $o_id, $h_id, $hodowcaNazwisko, $oddzialNazwa);
    if (!$stmt) {
        die();
    }
    $stmt->execute();
    echo 'Hodowle:<br>';
    echo '<a href="nowa_hodowla.php">Dodaj nową hodowlę</a>';
    echo '<table class="data">';
    echo '<tr class="tableheader">';
    echo '<th>ID</th>';
    echo '<th>Nazwa</th>';
    echo '<th>ID oddziału</th>';
    echo '<th>ID hodowcy</th>';
    echo '</tr>';

    while ($stmt->fetch()) {
        echo "<tr>";
        echo "<td>" . primaryKeyLink('hodowla', $id) . "</td>";
        echo "<td>" . $nazwa . "</td>";
        echo '<td>' . foreignKeyLink('oddzial', $o_id, $oddzialNazwa) . '</td>';
        echo '<td>' . foreignKeyLink('hodowca', $h_id, $hodowcaNazwisko) . '</td>';
        echo "</tr>\n";
    }
    echo "</table>\n";
    $stmt->close();
}

function showTablePies($where) {
    $mysql = dbConnect();
    $stmt = $mysql->prepare("SELECT PIES.ID, PIES.IMIE, PIES.SUKA, PIES.OZNACZENIE, PIES.OJCIEC, PIES.MATKA, PIES.M_ID, PIES.R_ID, "
            . "MIOT.URODZONY, RASA.NAZWA "
            . "FROM PIES "
            . "JOIN MIOT ON MIOT.ID = PIES.M_ID "
            . "JOIN RASA ON RASA.ID = PIES.R_ID "
            . $where);
    $stmt->bind_result($id, $imie, $suka, $oznaczenie, $ojciec, $matka, $m_id, $r_id, $urodzony, $rasa);
    if (!$stmt) {
        die();
    }
    $stmt->execute();
    echo 'Psy:<br>';
    echo '<a href="nowy_pies.php">Dodaj nowego psa</a>';
    echo '<table class="data">';
    echo '<tr class="tableheader">';
    echo '<th>ID</th>';
    echo '<th>Imię</th>';
    echo '<th>Płeć</th>';
    echo '<th>Oznaczenie</th>';
    echo '<th>Ojciec</th>';
    echo '<th>Matka</th>';
    echo '<th>ID miotu / data urodzenia</th>';
    echo '<th>ID rasy</th>';
    echo '</tr>';

    while ($stmt->fetch()) {
        echo "<tr>";
        echo "<td>" . primaryKeyLink('pies', $id) . "</td>";
        echo "<td>" . $imie . "</td>";
        echo "<td>" . getSex($suka) . "</td>";
        echo "<td>" . $oznaczenie . "</td>";
        echo "<td>" . $ojciec . "</td>";
        echo "<td>" . $matka . "</td>";
        echo '<td>' . foreignKeyLink('miot', $m_id, $urodzony) . '</td>';
        echo '<td>' . foreignKeyLink('rasa', $r_id, $rasa) . '</td>';
        echo "</tr>\n";
    }
    echo "</table>\n";
    $stmt->close();
}

function getSex($suka) {
    return (($suka)?('suka'):('pies'));
}