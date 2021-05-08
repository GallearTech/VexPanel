<?php
session_start();
require '../config.php';
require './functions.php';
require '../vendor/autoload.php';
$pterodactyl = new \HCGCloud\Pterodactyl\Pterodactyl($apikey, $pterodomain);
if(isset($_SESSION['loggedin']) == true) {
    $user = $_SESSION['discord_user'];
    $pterodactyl_panelinfo = $conn->query("SELECT * FROM users WHERE discord_id='" . mysqli_real_escape_string($conn, $user->id) . "'")->fetch_assoc();

  }else{
    header("location: ../login.php");
  }
  $staffcheck = $conn->query("SELECT * FROM staff WHERE discord_id='".mysqli_real_escape_string($conn, $user->id)."'")->fetch_assoc();
  $level4 = $staffcheck['staff_level'];
  if($level4 = 4){
  if(isset($_POST['submit'])){
      $conn->query("INSERT INTO products (product_name, product_desc, product_price, product_stock, product_ram, product_cpu, product_disk, nest_id, egg_id) VALUES ('".mysqli_real_escape_string($conn, $_POST['name'])."', '".mysqli_real_escape_string($conn, $_POST['desc'])."', '".$_POST['price']."', '".$_POST['stock']."', '".$_POST['ram']."', '".$_POST['cpu']."', '".$_POST['disk_space']."', '".$_POST['nestid']."', '".$_POST['eggid']."')");
      Success('../admin', 'Product added!');
  }else{
    Error('../admin', 'You didn\'t access that page with a post request!');
  }}else{
    Error('../admin', 'You don\'t have SPA level 4!'); 
  }