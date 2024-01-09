<!DOCTYPE html>
<html>
<head>
	<title>Hearthstone Deck Sharing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- <link href="lib/font/css/open-iconic-bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="shared.css">
    <link href="https://fonts.googleapis.com/css2?family=Imbue:opsz@10..100&display=swap" rel="stylesheet">
    <meta name="description" content="A description of the entire site. View the database, used frameworks and the general goal of the site.">

	<style>
        div{
            color:white;
        }
        #container{
            margin-top: 200px;
        }
        h2{
            margin-top: 15px;
        }
        img{
            width:700px;
        }
        div{
            font-size: 20px;
        }
	</style>

</head>
<body>
    <div id="navbar" class="d-flex justify-content-center align-items-center">
        <a href="home.php">Home</a>
        <a href="card-search.php">Card Search</a>
        <a href= "decks.php">Decks</a>
        <a href="cards.php">Saved Cards</a>
        <a href="project_summary.php">Project Summary</a>
    </div>
	<div>
		<div>
			<h1 class="py-3">Project Summary</h1>
            <h2> Topic</h2>
            <div>
                The Tavern is a site that allows for users to search for Hearthstone cards and build and save decks using deck codes that can be exported directly into the game (currently in development).
            </div>
            <h2>Instructions</h2>
            <div>Users will be able to create decks by searching for cards then adding them to their current deck by clicking on the card and save them into the database. Users can directly interact with saved decks by changing the representative name, image or even full deck code.</div>
            <h2>Source of Data</h2>
            <div>Cards come from Microsoft Blizzard's CCG Hearthstone using the Hearthstone API to search for and display the card data.</div>
            <h2>Database</h2>
            <div>
                <img src="images/Database.png" alt="Database Screenshot">
            </div>
            <h2>API</h2>
            <div><a href="hearthstoneapi.com">Hearthstone API</a></div>
            <h3>Frameworks</h3>
            <div>Bootstrap</div>
            
            
		</div> <!-- .row -->
	</div> <!-- .container -->


</body>
</html>