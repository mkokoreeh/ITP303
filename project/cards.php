<?php
    //credentials
    $host = "303.itpwebdev.com";
    $user = "okoreeh_db_user";
    $pass = "okoreeh03!";
    $db = "okoreeh_m3_db";

    //connection
    $mysqli = new mysqli("p:".$host, $user, $pass, $db);


    // Error check
    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    // Create SQL Statements
    $sql = "SELECT cards.idcards, cards.name, cards.image, rarities.rarity, classes.class, expansions.expansion
            FROM cards
            LEFT JOIN rarities ON cards.rarityID = rarities.ID
            LEFT JOIN classes ON cards.classID = classes.ID
            LEFT JOIN expansions ON cards.expansionID = expansions.ID";

    // Run DB query
    $results = $mysqli->query($sql);

    // Check Errors
    if ($results == false) {
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }

    // Close
    $mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hearthstone Deck Sharing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="shared.css">
    <link href="https://fonts.googleapis.com/css2?family=Imbue:opsz@10..100&display=swap" rel="stylesheet">
    <meta name="description" content="View the cards you have saved from card search. From here you can view more info on each card and even encode the cards into a single deck code!">
    <style>
        #title {
            margin-top: 100px;
        }

        #content {
            background-color: #fefae0;
            padding: 10px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .card {
            position: relative;
            width: 200px;
            margin: 10px;
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .card img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div id="navbar" class="d-flex justify-content-center align-items-center">
        <a href="home.php">Home</a>
        <a href="card-search.php">Card Search</a>
        <a href="decks.php">Decks</a>
        <a href="cards.php">Saved Cards</a>
        <a href="project_summary.php">Project Summary</a>
    </div>
    <div id="container">
        <div id="content" class="row mt-5">
            <div id="title" class="col-sm-12 d-flex justify-content-center align-items-center mb-5">
                <h2>Saved Cards</h2>
            </div>
            <button class="btn btn-primary export-btn">Export Deck</button>
            <div class="card-container">
                <?php while ($row = $results->fetch_assoc()) : ?>
                    <div class="card">
                        <button class="btn btn-danger delete-btn" data-card-id="<?php echo $row['idcards']; ?>">X</button>
                        
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                        <p>Name: <?php echo $row['name']; ?></p>
                        <p>Rarity: <?php echo $row['rarity']; ?></p>
                        <p>Class: <?php echo $row['class']; ?></p>
                        <p>Expansion: <?php echo $row['expansion']; ?></p>
                    </div>
                <?php endwhile; ?>
                
            </div>
        </div>
    </div>

    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".delete-btn").click(function() {
                var cardId = $(this).data("card-id");

                if (confirm("Are you sure you want to delete this card?")) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_card.php',
                        data: { cardId: cardId },
                        success: function(response) {
                            console.log(response);
                            location.reload();
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
            });
       
            $(".export-btn").click(function() {
                exportDeck();
            });

            function exportDeck() {
                $.ajax({
                    type: 'GET',
                    url: 'deck_encoding.php',
                    dataType: 'json',
                    success: function(response) {
                        alert('Deck exported successfully!');
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        });
    </script>
</body>
</html>
