
<?php
//session_start(); - commented! use session_start() on the files you want.

function checklogin() {
	if( isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true ) {
		return true;
	} else {
		return false;
	}
}

function notloggedin($customMessage = false) {
	if( $customMessage == false ) {
		header("Location: /");
		die();
	} else {
		die($customMessage);
	}
}

function ShowError($msg) {
	header("Location: /?error=" . base64_encode($msg));
	die();
}

function ShowSuccess($msg) {
	header("Location: /?success=" . base64_encode($msg));
	die();
}

function isProxy($ip) {
	$d = file_get_contents("https://db-ip.com/" . $ip);
	$hosting = false;
	$proxy = false;
	if(strpos($d, 'Hosting') !== false) {
		$hosting = true;
	}
	if(strpos($d, 'This IP address is used by a proxy') !== false) {
		$proxy = true;
	}
	if( $hosting == true || $proxy == true ) {
		return true;
	} else {
		return false;
	}
}

function getUserIP() {
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function pingAddress($ip) {
    $pingresult = exec("/bin/ping -n 3 $ip", $outcome, $status);
    if (0 == $status) {
        $status = "alive";
    } else {
        $status = "dead";
    }
    echo "The IP address, $ip, is  ".$status;
}

    function pinger($address){
        if(strtolower(PHP_OS)=='winnt'){
            $command = "ping -n 1 $address";
            exec($command, $output, $status);
        }else{
            $command = "ping -c 1 $address";
            exec($command, $output, $status);
        }
        if($status === 0){
            return true;
        }else{
            return false;
        }
    }

    function usersonline() {  
      // Time in seconds that user is assumed to visit site  
      $timeout = 300;  
      // Insert users ip into table  
      mysql_query("INSERT INTO usersonline  
                 VALUES(  
                        '',  
                        '".getUserIP()."',  
                        UNIX_TIMESTAMP()  
                        )  
                 ") or die(mysql_error());  
      // Delete timed out records in table  
      $deadline = time() - $timeout;  
      mysql_query("DELETE FROM usersonline WHERE time < '".$deadline."'") or die(mysql_error());  
      // Query table for distinct IP's and return result  
      $result = mysql_query("SELECT DISTINCT ip FROM usersonline") or die(mysql_error());  
      return mysql_num_rows($result);  
    }  

    function Error($link, $msg) {
        header("Location: ".$link."/?error=" . base64_encode($msg));
        die();
    }
    function Success($link, $msg) {
        header("Location: ".$link."/?success=" . base64_encode($msg));
        die();
    }
?>
