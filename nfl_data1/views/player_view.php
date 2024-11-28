<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Fantasy Points</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Search Player Fantasy Points</h1>
    <form id="playerForm">
        <input type="text" id="player_name" name="player_name" placeholder="Enter Player Name" required>
        <button type="submit">Get Fantasy Points</button>
    </form>
    <div id="result"></div>

    <script>
        $(document).ready(function () {
            $('#playerForm').on('submit', function (event) {
                event.preventDefault(); // Prevent traditional form submission

                const playerName = $('#player_name').val().trim();
                if (!playerName) {
                    alert('Please enter a player name.');
                    return;
                }

                // AJAX GET request to fetch fantasy points
                $.ajax({
                    url: 'index.php',
                    method: 'GET',
                    data: { player_name: playerName },
                    dataType: 'json',
                    success: function (data) {
                        $('#result').empty(); // Clear previous results

                        if (data.length > 0) {
                            // Build the table dynamically
                            let tableHtml = `
                                <h2>Fantasy Points for ${playerName}</h2>
                                <table border="1">
                                    <thead>
                                        <tr>
                                            <th>Week</th>
                                            <th>Fantasy Points</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            `;
                            data.forEach(row => {
                                tableHtml += `
                                    <tr>
                                        <td>${row.week}</td>
                                        <td>${row.fantasy_points || '-'}</td>
                                    </tr>
                                `;
                            });
                            tableHtml += '</tbody></table>';
                            $('#result').append(tableHtml);
                        } else {
                            $('#result').append('<p>No fantasy points found for the specified player.</p>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error Status:', status);
                        console.error('Error Message:', error);
                        console.error('Response Text:', xhr.responseText);
                        alert('An error occurred while fetching player data. Check the console for details.');
                    }
                });
            });
        });
    </script>
</body>
</html>
