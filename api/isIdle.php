<?php
require '../config.php';
$userInfo = $conn->query("SELECT * FROM users WHERE discord_id='".mysqli_real_escape_string($conn, $_GET['did'])."'")->fetch_assoc();
$checkDB = $conn->query("SELECT * FROM users WHERE discord_id='".mysqli_real_escape_string($conn, $_GET['did'])."'");
if($checkDB->num_rows == 0){
    echo '**USER NOT FOUND**';
}
$userLastSeen = $userInfo['last_seen'];
$idlecheck = $userLastSeen + 60;

$currenttime = new DateTime();
$currenttimestamp = $currenttime->getTimestamp();
if($idlecheck >= $currenttimestamp){
echo 'are';
}else{
    echo 'are not';
}