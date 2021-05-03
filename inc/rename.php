<?php
require '../config.php';
require './functions.php';
if( checklogin() == true ) {
  $user = $_SESSION['discord_user'];

  $pterodactyl_panelinfo = $conn->query("SELECT * FROM users WHERE discord_id='" . mysqli_real_escape_string($conn, $user->id) . "'")->fetch_assoc();
}else{
  header("location: ../login.php");
}

if(isset($_POST['submit'])){
$newname = $_POST['name'];
$checkperms = $conn->query("SELECT * FROM servers WHERE owner_id='" . mysqli_real_escape_string($conn, $user->id) . "' AND id=" . mysqli_real_escape_string($conn, $_GET['id']));
if( $checkperms->num_rows == 0 ) {
    die("You don't have permissions to delete this server or this server doesn't exists.");
}
$conn->query("UPDATE servers SET server_name='".mysqli_real_escape_string($conn, $newname)."' WHERE id='".mysqli_real_escape_string($conn, $_POST['id'])."'");
header("location: ../");
}else{
    header("location: ../");
}