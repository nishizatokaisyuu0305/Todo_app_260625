<?php

// トークン生成
function generateCsrfToken ()
{
  if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
  }

  return $_SESSION["csrf_token"];
}


// csrf検証
function verifyCsrfToken ()
{
  if (
    !isset($_POST["csrf_token"]) ||
    !isset($_SESSION["csrf_token"]) ||
    !hash_equals(
      $_SESSION["csrf_token"],
      $_POST["csrf_token"]
    )
  ) {
    exit("不正なリクエストです");
  }
}


// csrfフォーム
function csrfField ()
{
  return sprintf(
  '<input type="hidden", name="csrf_token" value="%s">',
  htmlspecialchars($_SESSION["csrf_token"])
  );
}
