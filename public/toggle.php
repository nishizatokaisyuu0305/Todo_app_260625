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


//id取得・実行 
if (!isset($_POST["id"])) {
  header("Location: index.php");
  exit;
}

require_once __DIR__ . "/../models/TodoModel.php";
$id = (int)$_POST["id"];
$todoModel = new TodoModel($pdo);
$todo = $todoModel->findById(
  $id,
  $_SESSION["user_id"]
);


// バリデーション
if (!$todo) {
  $_SESSION["flash"] = [
    "type" => "error",
    "message" => "対象のTodoが存在しません"
  ];

  header("Location: index.php");
  exit;
}


// status切替
$newStatus = $todo == 0 ? 1 : 0;
$todoModel->updateStatus(
  $id,
  $newStatus,
  $_SESSION["user_id"]
);


// フラッシュメッセージ
$_SESSION["flash"] = [
  "type" => "success",
  "message" => "「" . $todo["title"] . "」の状態を更新しました。"
];

header("Location: index.php");
exit;