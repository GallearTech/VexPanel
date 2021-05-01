<?php
require '../config.php';
$userInfo = $conn->query("SELECT * FROM servers");
if($userInfo->num_rows == 0){
    echo 'There are currently **no** servers hosted here...';
}else{
    echo 'There are **'. $userInfo->num_rows . '** servers hosted here!';
}