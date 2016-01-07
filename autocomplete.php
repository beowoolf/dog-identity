<?php
include('functions.php');

$dogid = strtoupper($_POST['text']);

$mysql = dbConnect();
        
$stmt = $mysql->prepare("SELECT pies.oznaczenie FROM pies WHERE pies.oznaczenie LIKE (?) ");
if (!$stmt) {
    die();
}
   
$param = $dogid . "%";

$stmt->bind_param('s', $param);
$stmt->execute();
$stmt->bind_result($id);

while ($stmt->fetch()) {
    echo $id;
    echo ",";
}


