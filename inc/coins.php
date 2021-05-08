<?php
session_start();
require '../config.php';
require './functions.php';
if(isset($_SESSION['loggedin']) == true) {
	$user = $_SESSION['discord_user'];

	$pterodactyl_panelinfo = $conn->query("SELECT * FROM users WHERE discord_id='" . mysqli_real_escape_string($conn, $user->id) . "'")->fetch_assoc();
  $coins = $pterodactyl_panelinfo['coins'];
  $idlemins = $pterodactyl_panelinfo['minutes_idle'];
  $lastseen = $pterodactyl_panelinfo['last_seen'];

  $idlecheck = $lastseen + 60;

  $currenttime = new DateTime();
  $currenttimestamp = $currenttime->getTimestamp();
}else{
  header("location: ./login.php");
}

if ($idlecheck <= $currenttimestamp) {
    $conn->query("UPDATE users SET coins='".mysqli_real_escape_string($conn, $coins + 1)."' WHERE discord_id='".mysqli_real_escape_string($conn, $user->id)."'");
    $conn->query("UPDATE users SET minutes_idle='".mysqli_real_escape_string($conn, $idlemins + 1)."' WHERE discord_id='".mysqli_real_escape_string($conn, $user->id)."'");
    $conn->query("UPDATE users SET last_seen='".mysqli_real_escape_string($conn, $currenttimestamp)."' WHERE discord_id='".mysqli_real_escape_string($conn, $user->id)."'");
    header("location: ../idle.php");
}else{
    die("Please don't try to get more coins by exploiting!");
}