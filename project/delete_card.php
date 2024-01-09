<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cardId"])) {
    //credentials
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

    $cardId = $_POST["cardId"];

    $sql = "DELETE FROM cards WHERE idcards = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("i", $cardId);

    $stmt->execute();

    if ($stmt->error) {
        echo $stmt->error;
    } else {
        echo "Card deleted successfully!";
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "Invalid request.";
}
?>
