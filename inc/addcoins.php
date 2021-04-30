<?php
require '../config.php';
require './functions.php';
if( checklogin() == true ) {
	$user = $_SESSION['discord_user'];
	$pterodactyl_panelinfo = $conn->query("SELECT * FROM users WHERE discord_id='" . mysqli_real_escape_string($conn, $_POST['did']) . "'")->fetch_assoc();
    $coins = $pterodactyl_panelinfo['coins'];
}else{
  header("location: ./login.php");
}

if(isset($_POST['submit'])){
$pcoins = $_POST['coins'];
$coinsnow = mysqli_query($conn, "SELECT * FROM users WHERE discord_id='" . mysqli_real_escape_string($conn, $user->id) . "'");
$conn->query("UPDATE users SET coins='".mysqli_real_escape_string($conn, $coinsnow + $pcoins)."' WHERE discord_id='".mysqli_real_escape_string($conn, $_POST['did'])."'");
header("location: ../admin");
}else{
    header("location: ../admin/resources.php");
}