<?php
require '../config.php';
$userInfo = $conn->query("SELECT * FROM users WHERE discord_id='".$_GET['did']."'")->fetch_assoc();
$checkDB = $conn->query("SELECT * FROM users WHERE discord_id='".$_GET['did']."'");
if($checkDB->num_rows == 0){
    echo '**USER NOT FOUND**';
}
$idleTime = $userInfo['minutes_idle'];
echo $idleTime;