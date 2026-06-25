<?php

session_start();
// csrf検証
require_once __DIR__ . "/../includes/csrf.php";
verifyCsrfToken();

require_once __DIR__ . "/../config/database.php";

// id, title, due_date, category, priorityデータ取得・sql設定
$id = $_POST["id"];
$title = trim($_POST["title"]);
$dueDate = $_POST["due_date"] ?: null;
$category = $_POST["category"] ?? null;
$priority = $_POST["priority"] ?? "低";
$updateSql = "
UPDATE todos
SET title = ?, due_date = ?, category = ?, priority = ?
WHERE id = ?
and user_id = ?
";

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
$checkSql = "
select * 
from todos 
where title = ? 
and id != ?
and user_id = ?
";
$stmt = $pdo->prepare($checkSql);
$stmt->execute([
  $title, 
  $id,
  $_SESSION["user_id"]
  ]);
$todo = $stmt->fetch(PDO::FETCH_ASSOC);

if ($todo) {
  $_SESSION["flash"] = [
    "type" => "error",
    "message" => "同じTodoが既に存在します"
  ];

  header("Location: edit.php?id=" . $id);
  exit;
}


// 登録
$stmt = $pdo->prepare($updateSql);
$stmt->execute([
  $title, 
  $dueDate,
  $category,
  $priority,
  $id,
  $_SESSION["user_id"]
  ]);
$_SESSION["flash"] = [
  "type" => "success",
  "message" => "タスクを更新しました"
];


header("Location: index.php");
exit;