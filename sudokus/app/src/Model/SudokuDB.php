<?php
namespace Sudoku\Model;

class SudokuDB {
  protected static ?\Sudoku\Model\SudokuDB $instance = null;

  public static function getInstance() : \Sudoku\Model\SudokuDB {
    if (is_null(static::$instance)) {
      static::$instance = new \Sudoku\Model\SudokuDB();
    }
    return static::$instance;
  }

  private \PDO $conn;

  protected function __construct() {
    $this->conn = new \PDO(
      "mysql:host=sudoku_db;dbname=sudokudb",
      "sudokuuser",
      "sudokupassword"
    );
  }

  // PLAYERS
  public function getAllPlayers() : array {
    $sql = "SELECT * FROM players";
    $result = $this->conn->query($sql);
    $playersAssoc = $result->fetchAll(\PDO::FETCH_ASSOC);
    if (!$playersAssoc) return [];
    $players = [];
    foreach($playersAssoc as $playerAssoc) {
      $players[] = new \Sudoku\Model\Player(
        $playerAssoc['id'], 
        $playerAssoc['username'],
        $playerAssoc['password'], 
        $playerAssoc['email']
      );
    }
    return $players;
  }

  public function getPlayerByUsername(string $username) : ?\Sudoku\Model\Player {
    $sql = "SELECT * FROM players WHERE username=:username";
    $statement = $this->conn->prepare($sql);
    $result = $statement->execute([
      ':username' => $username
    ]);
    $playerAssoc = $statement->fetch(\PDO::FETCH_ASSOC);
    if (!$playerAssoc) return null;
    $player = new \Sudoku\Model\Player(
      $playerAssoc['id'], 
      $playerAssoc['username'],
      $playerAssoc['password'], 
      $playerAssoc['email']
    );
    return $player;
  }

  public function getPlayerById(int $id) : ?\Sudoku\Model\Player {
    $sql = "SELECT * FROM players WHERE id=:id";
    $statement = $this->conn->prepare($sql);
    $result = $statement->execute([
      ':id' => $id
    ]);
    $playerAssoc = $statement->fetch(\PDO::FETCH_ASSOC);
    if (!$playerAssoc) return null;
    $player = new \Sudoku\Model\Player(
      $playerAssoc['id'], 
      $playerAssoc['username'],
      $playerAssoc['password'], 
      $playerAssoc['email']
    );
    return $player;
  }

  public function insertPlayer(\Sudoku\Model\Player $player) : ?\Sudoku\Model\Player {
    $sql = "INSERT INTO players VALUES (:id, :username, :password, :email)";
    $statement = $this->conn->prepare($sql);
    $result = $statement->execute([
      ':id' => null,
      ':username' => $player->getUsername(),
      ':password' => $player->getPassword(),
      ':email' => $player->getEmail()
    ]);
    $id = $this->conn->lastInsertId();
    return $this->getPlayerById($id);
  }

  public function savePlayer($player) : ?\Sudoku\Model\Player {
    $id = $player->getId();
    if (is_null($this->getPlayerById($id))) return null;
    $sql = "UPDATE players SET username=:username, password=:password, email=:email WHERE id=:id";
    $statement = $this->conn->prepare($sql);
    $result = $statement->execute([
      ':id' => $id,
      ':username' => $player->getUsername(),
      ':password' => $player->getPassword(),
      ':email' => $player->getEmail()
    ]);
    return $this->getPlayerById($id);
  }

  public function deletePlayer(\Sudoku\Model\Player $player) : bool {
    return $this->deletePlayerById($player->getId());
  }

  public function deletePlayerById(int $id) : bool {
    $sql = "DELETE FROM players WHERE id=:id";
    $statement = $this->conn->prepare($sql);
    $result = $statement->execute([
      ':id' => $id
    ]);
    return $result;
  }

  // SUDOKUS
  public function insertSudoku(\Sudoku\Model\Sudoku $sudoku) : ?\Sudoku\Model\Sudoku {
    $sql = "INSERT INTO sudokus VALUES (:id, :level, :problem, :solved)";
    $statement = $this->conn->prepare($sql);
    $result = $statement->execute([
      ':id' => null,
      ':level' => $sudoku->getLevel(),
      ':problem' => $sudoku->getProblem(),
      ':solved' => $sudoku->getSolved()
    ]);
    $id = $this->conn->lastInsertId();
    return $this->getSudokuById($id);
  }

  public function getAllSudokus() : array {
    $sql = "SELECT * FROM sudokus";
    $result = $this->conn->query($sql);
    $sudokusAssoc = $result->fetchAll(\PDO::FETCH_ASSOC);
    if (!$sudokusAssoc) return [];
    $sudokus = [];
    foreach($sudokusAssoc as $sudokuAssoc) {
      $sudokus[] = new \Sudoku\Model\Sudoku(
        $sudokuAssoc['id'], 
        $sudokuAssoc['level'],
        $sudokuAssoc['problem'], 
        $sudokuAssoc['solved']
      );
    }
    return $sudokus;
  }

  public function getSudokuById(int $id) : ?\Sudoku\Model\Sudoku {
    $sql = "SELECT * FROM sudokus WHERE id=:id";
    $statement = $this->conn->prepare($sql);
    $result = $statement->execute([
      ':id' => $id
    ]);
    $sudokuAssoc = $statement->fetch(\PDO::FETCH_ASSOC);
    if (!$sudokuAssoc) return null;
    $sudoku = new \Sudoku\Model\Sudoku(
      $sudokuAssoc['id'], 
      $sudokuAssoc['level'],
      $sudokuAssoc['problem'], 
      $sudokuAssoc['solved']
    );
    return $sudoku;
  }

  public function deleteSudokuById(int $id) : bool {
    $sql = "DELETE FROM sudokus WHERE id=:id";
    $statement = $this->conn->prepare($sql);
    $result = $statement->execute([
      ':id' => $id
    ]);
    return $result;
  }

  public function deleteSudoku(\Sudoku\Model\Sudoku $sudoku) : bool {
    $sql = "DELETE FROM sudokus WHERE id=:id";
    $statement = $this->conn->prepare($sql);
    $result = $statement->execute([
      ':id' => $sudoku->getId()
    ]);
    return $result;
  }

  // GAMES
  // TODO
}
