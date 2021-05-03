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
$conn->query("UPDATE servers SET server_name='".mysqli_real_escape_string($conn, $newname)."' WHERE server_id='".mysqli_real_escape_string($conn, $_POST['id'])."'");
header("location: ../admin");
}else{
    header("location: ../admin/resources.php");
}