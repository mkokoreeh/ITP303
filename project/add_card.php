<?php
    //credentials
	$host = "303.itpwebdev.com";
	$user = "okoreeh_db_user";
	$pass = "okoreeh03!";
	$db = "okoreeh_m3_db";

	//connection
	$mysqli = new mysqli($host, $user, $pass, $db);

	//Run

	//Error check
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}
	
	// Create SQL Statements
	$class = "SELECT * FROM classes;";
	$expansion = "SELECT * FROM expansions;";
	$rarity = "SELECT * FROM rarities;";

	// Run DB
	$results_class = $mysqli->query($class);
	$results_expansion = $mysqli->query($expansion);
	$results_rarity = $mysqli->query($rarity);


	//Check Errors
	if($results_class==false || $results_expansion==false || $results_rarity==false){
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

    function getID($mysqli, $tableName, $columnName, $value)
    {
        $sql = "SELECT ID FROM $tableName WHERE $columnName = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $stmt->close();
        return $id;
    }
    $cardName = $_POST['cardName'];
    $imageUrl = $_POST['imageUrl'];
    $cardRarity = $_POST['cardRarity'] ?? 'Uncollectible';
    $cardExp = $_POST['cardExp'] ?? 'Core';
    $cardClass = $_POST['cardClass'];
    $dbfid = $_POST['dbfid'];

    $rarityID = getID($mysqli, "rarities", "rarity", $cardRarity);
    $classID = getID($mysqli, "classes", "class", $cardClass);
    $expansionID = getID($mysqli, "expansions", "expansion", $cardExp);
    $sql = "INSERT INTO cards (name, image, rarityID, classID, expansionID, dbfid) VALUES ('$cardName', '$imageUrl', '$rarityID', '$classID', '$expansionID', '$dbfid')";

    if ($mysqli->query($sql) === TRUE) {
        echo "Card added successfully!";
    } else {
        echo "Error adding card: " . $mysqli->error;
    }

    $mysqli->close();
?>
