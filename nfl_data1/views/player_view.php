<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Fantasy Stats</title>
    <link rel="stylesheet" href="views/styles.css">
    <style>
        #saved-players-container {
            flex: 1;
            /* Take less space than the main content */
            max-width: 300px;
            /* Set a maximum width */
            background-color: #fff;
            /* White background */
            border: 1px solid #ddd;
            /* Light border */
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
            padding: 15px;
            /* Add padding inside the box */
            font-family: Arial, sans-serif;
            /* Simple font */
        }

        /* Heading Styling */
        #saved-players-container h3 {
            margin: 0 0 10px;
            /* Margin below heading */
            font-size: 18px;
            color: #333;
            /* Dark text color */
            text-align: center;
            /* Center-align the heading */
            border-bottom: 2px solid #ddd;
            /* Underline for emphasis */
            padding-bottom: 5px;
        }

        /* List Styling */
        #saved-players-list {
            list-style: none;
            /* Remove bullet points */
            padding: 0;
            margin: 0;
        }

        #saved-players-list li {
            display: flex;
            justify-content: space-between;
            /* Spread button and player name */
            align-items: center;
            /* Center align items */
            padding: 8px;
            margin-bottom: 5px;
            background-color: #f5f5f5;
            /* Light gray background for items */
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Buttons Styling */
        .save-player-btn {
            background-color: #4caf50;
            /* Green button */
            color: white;
            /* White text */
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            /* Smooth transition */
        }

        .save-player-btn:hover {
            background-color: #45a049;
            /* Slightly darker green on hover */
            transform: scale(1.05);
            /* Slight zoom effect */
        }

        /* Limit Message Styling */
        #save-limit-message {
            font-size: 12px;
            text-align: center;
        }

        /* Style for player name link */
        .player-name-link {
            color: #1a73e8;
            /* Modern blue shade */
            text-decoration: none;
            /* Remove underline */
            font-weight: bold;
            font-size: 1rem;
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .player-name-link:hover {
            color: #0056b3;
            /* Darker blue on hover */
            text-shadow: 0 0 5px rgba(26, 115, 232, 0.6);
            /* Subtle glow effect */
            cursor: pointer;
        }

        /* Style for the saved player item */
        .saved-player {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0.5rem 0;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .delete-player-btn {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 0.4rem 0.8rem;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }

        .delete-player-btn:hover {
            background-color: #cc0000;
        }

        #qb-stats {
            width: 60%;
            float: left;
            box-sizing: border-box;
            /* To ensure padding doesn't affect width */
        }

        #qb-chart-container {
            width: 28%;
            float: right;
            margin-left: 20px;
            box-sizing: border-box;
            /* Ensure padding doesn't affect width */
        }

        #small-table {
            width: 100%;
            /* Make the table take up the full available width of the parent container */
        }

        #stats-bar {
            width: 100%;
            /* Take up the entire width */
            background-color: #f1f1f1;
            /* Optional: Add background for the stats bar */
            padding: 10px;
            text-align: center;
            /* Centers the text */
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            /* Adds some space between the table and the stats bar */
            clear: both;
            /* Ensures the stats bar clears the floated elements above it */
        }

        #stats-bar i {
            margin-left: 10px;
            /* Space between text and icon */
        }

        #qb-chart-container h3 {
            text-align: center;
            font-size: 18px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


</head>


