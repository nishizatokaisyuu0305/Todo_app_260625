<?php

session_start();
// 未ログイン制限
if (!isset($_SESSION["user_id"])) {
  header("Location: login_form.php");
  exit;
}

// csrf検証
require_once __DIR__ . "/../includes/csrf.php";
verifyCsrfToken();

require_once __DIR__ . "/../config/database.php";
// ID取得・存在チェック(バリデーション)
if (!isset($_POST["id"])) {
  header("Location: index.php");
  exit;
}
$id = (int)($_POST["id"] ?? 0);


// 存在チェック
require_once __DIR__ . "/../models/TodoModel.php";
$todoModel = new TodoModel($pdo);

$todo = $todoModel->findById(
  $id,
  $_SESSION["user_id"]
);

if (!$todo) {
  $_SESSION["flash"] = [
    "type" => "error",
    "message" => "対象のTodoが存在しません"
  ];

  header("Location: index.php");
  exit;
}

// 削除
$todoModel->delete(
  $id,
  $_SESSION["user_id"]
);

// 成功メッセージ
$_SESSION["flash"] = [
  "type" => "success",
  "message" => "タスクを削除しました"
];

// リダイレクト
header("Location: index.php");
exit;