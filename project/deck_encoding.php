<?php
// credentials
$host = "303.itpwebdev.com";
$user = "okoreeh_db_user";
$pass = "okoreeh03!";
$db = "okoreeh_m3_db";

// connection
$mysqli = new mysqli($host, $user, $pass, $db);

// Error check
if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
    exit();
}

// Create SQL Statement to fetch dbfid values
$sql = "SELECT dbfid FROM cards";

// Run DB query
$results = $mysqli->query($sql);

// Check Errors
if ($results == false) {
    echo $mysqli->error;
    $mysqli->close();
    exit();
}

$dbfids = [];
while ($row = $results->fetch_assoc()) {
    $dbfids[] = $row['dbfid'];
}

$deckCode = encodeDeck($dbfids);

$insertSql = "INSERT INTO decks (name, image, code) VALUES ('New deck', 'images/placeholder.jpg', '$deckCode')";

$insertResult = $mysqli->query($insertSql);

if ($insertResult == false) {
    echo $mysqli->error;
    $mysqli->close();
    exit();
}

$newDeckId = $mysqli->insert_id;
echo json_encode(['deckId' => $newDeckId]);

$mysqli->close();

function encodeDeck($dbfids) {
    $baseCharacters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    $result = "";

    foreach ($dbfids as $dbfid) {
        $bits = decbin($dbfid);

        $bits = str_pad($bits, ceil(strlen($bits) / 6) * 6, "0", STR_PAD_LEFT);

        $chunks = str_split($bits, 6);

        foreach ($chunks as $chunk) {
            $index = bindec($chunk);
            $result .= $baseCharacters[$index];
        }
    }

    return $result;
}

?>
