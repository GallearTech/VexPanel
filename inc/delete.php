<?php
session_start();
require "../config.php";
require "./functions.php";
require '../vendor/autoload.php';
$pterodactyl = new \HCGCloud\Pterodactyl\Pterodactyl($apikey, $pterodomain);

$addSlots = "1";
if(isset($_SESSION['loggedin']) == true) {
$user = $_SESSION['discord_user'];
$pterodactyl_panelinfo = $conn->query("SELECT * FROM users WHERE discord_id='" . mysqli_real_escape_string($conn, $user->id) . "'")->fetch_assoc();
$userid = $pterodactyl_panelinfo['ptero_uid'];
$usercoins = $pterodactyl_panelinfo['coins'];
} else {
    notloggedin("You must be logged in.");
}
if( !isset($_GET['id']) || empty($_GET['id']) ) {
    header("Location: ../");
    die();
}
$checkperms = $conn->query("SELECT * FROM servers WHERE owner_id='" . mysqli_real_escape_string($conn, $user->id) . "' AND server_id=" . mysqli_real_escape_string($conn, $_GET['id']));
if( $checkperms->num_rows == 0 ) {
    die("You don't have permissions to delete this server or this server doesn't exists.");
}
$conn->query("UPDATE users SET coins='" . mysqli_real_escape_string($conn, $usercoins + 1) . "' WHERE discord_id='".mysqli_real_escape_string($conn, $user->id)."'");
$pterodactyl->forceDeleteServer($_GET['id']);
$conn->query("DELETE FROM servers WHERE server_id=" . mysqli_real_escape_string($conn, $_GET['id']));
header("location: ../?error=deletedserver");