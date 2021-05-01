<?php
require '../config.php';
$userInfo = $conn->query("SELECT * FROM users");
if($userInfo->num_rows == 0){
    echo 'There are currently **no** users using this hosting...';
}else{
    echo 'There are **'. $userInfo->num_rows . '** users signed up here!';
}