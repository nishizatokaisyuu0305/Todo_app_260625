<?php


class TodoModel
{
  // DB接続情報を保存する変数
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }


  // ソート・検索　SQL取得（index.php）
  public function getTodos(
    int $userId,
    string $keyword,
    string $sort,
    int $limit,
    int $offset
  ): array {
    $orderBy = ($sort === "asc")
      ? "asc"
      : "desc";

    if ($keyword === "") {
      $sql = "
        select * 
        from todos 
        where user_id = ? 
        order by created_at $orderBy
        limit $limit offset $offset
      ";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([
        $userId
      ]);
    } else {
      $sql = "
        select * 
        from todos 
        where user_id = ?
        and title like ? 
        order by created_at $orderBy
        limit $limit offset $offset
      ";
      
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([
        $userId,
        "%" . "$keyword" . "%"
      ]);
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  // 全件取得(index.php)
  public function countTodos (
    int $userId,
    string $keyword
  ): int {

    // 総件数取得
    if ($keyword === "") {
      $sql = "
        select count(*)
        from todos
        where user_id = ?
      ";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([
        $userId
      ]);

    } else {
      $sql = "
        select count(*)
        from todos
        where user_id = ?
        and title like ?
      ";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([
        $userId,
        "%" . $keyword . "%"
      ]);
    }

    return (int)$stmt->fetchColumn();
  }

  // 例外としてDB操作関連ではないが、モデル化(index.php)
  public function separateTodos(array $todos): array
  {
    // 未完了取得,完了済み取得
    $incompleteTodos = [];
    $completedTodos = [];

    foreach ($todos as $todo) {
      if ($todo["status"] == 0) {
        $incompleteTodos[] = $todo;
      } else {
        $completedTodos[] = $todo;
      }
    }

    return [
      "incomplete" => $incompleteTodos,
      "completed" => $completedTodos
    ];
  }


  // 重複チェック(create.php)
  public function existsByTitle(
    string $title,
    int $userId
  ): bool {
    $sql = "
      select *
      from todos
      where title = ?
      and user_id = ?
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
      $title,
      $userId
    ]);

    return $stmt->fetch() !== false;
  }

  
  // 登録(create.php)
  public function create(
    string $title,
    ?string $dueDate,
    ?string $category,
    string $priority,
    int $userId
  ): void {
    $sql = "
      insert into todos(
        title,
        due_date,
        category,
        priority,
        user_id
      )
      value(?, ?, ?, ?, ?)
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
      $title,
      $dueDate,
      $category,
      $priority,
      $userId
    ]);
  }


  public function existsByTitleForUpdate(
    string $title,
    int $id,
    int $userId
  ): bool {
    $sql = "
      select id
      from todos
      where title = ?
      and id != ?
      and user_id = ?
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
      $title,
      $id,
      $userId
    ]);

    return (bool)$stmt->fetch();
  }


  // タスクupdate(create.php)
  public function update(
    int $id,
    string $title,
    ?string $dueDate,
    ?string $category,
    string $priority,
    int $userId
  ): bool {
    $sql = "
      update todos
      set
        title = ?,
        due_date = ?,
        category = ?,
        priority = ?
      where id = ?
      and user_id = ?
    ";

    $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([
      $title,
      $dueDate,
      $category,
      $priority,
      $id,
      $userId
    ]);
  }


  public function findById(
    int $id,
    int $userId
  ): array|false
  {
    $sql = "
      select *
      from todos
      where id = ?
      and user_id =?
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
      $id,
      $userId
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }


  public function delete(
    int $id,
    int $userId
  ): void
  {
    $sql = "
      delete
      form todos
      where id = ?
      and user_id = ?
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
      $id,
      $userId
    ]);
  }


  // statusデータ取得・更新(toggle.php)
  public function updateStatus(
    int $id,
    int $status,
    int $userId
  ): void
  {
    $sql = "
    update todos
    set status = ?
    where id = ?
    and user_id = ?
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
      $status,
      $id,
      $userId
    ]);
  }
}


