<?php

session_start();

// CSRF検証
verifyCsrfToken();
require_once __DIR__ . "/../config/database.php";


// パスワード照合
$email = trim($_POST["email"]);
$password = $_POST["password"];
$sql = "select * from users where email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (
  $user &&
  password_verify($password, $user["password"])
) {
  $_SESSION["user_id"] = $user["id"];
  $_SESSION["user_name"] = $user["name"];
  $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

  header("Location: index.php");
  exit;
}

$_SESSION["flash"] = [
  "type" => "error",
  "message" => "メールアドレスまたはパスワードが正しくありません"
];


header("Location: login_form.php");
exit;