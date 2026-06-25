<?php

session_start();

// csrf検証
require_once __DIR__ . "/../includes/csrf.php";
verifyCsrfToken();

// セッション削除
$_SESSION = [];

// ブラウザ側セッションIDクッキーを削除
if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();

  setcookie(
    session_name(),
    '',
    time() - 420000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]
  );
}

session_destroy();


header("Location: login_form.php");
exit;