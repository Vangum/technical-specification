<?php
$host = "localhost";
$dbname = "technical_specification";
$user = "root";
$password = "root";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}