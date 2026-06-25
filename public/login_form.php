<?php

session_start();
// csrfトークン生成
if (empty($_SESSION["csrf_token"])) {
  $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン</title>
</head>
<body>
  <h1>ログイン</h1>

  <?php if(isset($_SESSION["flash"])): ?>
    <div>
      <?= htmlspecialchars($_SESSION["flash"]["message"]) ?>
    </div>
    <?php unset($_SESSION["flash"]); ?>
  <?php endif; ?>
  
  <form action="login.php" method="POST">
    <!-- csrfフォーム -->
    <?= csrfField() ?>
    
    <label>メールアドレス</label>
    <input type="email" name="email" required>
    <label>パスワード</label>
    <input type="password" name="password" required>
    <button type="submit">
      ログイン
    </button>
  </form>
  <p>
    アカウントをお持ちでない方は
    <a href="register_form.php">新規登録はこちら</a>
  </p>
  
</body>
</html>