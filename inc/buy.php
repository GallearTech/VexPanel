<?php
session_start();
require '../config.php';
require './functions.php';
if(isset($_SESSION['loggedin']) == true) {
	$user = $_SESSION['discord_user'];
	$pterodactyl_panelinfo = $conn->query("SELECT * FROM users WHERE discord_id='" . mysqli_real_escape_string($conn, $user->id) . "'")->fetch_assoc();
    $userid = $pterodactyl_panelinfo['ptero_uid'];
    $usercoins = $pterodactyl_panelinfo['coins'];
}else{
  header("location: ../login.php");
}
require '../vendor/autoload.php';
$pterodactyl = new \HCGCloud\Pterodactyl\Pterodactyl($apikey, $pterodomain);

if($_GET['id'] === null){
    header("location: ../order.php?null1");
}
if($_GET === null){
    header("location: ../order.php?null");
}

$prodid = $_GET['id'];

$prodinfo = $conn->query("SELECT * FROM products WHERE id='".mysqli_real_escape_string($conn, $prodid)."'")->fetch_assoc();
$prodprice = $prodinfo['product_price'];
$prodegg = $prodinfo['egg_id'];
$prodnest = $prodinfo['nest_id'];
$prodstock = $prodinfo['product_stock'];
$prodram = $prodinfo['product_ram'];
$prodcpu = $prodinfo['product_cpu'];
$proddisk = $prodinfo['product_disk'];
$one = 1;

if($prodstock < 0){
    header("location: ../order.php?no-more-stock");
    die();
}
if($prodstock == 0){
    header("location: ../order.php?no-more-stock1");
    die();
}
if($prodprice > $usercoins){
    header("location: ../order.php?prodpriceismore");
    die();
}
if($usercoins == 0){
    header("location: ../order.php?no-coins");
    die();
}

$nest_id = $prodnest;
$egg_id = $prodegg;
$location_id = 1;
$egg = $pterodactyl->egg($nest_id, $egg_id); //get docker_image and startup directly from egg
try{
$server = $pterodactyl->createServer([
    "name" => $user->username.'\'s Server',
    "user" => $userid,
    "egg" => $egg_id,
    "docker_image" => $egg->dockerImage,
    "skip_scripts" => false,
    "environment" => [
        "SERVER_AUTOUPDATE" => '1',
        "BUILD_NUMBER" => 'latest',
        "SERVER_JARFILE" => 'server.jar',
        "BUNGEE_VERSION" => 'latest',
        "VANILLA_VERSION" => 'latest',
        "PMMP_VERSION" => 'latest',
        "NUKKIT_VERSION" => 'latest',
        "BEDROCK_VERSION" => 'latest',
        "AUTO_UPDATE" => '1',
        "USER_UPLOAD" => '1',
        "BOT_JS_FILE" => 'index.js',
        "BOT_PY_FILE" => 'index.py',
        "MAX_USERS" => "100",
        "MUMBLE_VERSION" => "1.2.19",
        "TS_VERSION" => "latest",
        "FILE_TRANSFER" => "30033",
        "BUILD_TYPE" => "recommended",
        "FORGE_VERSION" => "1.16.4-35.0.18",
        "MC_VERSION" => "latest",
        "SPONGE_VERSION" => "latest",
    ],
    "limits" => [
        "memory" => $prodram,
        "swap" => 0,
        "disk" => $proddisk,
        "io" => 500,
        "cpu" => $prodcpu
    ],
    "feature_limits" => [
        "databases" => 0,
        "allocations" => 0,
        "backups" => 0 
    ],
    "startup" => $egg->startup,
    "description" => "",
    "deploy" => [
        "locations" => [$location_id],
        "dedicated_ip" => false,
        "port_range" => []
    ],
    "start_on_completion" => true
]);
$conn->query("INSERT INTO servers (server_id, server_name, ram, cpu, disk_space, owner_id, node_id) VALUES ('".$server->id."', '".mysqli_real_escape_string($conn, $server->name)."', '".$prodram."', '".$prodcpu."', '".$proddisk."', '".mysqli_real_escape_string($conn, $user->id)."', '".$server->node."')");
$conn->query("UPDATE users SET coins='".mysqli_real_escape_string($conn, $usercoins - $prodprice)."' WHERE discord_id='".mysqli_real_escape_string($conn, $user->id)."'");
$conn->query("UPDATE products SET product_stock='".mysqli_real_escape_string($conn, $prodstock - '1')."' WHERE id='".mysqli_real_escape_string($conn, $_GET['id'])."'");
header("location: ../");
die();
} catch(\HCGCloud\Pterodactyl\Exceptions\ValidationException $e){
    print_r($e->errors());
}

echo '<p><b>If your seeing this page with no other content, please talk to support!</b></p>';