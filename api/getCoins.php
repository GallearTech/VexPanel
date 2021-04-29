<?php
require '../config.php';
$userInfo = $conn->query("SELECT * FROM users WHERE discord_id='".$_GET['did']."'")->fetch_assoc();
$userCoins = $userInfo['coins'];
echo $userCoins;