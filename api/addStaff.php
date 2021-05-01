<?php
require '../config.php';
$newStaffID = $_GET['did'];
$requstAPI = $_GET['api'];
$staffLevel = $_GET['level'];
$userID = $_GET['req'];

$checkdbForUser = $conn->query("SELECT * FROM staff WHERE discord_id='".mysqli_real_escape_string($conn, $userID)."'");
if($checkdbForUser->num_rows == 0){
    echo 'Uh oh! You don\'t show up as a staff on our system. Please contact support if this is a mistake.';
}else{
    $checkDBPerms = $conn->query("SELECT * FROM staff WHERE discord_id='".mysqli_real_escape_string($conn, $userID)."'")->fetch_assoc();
    $staffLevel1 = $checkDBPerms['staff_level'];
    if($staffLevel1 == 4){
        $checkDB = $conn->query("SELECT * FROM staff WHERE discord_id='".mysqli_real_escape_string($conn, $newStaffID)."'");
if($checkDB->num_rows == 1){
    echo 'Seems the user is already in the database!';
}else{
    if($requstAPI != $sitePassword){
        echo 'The API key set on the bot is different from the password on your website. Please run `vp.setapi <client url> <site password>` and try this command again!';
    }
    $conn->query("INSERT INTO staff (discord_id, staff_level) VALUES ('".mysqli_real_escape_string($conn, $newStaffID)."', '".mysqli_real_escape_string($conn, $staffLevel)."')");
    echo 'Congrats <@!'.$newStaffID.'>! You are now a staff member. You got staff level '.$staffLevel.'!';
}
    }else{
        echo 'Sorry, you don\'t have permissions to add a user as a staff on the client area.';
    }
}
