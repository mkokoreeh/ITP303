<?php

//credentials
$host = "303.itpwebdev.com";
$user = "okoreeh_db_user";
$pass = "okoreeh03!";
$db = "okoreeh_m3_db";

//connection
$mysqli = new mysqli($host, $user, $pass, $db);

// Error check
if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $deckId = $_POST['deckId'];
    $name = $_POST['name'];
    $image = $_POST['image'];
    $code = $_POST['code'];

    $sql = "UPDATE decks 
            SET name = ?, image = ?, code = ? 
            WHERE ID = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("sssi", $name, $image, $code, $deckId);

    $result = $stmt->execute();

    if ($result) {
        header("Location: decks.php");
        exit();
    } else {
        echo "Error updating deck: " . $stmt->error;
    }

    $stmt->close();
} else {
    $deckId = $_GET['ID'];

    $sql = "SELECT * FROM decks WHERE ID = ?";
    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("i", $deckId);

    $result = $stmt->execute();

    if ($result) {
        $stmt->bind_result($fetchedDeckId, $name, $image, $code);

        $stmt->fetch();
    } else {
        echo "Error retrieving deck data: " . $stmt->error;
        exit();
    }

    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Deck</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="shared.css">
    <link href="https://fonts.googleapis.com/css2?family=Imbue:opsz@10..100&display=swap" rel="stylesheet">
    <style>
        #title {
            margin-top: 100px;
            text-align: center;
        }

        h2 {
            color: white;
        }

        div {
            word-wrap: break-word;
        }

        img {
            width: 100px;
        }

        p {
            color: white;
        }

        #content {
            border: 2px;
            background-color: #606c38;
            padding-bottom: 50px;
        }

        form {
            max-width: 500px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div id="navbar">
        <a href="home.php">Home</a>
        <a href="card-search.php">Card Search</a>
        <a href="decks.php">Decks</a>
        <a href="cards.php">Saved Cards</a>
        <a href="project_summary.php">Project Summary</a>
    </div>
    <div id="container">
        <div id="content" class="row mt-5">
            <div id="title" class="col-sm-10 d-flex justify-content-center align-items-center">
                <h2>Edit Deck</h2>
            </div> <!-- .col -->
            <div class="col-12">
                <form action="edit_deck.php" method="post">
                    <input type="hidden" name="deckId" value="<?php echo $deckId; ?>">
                    <div class="form-group">
                        <label for="name">Deck Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image URL:</label>
                        <input type="text" class="form-control" id="image" name="image" value="<?php echo $image; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="code">Deck Code:</label>
                        <textarea class="form-control" id="code" name="code" rows="3" required><?php echo $code; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Deck</button>
                </form>
            </div>
        </div> <!-- .row -->
    </div> <!-- .container -->
</body>

</html>
