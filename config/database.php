<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'rusyrichter@gmail.com');
define('DB_PASSWORD', '-9cJR/W!6iik34Mf');
define('DB_NAME', 'Bookmarks');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if($conn->connect_error){
    die('Connection Faled ' . $conn->connect_error);
}
?>