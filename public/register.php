<?php

session_start();
// CSRF検証
verifyCsrfToken();
require_once __DIR__ . "/../config/database.php";

// name, email, password取得
$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);

// 登録処理
$passwordHash = password_hash(
  $_POST["password"],
  PASSWORD_DEFAULT
);

// 保存
$sql = "insert into users(name,email,password) values (?,?,?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$name,$email,$passwordHash]);



header("Location: login_form.php");
exit;