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

    // Handle delete action
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['deleteDeck'])) {
        $deckIdToDelete = $_POST['deleteDeck'];
        
        // Perform the delete operation for both cards and decks
        $deleteDeckSql = "DELETE FROM decks WHERE ID = $deckIdToDelete";
        $deleteDeckResult = $mysqli->query($deleteDeckSql);

        // Check for errors in deck deletion
        if ($deleteDeckResult) {
            // Redirect to refresh the page after successful delete
            header("Location: decks.php");
            exit();
        } else {
            echo "Error deleting deck: " . $mysqli->error;
        }
    }

    // Create SQL Statements
    $sql = "SELECT * FROM decks";

    // Run DB query
    $results = $mysqli->query($sql);

    // Check Errors
    if ($results == false) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hearthstone Deck Sharing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="shared.css">
    <link href="https://fonts.googleapis.com/css2?family=Imbue:opsz@10..100&display=swap" rel="stylesheet">
    <meta name="description" content="View all of your saved decks. Customize the decks with your own names and images; you can even swap out the deck code for other codes.">
    <style>
        #title {
            margin-top: 50px; /* Adjusted margin for smaller screens */
            text-align: center;
        }

        h2 {
            color: white;
        }

        div {
            word-wrap: break-word;
        }

        img {
            width: 200px; /* Increased image size */
        }

        p {
            color: white;
            font-size: 20px; /* Increased font size for smaller screens */
        }

        #content {
            border: 2px;
            background-color: #606c38;
            padding: 20px; /* Adjusted padding for smaller screens */
            padding-bottom: 50px;
        }

        .deck-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap; /* Allow actions to wrap on smaller screens */
        }

        .btn-primary,
        .btn-danger,
        .copy-btn {
            width: 70px;
            margin-right: 10px;
            margin-bottom: 10px; /* Adjusted margin for smaller screens */
        }

        .deck-name,
        .deck-image {
            margin-bottom: 10px; /* Adjusted margin for smaller screens */
        }

        .deck-image img {
            max-width: 100%; /* Make images responsive */
            height: auto; /* Maintain aspect ratio */
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
                <h2>Saved Decks</h2>
            </div>
            <div class="col-12">
                <p class="mt-5">Copy these codes and paste them into the Hearthstone app to start playing! (Note: Copy/Pasting functionality under development as Hearthstone does not currently recognize the code, enjoy searching and saving!)</p>
                <ul id="deck-list" class="list-group col-12">
                    <?php while ($row = $results->fetch_assoc()) : ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <div class="deck-actions">
                            <a href="edit_deck.php?ID=<?php echo $row['ID']; ?>" class="btn btn-primary">Edit</a>
                            <!-- Add delete button -->
                            <form method="post" style="display: inline-block;">
                                <input type="hidden" name="deleteDeck" value="<?php echo $row['ID']; ?>">
                                <button type="submit" class="btn btn-danger delete-btn">Delete</button>
                            </form>
                            <!-- Add copy-to-clipboard button -->
                            <button class="btn btn-success copy-btn" onclick="copyToClipboard('<?php echo $row['code']; ?>')">Copy</button>
                        </div>
                        <div class="deck-name col-sm-2" style="font-size: 18px;"><?php echo $row['name']; ?></div>
                        <div class="deck-image col-sm-2">
                            <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                        </div>
                    </li>
                    <?php endwhile; ?>
                </ul>
                <div id="further-decks"></div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
            alert('Deck code copied to clipboard!');
        }
    </script>
</body>
</html>

<?php
    $mysqli->close();
?>
