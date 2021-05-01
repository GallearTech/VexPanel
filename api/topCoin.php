<?php
require '../config.php';
$result = mysqli_query($conn, "SELECT discord_user, coins FROM users ORDER BY coins DESC LIMIT 1"); 
if (mysqli_num_rows($result)) { 
    while ($row = mysqli_fetch_array($result)) { 
        echo htmlspecialchars($row['discord_user']) . ' has **'. htmlspecialchars(round($row['coins'])).'** coins!';
    } 
} 