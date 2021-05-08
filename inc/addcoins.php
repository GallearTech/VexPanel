<?php
require '../config.php';
require './functions.php';
if(isset($_SESSION['loggedin']) == true) {
	$user = $_SESSION['discord_user'];
	$pterodactyl_panelinfo = $conn->query("SELECT * FROM users WHERE discord_id='" . mysqli_real_escape_string($conn, $_POST['did']) . "'")->fetch_assoc();
    $coins = $pterodactyl_panelinfo['coins'];
}else{
  header("location: ./login.php");
}
if(isset($_POST['submit'])){
$pcoins = $_POST['coins'];
$conn->query("UPDATE users SET coins='".mysqli_real_escape_string($conn, $coins + $_POST['coins'])."' WHERE discord_id='".mysqli_real_escape_string($conn, $user->id)."'");
header("location: ../admin");
}else{
    header("location: ../admin/resources.php");
}