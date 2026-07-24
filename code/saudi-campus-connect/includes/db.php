<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'saudi_campus_connect';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    exit('The website cannot connect to the database right now. Please check the local server settings.');
}

mysqli_set_charset($conn, 'utf8mb4');
