<?php
$t=time();
require './config.php';
require './inc/functions.php';
$userip = getUserIP();
require './vendor/autoload.php';
$pterodactyl = new \HCGCloud\Pterodactyl\Pterodactyl($apikey, $pterodomain);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

$authorizeURL = 'https://discord.com/api/oauth2/authorize';
$tokenURL = 'https://discord.com/api/oauth2/token';
$apiURLBase = 'https://discord.com/api/users/@me';

session_start();

// Start the login process by sending the user to Discord's authorization page
if(get('action') == 'login') {

  $params = array(
    'client_id' => $oauth_id,
    'redirect_uri' => $oauth_url,
    'response_type' => 'code',
    'scope' => 'identify guilds email guilds.join'
  );

  // Redirect the user to Discord's authorization page
  header('Location: https://discord.com/api/oauth2/authorize' . '?' . http_build_query($params));
  die();
}


// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if(get('code')) {

  // Exchange the auth code for a token
  $token = apiRequest($tokenURL, array(
    "grant_type" => "authorization_code",
    'client_id' => $oauth_id,
    'client_secret' => $oauth_secret,
    'redirect_uri' => $oauth_url,
    'code' => get('code')
  ));
  $logout_token = $token->access_token;
  $_SESSION['access_token'] = $token->access_token;


  header('Location: ' . $_SERVER['PHP_SELF']);
}

if(session('access_token')) {
  $user = apiRequest($apiURLBase);

  $dbcheck = $conn->query("SELECT * FROM users WHERE discord_id='".$user->id."'");
  if($dbcheck->num_rows == 0){
    //JoinGuild(session('access_token'), $guildID, $user->id, $discordBotToken);
    $ptero_user = generateRandomString(10);
    $ptero_pwd1 = generateRandomString(20);
    $ptero_pwd = base64_encode($ptero_pwd1);
    try {
        $ptuser = $pterodactyl->createUser([
            'email' => $user->email,
            'username' => $ptero_user,
            'password' => $ptero_pwd1,
            'language' => 'en',
            'root_admin' => false,
            'first_name' => 'A',
            'last_name' => 'User'
        ]);
        $conn->query("INSERT INTO users (discord_user, discord_id, discord_email, ptero_user, ptero_pwd, ptero_uid, signup_ip, last_ip, minutes_idle, coins, last_seen, user_roles, ram, cpu, disk_space, server_slots) VALUES ('".mysqli_real_escape_string($conn, $user->username)."', '".mysqli_real_escape_string($conn, $user->id)."', '".mysqli_real_escape_string($conn, $user->email)."', '".mysqli_real_escape_string($conn, $ptero_user)."', '".mysqli_real_escape_string($conn, $ptero_pwd)."', '".mysqli_real_escape_string($conn, $ptuser->id)."', '".mysqli_real_escape_string($conn, $userip)."', '".mysqli_real_escape_string($conn, $userip)."', '0', '0', '".mysqli_real_escape_string($conn, $t)."', '0', '0', '0', '0', '0')");
        $_SESSION['discord_user'] = $user;
        $_SESSION['loggedin'] = true;
        if($discordLog === 'true'){
          LoginLog($discord_log);
      }
        header("location: ./");
        die();
    } catch(\HCGCloud\Pterodactyl\Exceptions\ValidationException $e){
        print_r($e->errors());
    }
  }else{
    //JoinGuild(session('access_token'), $guildID, $user->id, $discordBotToken);
    $_SESSION['discord_user'] = $user;
    $_SESSION['loggedin'] = true;
    if($discordLog === 'true'){
      LoginLog($discord_log);
    }
    header("location: ./");
    die();
  }

} else {
  header("location: ./discord.php?action=login");
}


if(get('action') == 'logout') {
  // This must to logout you, but it didn't worked(

  $params = array(
    'access_token' => $logout_token
  );

  // Redirect the user to Discord's revoke page
  header('Location: https://discord.com/api/oauth2/token/revoke' . '?' . http_build_query($params));
  die();
}

function apiRequest($url, $post=FALSE, $headers=array()) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

  $response = curl_exec($ch);


  if($post)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

  $headers[] = 'Accept: application/json';

  if(session('access_token'))
    $headers[] = 'Authorization: Bearer ' . session('access_token');

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);
  return json_decode($response);
}

function get($key, $default=NULL) {
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default=NULL) {
  return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}
  function LoginLog($webhookurl1){
require './config.php';
$user = $_SESSION['discord_user'];


    $webhookurl = "$webhookurl1";
    $timestamp = date("c", strtotime("now"));
    $json_data = json_encode([
        "username" => "Login Logs",
        "tts" => false,
        "embeds" => [
            [
                "title" => "Login Logs",
                "type" => "rich",
                "description" => "The user `$user->username` with the ID of `$user->id` just signed in.",
            ]]
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    $ch = curl_init( $webhookurl );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec( $ch );
    curl_close( $ch );
    };
    /*
    REMOVED FOR A ISSUE
    function JoinGuild($access_token, $guild, $user_id, $token) {

      $data = json_encode(array("access_token" => $access_token));
      $url = "https://discord.com/api/guilds/" . $guild . "/members/" . $user_id;
      $headers = array ('Content-Type: application/json', 'Authorization: Bot '.$token);
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      $response = curl_exec($curl);
      curl_close($curl);
      $results = json_decode($response, true);
      print_r($results);
      echo $url;
    
    }*/
?>