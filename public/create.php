<?php

session_start();
// csrf検証
verifyCsrfToken();
require_once __DIR__ . "/../config/database.php";


// title, due_date, category, priority取得
$title = trim($_POST["title"]);
$dueDate = $_POST["due_date"] ?: null;
$category = $_POST["category"] ?: null;
$priority = $_POST["priority"] ?? "低";

// バリデーション（空白チェック）
if ($title === "") {
  $_SESSION["flash"] = [
    "type" => "error",
    "message" => "タイトルを入力してください"
  ];

  header("Location: index.php");
  exit;
}


// 重複チェック
require_once __DIR__ . "/../models/TodoModel.php";
$todoModel = new TodoModel($pdo);

if (
  $todoModel->existsByTitle(
    $title,
    $_SESSION["user_id"]
  )
) {
  $_SESSION["flash"] = [
    "type" => "error",
    "message" => "同じTodoが既に存在します"
  ];

  header("Location: index.php");
  exit;
}


// 登録
$todoModel->create(
  $title,
  $dueDate,
  $category,
  $priority,
  $_SESSION["user_id"]
);


// 成功メッセージ
$_SESSION["flash"] = [
  "type" => "success",
  "message" => "タスクを追加しました"
];

header("Location: index.php");
exit;