# Todo App

PHPとMySQLを使用して作成したTodo管理アプリ。

## 概要

タスクの登録・編集・削除・完了管理ができるシンプルなTodoアプリ。
学習目的で開発し、PHP・MySQL・HTML・CSSの基礎理解を深めるために作成。

---

## 機能

- タスク追加
- タスク編集
- タスク削除
- タスク完了／未完了切り替え
- 未完了タスク一覧表示
- 完了済みタスク一覧表示
- レスポンシブ対応

---

## 使用技術

### フロントエンド

- HTML
- CSS

### バックエンド

- PHP

### データベース

- MySQL

### バージョン管理

- Git
- GitHub

---

## 画面イメージ

### Todo一覧

※ スクリーンショットを追加予定

```text
Todoリスト

新規タスク入力
[                    ] [追加]

--------------------------------
買い物に行く      ❌ 編集 削除
2026/06/20 10:00
--------------------------------
```

---

## フォルダ構成

```text
todo-app
├── config
│   └── database.php
├── public
│   ├── assets
│   │   └── css
│   │       └── style.css
│   ├── create.php
│   ├── delete.php
│   ├── edit.php
│   ├── index.php
│   ├── login_form.php
│   ├── login.php
│   ├── logout.php
│   ├── register_form.php
│   ├── register.php
│   ├── toggle.php
│   └── update.php
├── README.md
└── sql
    └── create_tables.php
```

---

## データベース

### テーブル名

```sql
todos
```

### カラム

| カラム名 | 型 | 説明 |
|----------|----|------|
| id | INT | ID |
| title | VARCHAR | タスク名 |
| status | TINYINT | 0:未完了 / 1:完了 |
| created_at | DATETIME | 作成日時 |

---

## 今後の改善予定

- 検索機能追加
- 並び替え機能追加
- ログイン機能追加
- MVC構成へのリファクタリング

---

## 学習内容

このアプリ開発を通して以下を学習しました。

- PHPによるCRUD処理
- PDOを利用したMySQL接続
- フォーム送信（GET / POST）
- HTML / CSSによるUI作成
- Flexboxによるレイアウト
- Git / GitHubによるバージョン管理

---

## 作成者

nishikai