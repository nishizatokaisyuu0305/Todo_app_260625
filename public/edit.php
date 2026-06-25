<?php

session_start();
// 未ログイン制限
if(!isset($_SESSION["user_id"])) {
  header("Location: login_form.php");
  exit;
}

// csrfトークン生成
require_once __DIR__ . "/../includes/csrf.php";
generateCsrfToken();

require_once __DIR__ . "/../config/database.php";

// idとuser_id情報取得・編集SQL実行
if(!isset($_GET["id"])) {
  header("Location: index.php");
  exit;
}
$id = $_GET["id"];

$sql = "SELECT * FROM todos WHERE id = ? and user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([
  $id,
  $_SESSION["user_id"]
  ]);
$todo = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$todo) {
  $_SESSION["flash"] = [
    "type" => "error",
    "message" => "対象のTodoが存在しません"
  ];

  header("Location: index.php");
  exit;
}


?>


<!-- html表示 -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/style.css">
  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
  />
  <title>編集</title>
</head>
<body>
  <div class="container">
    <h1 class="page-title">
      <i class="fa-solid fa-pen-to-square"></i>
      Todo編集
    </h1>

    <?php if (isset($_SESSION["flash"])): ?>
      <div class="flash-message flash-<?= $_SESSION["flash"]["type"] ?>">
        <?= htmlspecialchars($_SESSION["flash"]["message"]) ?>
      </div>
      <?php unset($_SESSION["flash"]); ?>
    <?php endif; ?>

    <form action="update.php" method="POST" class="todo-form">
      <!-- csrfフォーム -->
      <?= csrfField() ?>
      <input type="hidden" name="id" value="<?= $todo["id"] ?>">
      <input 
        type="text" 
        name="title" 
        value="<?= htmlspecialchars($todo["title"]) ?>"
        class="todo-input"
      >

      <!-- カテゴリ -->
      <label>カテゴリ</label>
      <select name="category">
        <option>選択してください</option>
        <option 
        value="勉強"
        <?= $todo["category"] === "勉強" ? "selected" : "" ?>
        >
          勉強
        </option>
        <option 
        value="仕事"
        <?= $todo["category"] === "仕事" ? "selected" : "" ?>
        >
          仕事
        </option>
        <option 
        value="プライベート"
        <?= $todo["category"] === "プライベート" ? "selected" : "" ?>
        >
          プライベート
        </option>
        <option 
        value="その他"
        <?= $todo["category"] === "その他" ? "selected" : "" ?>
        >
          その他
        </option>
      </select>

      <!-- 優先度 -->
      <label>優先度</label>
      <select name="priority">
        <option 
          value="高"
          <?= $todo["priority"] === "高" ? "selected" : "" ?>
        >
          高
        </option>
        <option 
          value="中"
          <?= $todo["priority"] === "中" ? "selected" : "" ?>
        >
          中
        </option>
        <option 
          value="低"
          <?= $todo["priority"] === "低" ? "selected" : "" ?>
        >
          低
        </option>
      </select>

      <!-- 締切 -->
      <label>締切日</label>
        <input 
        type="date"
        name="due_date"
        value="<?= $todo["due_date"] ?>"
        >

      <!-- ボタン -->
      <div class="button-group">
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-floppy-disk"></i>
          更新
        </button>
        <a href="index.php" class="btn btn-secondary">
          <i class="fa-solid fa-arrow-left"></i>
          戻る
        </a>
      </div>
    </form>
  </div>
</body>
</html>
