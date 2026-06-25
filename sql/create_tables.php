<?php

require_once __DIR__ . "/../config/database.php";

$sqlUsers = "
CREATE TABLE IF NOT EXISTS users (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

$sqlTodos = "
CREATE TABLE IF NOT EXISTS todos (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  status TINYINT DEFAULT 0,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  user_id INT DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

// テーブル追加コード
// ALTER TABLE todos ADD COLUMN due_date DATE NULL;
// ALTER TABLE todos
// ADD category VARCHAR(50) DEFAULT NULL;



// $pdo->exec($sqlUsers);
// $pdo->exec($sqlTodos);
// echo "テーブル作成完了";