<?php

session_start();
// csrf検証
require_once __DIR__ . "/../includes/csrf.php";
verifyCsrfToken();

require_once __DIR__ . "/../config/database.php";

// id, title, due_date, category, priorityデータ取得
$id = $_POST["id"];
$title = trim($_POST["title"]);
$dueDate = $_POST["due_date"] ?: null;
$category = $_POST["category"] ?? null;
$priority = $_POST["priority"] ?? "低";


// バリデーション（空文字チェック）
if ($title === "") {
  $_SESSION["flash"] = [
    "type" => "error",
    "message" => "タイトルを入力して下さい"
  ];

  header("Location: edit.php?id=" . $id);
  exit;
}


// 重複チェック
require_once __DIR__ . "/../models/TodoModel.php";
$todoModel = new TodoModel($pdo);

if (
  $todoModel->existsByTitleForUpdate(
    $title,
    $id,
    $_SESSION["user_id"]
  )
) {
  $_SESSION["flash"] = [
    "type" => "error",
    "message" => "同じTodoが存在します"
  ];

  header("Location: edit.php?id=" . $id);
  exit;
}

// 更新処理
$todoModel->update(
  $id,
  $title,
  $dueDate,
  $category,
  $priority,
  $_SESSION["user_id"]
);

// 成功メッセージ
$_SESSION["flash"] = [
  "type" => "success",
  "message" => "タスクを更新しました"
];


header("Location: index.php");
exit;