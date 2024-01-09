<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hearthstone Deck Sharing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="shared.css">
    <link href="https://fonts.googleapis.com/css2?family=Imbue:opsz@10..100&display=swap" rel="stylesheet">
    <meta name="description" content="A deck building site for Microsoft Blizzard's card game Hearthstone. Search and track cards and export your deck directly into Hearthstone!.">
    <style>
        #about,
        #expansion {
            text-align: center;
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            color: white;
        }
        #about {
            background-color: #606c38;
            flex-basis: calc(50% - 40px);
        }
        #expansion {
            background-color: #fcba03;
            flex-basis: calc(50% - 40px);
        }
        .exp {
            max-width: 100%; /* Adjust as needed */
            height: auto;
        }
        h2 {
            margin-bottom: 20px;
        }
        p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div id="navbar">
        <a href="home.php">Home</a>
        <a href="card-search.php">Card Search</a>
        <a href="decks.php">Decks</a>
        <a class="col-sm-3" href="cards.php">Saved Cards</a>
        <a href="project_summary.php">Project Summary</a>
    </div>

    <div id="container">
        <div id="content">
            <div id="logo">
                <img id="logo-img" src="images/logo.png" alt="Logo">
            </div>
            <div id="about">
                <h2>About:</h2>
                <p>Search for all cards in Activision Blizzard's collectible card game Hearthstone. Create, share and browse various decks that can be copied directly into the game!</p>
            </div>
            <div id="expansion" class="col-sm-5 d-flex justify-content-center align-items-center">
                <p>Current Expansion: <img class="exp" src="images/expansion.png" alt="Current Expansion image"></p>
            </div>
        </div>
    </div>
</body>
</html>
