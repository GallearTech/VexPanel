<?php
require '../config.php';
$userInfo = $conn->query("SELECT * FROM staff WHERE discord_id='".$_GET['did']."'");
if($userInfo->num_rows == 1){
    echo '**is a**';
}else{
    echo '**is not a**';
}