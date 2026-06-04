<?php
$host = 'localhost';
$dbname = 'sistema_gestao';
$username = 'root';
$password = '';    

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password,);
