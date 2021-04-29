<?php
require '../config.php';
$userInfo = $conn->query("SELECT * FROM users WHERE discord_id='".$_GET['did']."'")->fetch_assoc();
if($userInfo->num_rows = 0){
    echo '`**USER NOT FOUND**`';
}
$userCoins = $userInfo['coins'];
echo $userCoins;