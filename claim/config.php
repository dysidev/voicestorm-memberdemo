<?php

if($_SERVER['REQUEST_METHOD']=="GET")
{
	header('Location: index.php'); die();
}

$ACCESS="T2W2fbobFkyRvzeKxr3bYZvAKR5J3bdK";
$SECRET= "qk4_sHQ3q0CZrtX8DrwkK8nANTllzmVO";
$BASE_URL="https://publicmanagerdemo.voicestorm.com/v1";

$LOG_FILE="log.txt";

?>