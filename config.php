<?php
$oauth_id = '123456789'; // Discord oAuth2 id
$oauth_secret = 'supersecretkey'; // Discord oAuth2 secret
$oauth_url = 'http://localhost/discord.php'; //This is an example
$apikey = 'pterodactylapikey'; // Pterodactyl API Key
$pterodomain = 'pterodactyldomain'; // Pterodactyl Domain

$discordLog = 'true';
$discord_log = 'DISCORD WEBHOOK URL';

$serverName = "";
$dBUsername = "";
$dBPassword = "";
$dBName = "";
$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);
if (!$conn){
	die("Connection Failed. " . mysqli_connect_error());
}


// Do NOT edit below this point.
// Below this point is for contributors, and to gain faster support.
$version = '0.2.5.1 BETA';