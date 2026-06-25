<?php


class TodoModel
{
  // DB接続情報を保存する変数
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

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
}


