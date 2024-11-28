<?php if (isset($playerStats) && !empty($playerStats)): ?>
    <h2>Stats for <?php echo htmlspecialchars($playerStats[0]['player_display_name']); ?></h2>
    <table border="1">
        <thead>
            <tr>
                <th>Week</th>
                <th>Position</th>
                <th>Team</th>
                <th>Stat</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($playerStats as $row): ?>
                <?php 
                    $stats = json_decode($row['stats'], true); // Decode JSON stats
                    if ($stats) {
                        foreach ($stats as $key => $value): 
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['week']); ?></td>
                    <td><?php echo htmlspecialchars($row['position']); ?></td>
                    <td><?php echo htmlspecialchars($row['team']); ?></td>
                    <td><?php echo htmlspecialchars($key); ?></td>
                    <td><?php echo htmlspecialchars($value); ?></td>
                </tr>
                <?php endforeach; } ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No stats found for the specified player.</p>
<?php endif; ?>