<body>
    <div class="main-layout">
        <div class="main-container">
            <h1>Player Fantasy Stats</h1>
            <input type="text" id="player-name" placeholder="Search for a player...">
            <div id="autocomplete-suggestions" class="autocomplete-suggestions"></div>
            <button id="save-player-btn" class="save-player-btn" data-player="Player Name">Save Player</button>
            <div id="player-info" class="player-info"></div>
            <div id="week-info" class="week-info"></div>
            <div id="qb-stats">
                <h3 id="qbheading" style="display:none">Stats Against Opponent</h3>
                <table id="small-table" class="small-table">
                    <!-- QB Headers -->
                    <thead id="qb-headers" style="display: none;">
                        <tr>
                            <th>Season</th>
                            <th>Opponent Team </th>
                            <th>Completions</th>
                            <th>Attempts</th>
                            <th>Passing TDs</th>
                            <th>Fantasy Points</th>
                        </tr>
                    </thead>
                    <!-- RB Headers -->
                    <thead id="rb-headers" style="display: none;">
                        <tr>
                            <th>Season</th>
                            <th>Opponent Team </th>
                            <th>Rushing Yards</th>
                            <th>Rushing TDs</th>
                            <th>Receptions</th>
                            <th>Fantasy Points</th>
                        </tr>
                    </thead>
                    <!-- WR Headers -->
                    <thead id="wr-headers" style="display: none;">
                        <tr>
                            <th>Season</th>
                            <th>Opponent Team </th>
                            <th>Targets</th>
                            <th>Receptions</th>
                            <th>Receiving Yards</th>
                            <th>Receiving TDs</th>
                            <th>Fantasy Points</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody id="stats-body">
                        <!-- Stats will be dynamically populated -->
                    </tbody>
                </table>
            </div>
            <div id="qb-chart-container" style="display:none">
                <h3>Completions vs. Attempts</h3>
                <canvas id="qb-pie-chart" width="200" height="200"></canvas>
            </div>


            <div id="stats-bar" style="display: none;">
                4 Year Stats
                <i class="fas fa-chevron-down"></i>
            </div>
            <table id="stats-table" style="display: none;">
                <thead>
                    <tr>
                        <th>Season</th>
                        <th>Week</th>
                        <th>Opponent</th>
                        <th>Fantasy Points</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <!-- <button class="fetch-matchups" id="fetch-matchups">Fetch Matchups</button> -->
            <div id="week-info" class="week-info"></div>
        </div>
        <div id="saved-players-container">
            <h3>Saved Players</h3>
            <ul id="saved-players-list"></ul>
            <p id="save-limit-message" style="display: none; color: red;">You can only save up to 5 players.</p>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize the application
            getCurrentNFLWeek();

            // Function to get the current NFL week
            function getCurrentNFLWeek() {
                $.ajax({
                    url: 'index.php?action=getCurrentNFLWeek',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.currentWeek !== undefined) {
                            $('#week-info').html(`Current NFL Week: ${response.currentWeek}`);
                        } else if (response.error) {
                            console.error('Error from server:', response.error);
                            $('#week-info').html('Unable to fetch the current NFL week.');
                        } else {
                            console.error('Unexpected response format:', response);
                            $('#week-info').html('Error loading current NFL week.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error fetching current NFL week:', {
                            status: jqXHR.status,
                            statusText: jqXHR.statusText,
                            responseText: jqXHR.responseText,
                            errorThrown: errorThrown,
                            textStatus: textStatus
                        });
                        $('#week-info').html('Error loading current NFL week.');
                    }
                });
            }

            // Toggle table visibility
            $('#stats-bar').on('click', function() {
                $('#stats-table').toggle();
                var icon = $(this).find('i');
                icon.toggleClass('fa-chevron-down fa-chevron-up');
            });

            // Fetch matchups on button click
            $('#fetch-matchups').on('click', function() {
                getAllMatchups();
            });

            function getAllMatchups() {
                $.ajax({
                    url: 'index.php?action=getAllMatchups',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log("Matchups:", data);
                        alert('Matchups fetched successfully! Check the console for details.');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching matchups:', {
                            status: jqXHR.status,
                            statusText: jqXHR.statusText,
                            responseText: jqXHR.responseText,
                            errorThrown: errorThrown,
                            textStatus: textStatus
                        });
                        alert('Error fetching matchups. Check the console for details.');
                    }
                });
            }

            // Fetch player names for autocomplete
            $('#player-name').on('input', function() {
                var query = $(this).val();
                if (query.length > 1) {
                    $.ajax({
                        url: 'index.php?action=getPlayerNames',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#autocomplete-suggestions').empty();
                            if (response && response.length > 0) {
                                response.forEach(function(player) {
                                    $('#autocomplete-suggestions').append(
                                        `<div class="suggestion-item" data-player="${player.player_display_name}">
                                        ${player.player_display_name}
                                    </div>`
                                    );
                                });
                            }
                        },
                        error: function() {
                            console.error('Error fetching player names.');
                        }
                    });
                } else {
                    $('#autocomplete-suggestions').empty();
                }
            });

            $(document).on('click', '.suggestion-item', function() {
                var playerName = $(this).data('player');
                $('#player-name').val(playerName);
                $('#autocomplete-suggestions').empty();
                fetchPlayerData(playerName);
                //displayPlayerMatchup(playerName);
                getMostRecentTeam(playerName)
            });

            function getMatchup(team, week) {
                return $.ajax({
                    url: 'index.php?action=getMatchup',
                    method: 'GET',
                    data: {
                        team: team,
                        week: week
                    },
                    dataType: 'json'
                });
            }

            function fetchPlayerData(playerName) {
                $.ajax({
                    url: 'index.php?action=getPlayerData',
                    method: 'GET',
                    data: {
                        player_name: playerName
                    },
                    dataType: 'json',
                    success: function(response) {

                        if (response && response.length > 0) {
                            var player = response[0];
                            savePlayerButton.data('player-name', playerName);
                            savePlayerButton.data('player-id', player.player_id);
                            $('#player-info').html(`
                    <img src="${player.headshot_url}" alt="${player.player_display_name}"><br>
                    <strong><h2>${player.player_display_name}</h2></strong><br><br>
                    <p><strong>Team:</strong> ${player.recent_team}</p><br><br>
                `);

                            $('#stats-bar').show();
                            $('#stats-table tbody').empty();


                            response.forEach(function(stat) {
                                $('#stats-table tbody').append(`
                        <tr>
                            <td>${stat.season}</td>
                            <td>${stat.week}</td>
                            <td>${stat.opponent_team}</td>
                            <td>${stat.fantasy_points}</td>
                        </tr>
                    `);
                            });

                            if (player.position === 'QB') {

                                // Ensure the small table is visible


                                // Fetch current week
                                $.ajax({
                                    url: 'index.php?action=getCurrentNFLWeek',
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        const currentWeek = response.currentWeek;

                                        // Step 2: Get the most recent team for the player
                                        $.ajax({
                                            url: 'index.php?action=getMostRecentTeam',
                                            method: 'GET',
                                            data: {
                                                player_name: playerName
                                            },
                                            dataType: 'json',
                                            success: function(teamResponse) {
                                                const team = teamResponse.recent_team;

                                                if (!team) {
                                                    alert('No recent team data found for ' + playerName);
                                                    return;
                                                }

                                                // Step 3: Get the matchup for the team and current week
                                                $.ajax({
                                                    url: 'index.php?action=getMatchup',
                                                    method: 'GET',
                                                    data: {
                                                        team: team,
                                                        week: currentWeek
                                                    },
                                                    dataType: 'json',
                                                    success: function(matchupResponse) {
                                                        if (matchupResponse == "BYE") {
                                                            $('#small-table').hide();
                                                            $('#qbheading').hide();
                                                            $('#player-info').append(`
                                                <p> </p><br>
                                                <p><strong>Upcoming Opponent:</strong> ${matchupResponse}</p>
                                            `);
                                                        } else {
                                                            console.log(matchupResponse)
                                                            // Display the opponent info in the player-info section
                                                            $('#player-info').append(`
                                                <p> </p><br>
                                                <p><strong>Upcoming Opponent:</strong> ${matchupResponse}</p>
                                            `);
                                                            $('#small-table').show();
                                                            $('#qbheading').show();
                                                            updateHeaders('qb')
                                                            fetchQBStats(playerName, matchupResponse);
                                                            getQBstats(playerName, matchupResponse);

                                                        }
                                                    },
                                                    error: function(error) {
                                                        console.error('Error fetching matchup data:', error);
                                                        $('#matchup-info').html('Error fetching matchup data.');
                                                    }
                                                });
                                            },
                                            error: function(error) {
                                                console.error('Error fetching team data:', error);
                                                $('#matchup-info').html('Error fetching team data.');
                                            }
                                        });
                                    },
                                    error: function(error) {
                                        console.error('Error fetching NFL week:', error);
                                        $('#matchup-info').html('Error fetching NFL week.');
                                    }
                                });
                            } else if (player.position === 'WR') {
                                // Fetch current week
                                $.ajax({
                                    url: 'index.php?action=getCurrentNFLWeek',
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        const currentWeek = response.currentWeek;

                                        // Step 2: Get the most recent team for the player
                                        $.ajax({
                                            url: 'index.php?action=getMostRecentTeam',
                                            method: 'GET',
                                            data: {
                                                player_name: playerName
                                            },
                                            dataType: 'json',
                                            success: function(teamResponse) {
                                                const team = teamResponse.recent_team;

                                                if (!team) {
                                                    alert('No recent team data found for ' + playerName);
                                                    return;
                                                }

                                                // Step 3: Get the matchup for the team and current week
                                                $.ajax({
                                                    url: 'index.php?action=getMatchup',
                                                    method: 'GET',
                                                    data: {
                                                        team: team,
                                                        week: currentWeek
                                                    },
                                                    dataType: 'json',
                                                    success: function(matchupResponse) {
                                                        if (matchupResponse == "BYE") {
                                                            $('#small-table').hide();
                                                            $('#qbheading').hide();
                                                            $('#player-info').append(`
                                                <p> </p><br>
                                                <p><strong>Upcoming Opponent:</strong> ${matchupResponse}</p>
                                            `)
                                                        } else {

                                                            // Display the opponent info in the player-info section
                                                            $('#player-info').append(`
                                                <p> </p><br>
                                                <p><strong>Upcoming Opponent:</strong> ${matchupResponse}</p>
                                            `);
                                                            $('#small-table').show();
                                                            $('#qbheading').show();
                                                            updateHeaders('wr')
                                                            fetchWRStats(playerName, matchupResponse);
                                                        }
                                                    },
                                                    error: function(error) {
                                                        console.error('Error fetching matchup data:', error);
                                                        $('#matchup-info').html('Error fetching matchup data.');
                                                    }
                                                });
                                            },
                                            error: function(error) {
                                                console.error('Error fetching team data:', error);
                                                $('#matchup-info').html('Error fetching team data.');
                                            }
                                        });
                                    },
                                    error: function(error) {
                                        console.error('Error fetching NFL week:', error);
                                        $('#matchup-info').html('Error fetching NFL week.');
                                    }
                                });

                            } else if (player.position === 'RB') {
                                // Fetch current week
                                console.log()
                                $.ajax({
                                    url: 'index.php?action=getCurrentNFLWeek',
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function(response) {
                                        const currentWeek = response.currentWeek;

                                        // Step 2: Get the most recent team for the player
                                        $.ajax({
                                            url: 'index.php?action=getMostRecentTeam',
                                            method: 'GET',
                                            data: {
                                                player_name: playerName
                                            },
                                            dataType: 'json',
                                            success: function(teamResponse) {
                                                const team = teamResponse.recent_team;

                                                if (!team) {
                                                    alert('No recent team data found for ' + playerName);
                                                    return;
                                                }

                                                // Step 3: Get the matchup for the team and current week
                                                $.ajax({
                                                    url: 'index.php?action=getMatchup',
                                                    method: 'GET',
                                                    data: {
                                                        team: team,
                                                        week: currentWeek
                                                    },
                                                    dataType: 'json',
                                                    success: function(matchupResponse) {
                                                        console.log(matchupResponse)
                                                        // Display the opponent info in the player-info section
                                                        if (matchupResponse == "BYE") {
                                                            $('#small-table').hide();
                                                            $('#qbheading').hide();
                                                            $('#player-info').append(`
                                                <p> </p><br>
                                                <p><strong>Upcoming Opponent:</strong> ${matchupResponse}</p>
                                            `)
                                                        } else {

                                                            $('#player-info').append(`
                                                <p> </p><br>
                                                <p><strong>Upcoming Opponent:</strong> ${matchupResponse}</p>
                                            `);

                                                            $('#small-table').show();
                                                            $('#qbheading').show();
                                                            updateHeaders('rb')
                                                            fetchRBStats(playerName, matchupResponse);
                                                        }
                                                    },
                                                    error: function(error) {
                                                        console.error('Error fetching matchup data:', error);
                                                        $('#matchup-info').html('Error fetching matchup data.');
                                                    }
                                                });
                                            },
                                            error: function(error) {
                                                console.error('Error fetching team data:', error);
                                                $('#matchup-info').html('Error fetching team data.');
                                            }
                                        });
                                    },
                                    error: function(error) {
                                        console.error('Error fetching NFL week:', error);
                                        $('#matchup-info').html('Error fetching NFL week.');
                                    }
                                });

                            } else {
                                // Hide and clear the small table if the player is not a QB
                                $('#small-table').hide();
                                $('#small-table tbody').empty();
                                console.log("HElLO")
                            }
                        } else {
                            $('#player-info').html('<p>No player data available.</p>');
                            $('#stats-table tbody').html('<tr><td colspan="4">No data available</td></tr>');
                            // Ensure the small table is hidden and cleared
                            $('#small-table').hide();
                            $('#small-table tbody').empty();
                        }
                    },
                    error: function() {
                        console.error('Error fetching player data.');
                        $('#player-info').html('<p>Error loading player data.</p>');
                        // Ensure the small table is hidden and cleared
                        $('#small-table').hide();
                        $('#small-table tbody').empty();
                    }
                });
            }

            const savePlayerButton = $('#save-player-btn');
            const savedPlayersList = $('#saved-players-list');
            const saveLimitMessage = $('#save-limit-message');

            // Save player button click event
            savePlayerButton.on('click', function() {
                const playerName = $(this).data('player-name');
                //const playerName = savePlayerButton.data('player');


                // Fetch player data via AJAX GET request
                $.ajax({
                    url: 'index.php?action=getPlayerData',
                    method: 'GET',
                    data: {
                        player_name: playerName
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response[0])
                        if (response[0]) {


                            const playerData = response[0]; // Get the first entry
                            console.log(playerData)
                            const playerID = playerData.player_id
                            const position = playerData.position
                            const recent_team = playerData.recent_team



                            // Check if the player is already saved (optional)
                            console.log(savedPlayersList)
                            if (savedPlayersList.find(`li[data-player-name="${playerName}"]`).length > 0) {
                                alert('This player is already saved.');
                                return;
                            }


                            // Send AJAX POST request to save the player
                            $.ajax({
                                url: 'index.php?action=savePlayer', // The URL to save the player
                                method: 'POST',
                                contentType: 'application/json',
                                data: JSON.stringify({
                                    playerID: playerID,
                                    playerName: playerName,
                                    position: position,
                                    team: recent_team,
                                }),
                                success: function(data) {
                                    console.log(data.success)
                                    if (data.success) {
                                        // Add player to saved players list
                                        addPlayerToSavedList(playerID, playerName, position, recent_team);
                                    } else {
                                        alert('Failed to save player');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error:', error);
                                    alert('An error occurred while saving the player');
                                }
                            });
                        } else {
                            alert('Failed to fetch player data');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching player data:', error);
                        alert('An error occurred while fetching the player data');
                    }
                });
            });

            function addPlayerToSavedList(playerID, playerName, playerPosition, playerTeam) {
                // Check the number of saved players and show limit message if necessary
                if (savedPlayersList.children().length >= 5) {
                    saveLimitMessage.show();
                    return;
                }

                // Create a new list item with data attributes
                const playerItem = $('<li>')
                    .addClass('saved-player')
                    .attr('data-player-id', playerID)
                    .attr('data-player-position', playerPosition)
                    .attr('data-player-name', playerName)
                    .attr('data-player-team', playerTeam)
                    .html(`
            <a href="#" class="player-name-link">${playerName}</a>
            <button class="delete-player-btn">Delete</button>
        `);

                // Add event listener for the clickable player name
                const playerNameLink = playerItem.find('.player-name-link');
                playerNameLink.on('click', function(e) {
                    e.preventDefault(); // Prevent default link behavior
                    console.log(`Fetching data for: ${playerName}`);
                    fetchPlayerData(playerName); // Fetch player data on click
                });

                // Add delete button event listener
                const deleteButton = playerItem.find('.delete-player-btn');
                deleteButton.on('click', function() {
                    const playerId = playerItem.data('player-id');
                    const playerName = playerItem.data('player-name');
                    console.log('Deleting Player ID:', playerId, 'Name:', playerName);
                    deletePlayer(playerId, playerItem, playerName);
                });

                // Append the player item to the saved players list
                savedPlayersList.append(playerItem);
            }


            function deletePlayer(playerId, playerItem, playerName) {
                $.ajax({
                    url: 'index.php?action=deletePlayer',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        player_id: playerId,
                        player_name: playerName
                    }),
                    success: function(data) {
                        if (data.success) {
                            // Log successful deletion
                            console.log('Successfully deleted player with ID:', playerId, 'and Name:', playerName);

                            // Remove the specific player item using its data attribute
                            playerItem.remove(); // Directly remove the playerItem DOM element

                            // Check if the list is now under 5 and hide the limit message if needed
                            if (savedPlayersList.children().length < 5) {
                                saveLimitMessage.hide();
                            }
                        } else {
                            // Log the failure
                            console.error('Failed to delete player:', playerId, 'with error message:', data.message);
                            alert('Failed to delete player');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Log detailed error information
                        console.error('AJAX error - Status:', status, 'Error:', error);
                        console.error('Response Text:', xhr.responseText);
                        console.error('Status Code:', xhr.status);
                        console.error('Player ID:', playerId, 'Player Name:', playerName);
                        alert('An error occurred while deleting the player');
                    }
                });
            }



            function getQBstats(playerName, opponent) {
                $.ajax({
                    url: 'index.php?action=getQBStats',
                    method: 'GET',
                    data: {
                        player_name: playerName,
                        opponent: opponent
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            // Initialize totals
                            let totalCompletions = 0;
                            let totalAttempts = 0;

                            // Iterate through the stats array to compute totals
                            response.forEach(stat => {
                                totalCompletions += parseInt(stat.completions || 0, 10);
                                totalAttempts += parseInt(stat.attempts || 0, 10);
                            });

                            console.log('Total Completions:', totalCompletions);
                            console.log('Total Attempts:', totalAttempts);

                            // Generate the QB pie chart with the totals
                            generateQBPieChart(totalCompletions, totalAttempts);
                        } else {
                            alert(response.message || 'No stats found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching QB stats:', error);
                        console.log('Response:', xhr.responseText);
                        $('#qb-stats-body').html('<tr><td colspan="4">Error fetching QB stats.</td></tr>');
                    }
                });
            }



            loadSavedPlayers();

            // Function to load saved players on page load
            function loadSavedPlayers() {
                $.ajax({
                    url: 'index.php?action=getSavedPlayers',
                    method: 'GET',
                    success: function(data) {
                        console.log(data)
                        if (data) {
                            data.forEach(function(player) {
                                addPlayerToSavedList(player.player_id, player.player_name, player.position, player.team);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading saved players:', error);
                    }
                });
            }

        });

        function getMostRecentTeam(playerName) {
            $.ajax({
                url: 'index.php?action=getMostRecentTeam', // Match with your PHP endpoint
                method: 'GET',
                data: {
                    player_name: playerName
                }, // Send playerName as the query parameter
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        console.log(`Most recent team for ${playerName}: ${response.recent_team}`);
                    } else {
                        console.warn(`No recent team data found for ${playerName}.`);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching most recent team:', {
                        status: jqXHR.status,
                        statusText: jqXHR.statusText,
                        responseText: jqXHR.responseText,
                        errorThrown: errorThrown,
                        textStatus: textStatus
                    });
                }
            });
        }

        function displayPlayerMatchup(playerName) {
            // Step 1: Get current NFL week
            $.ajax({
                url: 'index.php?action=getCurrentNFLWeek',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    const currentWeek = response.currentWeek;

                    // Step 2: Get the most recent team for the player
                    $.ajax({
                        url: 'index.php?action=getMostRecentTeam',
                        method: 'GET',
                        data: {
                            player_name: playerName
                        },
                        dataType: 'json',
                        success: function(teamResponse) {
                            const team = teamResponse.recent_team;

                            if (!team) {
                                alert('No recent team data found for ' + playerName);
                                return;
                            }

                            // Step 3: Get the matchup for the team and current week
                            $.ajax({
                                url: 'index.php?action=getMatchup',
                                method: 'GET',
                                data: {
                                    team: team,
                                    week: currentWeek
                                },
                                dataType: 'json',
                                success: function(matchupResponse) {
                                    // Display the opponent info in the player-info section
                                    $('#player-info').append(`
                            
                                <p> </p><br>
                                <p><strong>   Upcoming Opponent:</strong> ${matchupResponse.opponent}</p>
                            `);

                                    // Log the matchup data to the console (optional)
                                    //console.log('Matchup Info:', matchupResponse);
                                },
                                error: function(error) {
                                    console.error('Error fetching matchup data:', error);
                                    $('#matchup-info').html('Error fetching matchup data.');
                                }
                            });
                        },
                        error: function(error) {
                            console.error('Error fetching team data:', error);
                            $('#matchup-info').html('Error fetching team data.');
                        }
                    });
                },
                error: function(error) {
                    console.error('Error fetching NFL week:', error);
                    $('#matchup-info').html('Error fetching NFL week.');
                }
            });
        }

        function fetchQBStats(playerName, opponent) {
            $.ajax({
                url: 'index.php?action=getQBStats',
                method: 'GET',
                data: {
                    player_name: playerName,
                    opponent: opponent
                },
                dataType: 'json',
                success: function(response) {
                    if (response && response.length > 0) {
                        let statsHTML = '';

                        response.forEach(function(stat) {
                            statsHTML += `
                            
                            <tr>
                                <td>${stat.season}</td>
                                <td>${stat.opponent_team}</td>
                                <td>${stat.completions}</td>
                                <td>${stat.attempts}</td>
                                <td>${stat.passing_tds}</td>
                                <td>${stat.fantasy_points}</td>
                            </tr>

                        `;
                        });
                        $('#stats-body').html(statsHTML);
                    } else {
                        $('#stats-body').html('<tr><td colspan="4">No QB stats available for this player and opponent.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching QB stats:', error);
                    console.log('Response:', xhr.responseText);
                    $('#qb-stats-body').html('<tr><td colspan="4">Error fetching QB stats.</td></tr>');
                }
            });
        }

        function fetchRBStats(playerName, opponent) {
            $.ajax({
                url: 'index.php?action=getRBStats',
                method: 'GET',
                data: {
                    player_name: playerName,
                    opponent: opponent
                },
                dataType: 'json',
                success: function(response) {
                    if (response && response.length > 0) {
                        let statsHTML = '';

                        response.forEach(function(stat) {
                            statsHTML += `
                            <tr>
                                <td>${stat.season}</td>
                                <td>${stat.opponent_team}</td>
                                <td>${stat.rushing_yards}</td>
                                <td>${stat.rushing_tds}</td>
                                <td>${stat.receptions}</td>
                                <td>${stat.fantasy_points}</td>
                            </tr>
                        `;
                        });
                        $('#stats-body').html(statsHTML);
                    } else {
                        $('#stats-body').html('<tr><td colspan="4">No RB stats available for this player and opponent.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching QB stats:', error);
                    console.log('Response:', xhr.responseText);
                    $('#qb-stats-body').html('<tr><td colspan="4">Error fetching QB stats.</td></tr>');
                }
            });
        }

        function fetchWRStats(playerName, opponent) {
            $.ajax({
                url: 'index.php?action=getWRStats',
                method: 'GET',
                data: {
                    player_name: playerName,
                    opponent: opponent
                },
                dataType: 'json',
                success: function(response) {
                    if (response && response.length > 0) {
                        let statsHTML = '';

                        response.forEach(function(stat) {
                            statsHTML += `
                            <tr>
                                <td>${stat.season}</td>
                                <td>${stat.opponent_team}</td>
                                <td>${stat.targets}</td>
                                <td>${stat.receptions}</td>
                                <td>${stat.receiving_yards}</td>
                                <td>${stat.receiving_tds}</td>
                                <td>${stat.fantasy_points}</td>
                            </tr>
                        `;
                        });
                        $('#stats-body').html(statsHTML);
                    } else {
                        $('#stats-body').html('<tr><td colspan="4">No WR stats available for this player and opponent.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching QB stats:', error);
                    console.log('Response:', xhr.responseText);
                    $('#qb-stats-body').html('<tr><td colspan="4">Error fetching QB stats.</td></tr>');
                }
            });
        }

        function updateHeaders(position) {
            const qbHeaders = document.getElementById("qb-headers");
            const rbHeaders = document.getElementById("rb-headers");
            const wrHeaders = document.getElementById("wr-headers");
            $('#small-table').show();
            $('#qbheading').show();

            qbHeaders.style.display = "none";
            rbHeaders.style.display = "none";
            wrHeaders.style.display = "none";

            // Show the appropriate header based on the position
            if (position === "qb") {
                $('#qb-chart-container').show();
                qbHeaders.style.display = "table-header-group";
            } else if (position === "rb") {
                $('#qb-chart-container').hide();
                rbHeaders.style.display = "table-header-group";
            } else if (position === "wr") {
                $('#qb-chart-container').hide();
                wrHeaders.style.display = "table-header-group";
            }
        }





        function getPlayerData(playerName, callback) {
            $.ajax({
                url: 'index.php?action=getPlayerData', // Replace with the correct URL
                method: 'GET',
                data: {
                    player_name: playerName
                },
                success: function(response) {
                    // Assuming the response contains an array of player data
                    if (response.success && response.data.length > 0) {
                        const playerData = response.data[0]; // Get the first entry for the player
                        callback({
                            position: playerData.position,
                            recent_team: playerData.recent_team,
                            opponent_team: playerData.opponent_team,
                            fantasy_points: playerData.fantasy_points
                        });
                    } else {
                        callback(null);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching player data:', error);
                    callback(null);
                }
            });
        }

        function generateQBPieChart(completions, attempts) {
            const total = completions + attempts;
            const completionPercentage = ((completions / total) * 100).toFixed(1); // Calculate percentage

            // Get or create the canvas element
            const ctx = document.getElementById('qb-pie-chart').getContext('2d');

            // Destroy existing chart instance if it exists
            if (window.qbPieChart) {
                window.qbPieChart.destroy();
            }

            // Create the pie chart
            window.qbPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Completions', 'Missed'],
                    datasets: [{
                        data: [completions, attempts - completions],
                        backgroundColor: ['#4caf50', '#f44336'], // Green for completions, red for attempts
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const label = tooltipItem.label || '';
                                    const value = tooltipItem.raw;
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        },
                        legend: {
                            display: true, // Show the legend
                            position: 'top'
                        },
                        annotation: {
                            annotations: [{
                                type: 'label',
                                content: `${completionPercentage}%`, // Add percentage in the middle
                                position: 'center',
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                color: '#000'
                            }]
                        }
                    },
                    plugins: {
                        datalabels: {
                            display: false // Hide individual data labels
                        }
                    }
                }
            });
        }


        //fetchRBStats("Saquon Barkley", 'Philadelphia')
        //fetchQBStats('Patrick Mahomes', 'Buffalo');
    </script>

</body>

</html>