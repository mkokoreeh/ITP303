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
	// Close
	$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Hearthstone Deck Sharing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- <link href="lib/font/css/open-iconic-bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="shared.css">
    <meta name="description" content="Search for all Hearthstone cards based on name and class from all cards in Hearthstone, even modern cards from the most recent expansion!">
    <link href="https://fonts.googleapis.com/css2?family=Imbue:opsz@10..100&display=swap" rel="stylesheet">
	<style>
        /* #title{
            margin-top: 100px;
        } */
        #content{
            background-color: #fefae0;
            padding: 10px;
        }
        .art:hover{
            cursor: pointer;
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
	<div id="container">
		<div id="content">
			<div id="title" class="col-sm-10 d-flex justify-content-center align-items-center mb-5">
				<h2>Card Search</h2>
			</div> <!-- .col -->
            <div class="col-12">
                <div>Search then click a card to add it to your saved cards!</div>
				<form id="search">
                    
                    <div class="form-group row">
						<label for="card" class="col-form-label">Card Name:</label>
                        
						<div class="col-sm-4">
							<input type="text" name="card" class="form-control" placeholder="Leeroy Jenkins" id="card">

							<small id="card-error" class="form-text text-danger"></small>
						</div>
                        <div class="form-group row">
                            <div class="col-sm-6 ml-5">
                                <label for="class" class="sr-only">Class:</label>
    
                                <select id="class" class="form-control">
                                <?php while ($row = $results_class->fetch_assoc()) : ?>

                                    <option value='<?php echo $row["class"]; ?>'>
                                        <?php echo $row["class"]; ?>
                                    </option>

                                <?php endwhile; ?>
                                </select>
    
                            </div> <!-- .col -->
                        <div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div> <!-- .col -->
                        </div> <!-- .form-group -->
                        </div>
					</div> <!-- .form-group -->
                </form>
                <div id="card-results"></div>
            </div>
		</div> <!-- .row -->
	</div> <!-- .container -->
    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        document.querySelector("#search").onsubmit = function(event) {
            event.preventDefault();
            let count = 0;
            const card = document.querySelector('#card').value.trim()
            if (card.length <= 0) {
                document.querySelector("#card-error").innerHTML = "Must enter a card"
                return false
            }
            console.log("Form Submitted")
            const settings = {
                async: true,
                crossDomain: true,
                url: 'https://omgvamp-hearthstone-v1.p.rapidapi.com/cards/search/' + card + '?collectible=1',
                method: 'GET',
                headers: {
                    'X-RapidAPI-Key': '6dec8369cfmsh4f58b1c145bf8e6p116a13jsnfe2aaf7720e9',
                    'X-RapidAPI-Host': 'omgvamp-hearthstone-v1.p.rapidapi.com'
                }
            };

        $.ajax(settings).done(function(response) {
            console.log(response);
            clearList();

            if (Array.isArray(response)) {
                if (response.length === 0) {
                    document.querySelector("#card-results").innerHTML = "No Cards Found"
                }
                response.forEach(card => {
                    console.log('Card:', card)
                    console.log('Card Name:', card.name)
                    console.log('Card Image:', card.img)

                    const selectedClass = document.querySelector("#class").value;

                    if (card.cardSet != 'Hero Skins' && (card.playerClass == selectedClass || card.playerClass == "Neutral")) {
                        createCard(card)
                        count++
                    }
                    else if(selectedClass == "All" && card.cardSet != 'Hero Skins')
                    {
                        createCard(card)
                    }
                });

                if (count === 0) {
                    document.querySelector("#card-results").innerHTML = "No cards match the selected filters."
                }
            } else {
                console.error('Unexpected response format:', response)
            }
            }).fail(function(xhr, status, error) {
                if (xhr.status === 404) {
                    document.querySelector("#card-results").innerHTML = "Card not found. Please enter a valid card name."
                } else {
                    console.error('Request failed:', status, error)
                }
            });
        };

        function clearList() {
            document.querySelector("#card-error").innerHTML = ""
            document.querySelector("#card-results").innerHTML = "";
            const cardResults = document.querySelector("#card-results")
            const listItems = cardResults.querySelectorAll("img")
            listItems.forEach((div) =>{
                cardResults.removeChild(div);
            })
        }
        function createCard(card) {
            const created_card = document.createElement("div")
            const img = document.createElement("img")
            // img.classList.add("col-sm-2")
            if(card.img){
                img.src = card.img
                img.alt = card.name + " Card Art"
                img.addEventListener('click', function() {
                    handleImageClick(card.name, card.img, card.rarity, card.cardSet, card.playerClass, card.dbfId);
                })
                img.classList.add("art")
                document.querySelector("#card-results").appendChild(img)
            }
        }
        function handleImageClick(cardName, cardImage, cardRarity, cardExp, cardClass, dbfid) {
        
        $.ajax({
            type: 'POST',
            url: 'add_card.php',
            data: { cardName: cardName, imageUrl: cardImage, cardRarity: cardRarity, cardExp: cardExp, cardClass: cardClass,  dbfid: dbfid},
            success: function(response) {
                console.log(response)
                alert(`Added ${cardName} to deck!`)
            },
            error: function(error) {
                console.error(error)
            }
        });
    }
    </script>

</body>
</html>