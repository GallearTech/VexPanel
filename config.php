<?php
$siteName = 'Vex Panel';
$sitePassword = 'Your Sites Password!'; //Used for upcoming API features (bot)

$oauth_id = '123456789'; // Discord oAuth2 id
$oauth_secret = 'supersecretkey'; // Discord oAuth2 secret
$oauth_url = 'http://localhost/discord.php'; //This is an example
$apikey = 'pterodactylapikey'; // Pterodactyl API Key
$pterodomain = 'pterodactyldomain'; // Pterodactyl Domain

$discordLog = 'true';
$discord_log = 'DISCORD WEBHOOK URL';
$discordBotToken = ''; //Must be in the same application as the oauth system
$guildID = ''; //Autojoin discord server guild id

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
$version = '0.8.9 BETA';