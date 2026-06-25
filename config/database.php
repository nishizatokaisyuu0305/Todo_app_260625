<?php

$host = "127.0.0.1";
$dbname = "todo_app";
$user = "root";
$password = "";

try {
  $pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $user,
    $password
  );

  $pdo->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
  );

} catch (PDOException $e) {
  die("接続失敗: " . $e->getMessage());
}