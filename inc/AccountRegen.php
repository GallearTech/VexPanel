<?php
session_start();
require '../config.php';
require './functions.php';
require '../vendor/autoload.php';
$pterodactyl = new \HCGCloud\Pterodactyl\Pterodactyl($apikey, $pterodomain);
if(isset($_SESSION['loggedin']) == true) {
    $user = $_SESSION['discord_user'];
    $pterodactyl_panelinfo = $conn->query("SELECT * FROM users WHERE discord_id='" . mysqli_real_escape_string($conn, $user->id) . "'")->fetch_assoc();
    $uid = $pterodactyl_panelinfo['ptero_uid'];
    $name = $pterodactyl_panelinfo['ptero_user'];
  }else{
    header("location: ../login.php");
  }
  $newPwd = generateRandomString(20);
  $user = $pterodactyl->updateUser($uid, [
    'email' => $user->email,
    'username' => $name,
    'password' => $newPwd,
    'language' => 'en',
    'root_admin' => false,
    'first_name' => 'A',
    'last_name' => 'User'
]);

$conn->query("UPDATE users SET ptero_pwd='".mysqli_real_escape_string($conn, $newPwd)."' WHERE discord_id='".mysqli_real_escape_string($conn, $user->id)."'");
header("location: ../account.php");