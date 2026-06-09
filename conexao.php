<?php

// $pdo = new PDO('mysql:host=localhost;dbname=sistema_sade;charset=utf8mb4', 'root', '');


$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: '3306';
$db   = getenv('DB_NAME') ?: 'sistema_sade';
$user = getenv('DB_USER') ?: 'sade_user';
$pass = getenv('DB_PASSWORD') ?: 'sade_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::ATTR_EMULATE_PREPARES   => false,
];

// Retry loop to handle DB startup timing
$maxAttempts = 15;
$attempt = 0;
while (true) {
     try {
          $pdo = new PDO($dsn, $user, $pass, $options);
          break;
     } catch (\PDOException $e) {
          $attempt++;
          if ($attempt >= $maxAttempts) {
               throw new \PDOException($e->getMessage(), (int)$e->getCode());
          }
          sleep(2);
     }
}
