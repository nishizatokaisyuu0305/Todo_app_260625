<?php

session_start();
// csrfトークン生成
generateCsrfToken();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会員登録</title>
</head>
<body>
  <h1>会員情報</h1>
  <form action="register.php" method="POST">
    <!-- csrfフォーム -->
    <?= csrfField() ?>
    
    <label>名前</label>
    <input type="text" name="name">
    <label>メールアドレス</label>
    <input type="email" name="email">
    <label>パスワード</label>
    <input type="password" name="password">
    <button type="submit">
      登録
    </button>
  </form>
  
</body>
</html>