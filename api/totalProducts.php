<?php
require '../config.php';
$userInfo = $conn->query("SELECT * FROM products");
if($userInfo->num_rows == 0){
    echo 'There are currently no products...';
}else{
    echo 'There are a total of **'.$userInfo->num_rows. '** products!';   
}