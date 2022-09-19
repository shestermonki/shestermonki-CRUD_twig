<?php
require_once '../src/config.php';

// Connectem amb la BD
$conn = new \PDO(
  "mysql:host=sudoku_db;dbname=sudokudb",
  "sudokuuser",
  "sudokupassword"
);

// Retorna tots els sudokus
function getAllSudokus($conn) {
  $sql = "SELECT * FROM sudokus";
  $result = $conn->query($sql);
  $sudokus = $result->fetchAll(\PDO::FETCH_ASSOC);

  // ALTERNATIVAMENT:
  // $sql = "SELECT * FROM sudokus";
  // $statement = $conn->prepare($sql);
  // $result = $statement->execute();
  // $sudoku = $statement->fetchAll(\PDO::FETCH_ASSOC);
  return $sudokus;
}

// Retorna un sudoku per id
function getSudokuById($conn, $id) {
  $sql = "SELECT * FROM sudokus WHERE id=:id";
  $statement = $conn->prepare($sql);
  $result = $statement->execute([
    ':id' => $id
  ]);
  $sudoku = $statement->fetch(\PDO::FETCH_ASSOC);
  return $sudoku;
}

// Elimina un sudoku per id
function deleteSudokuById($conn, $id) {
  $sql = "DELETE FROM sudokus WHERE id=:id";
  $statement = $conn->prepare($sql);
  $result = $statement->execute([
    ':id' => $id
  ]);
  return $result;
}

// Insereix un sudoku nou
function insertSudoku($conn, $id, $level, $problem, $solved) {
  $sql = "INSERT INTO sudokus VALUES (:id, :level, :problem, :solved)";
  $statement = $conn->prepare($sql);
  $result = $statement->execute([
    ':id' => $id,
    ':level' => $level,
    ':problem' => $problem,
    ':solved' => $solved
  ]);
  $id = $conn->lastInsertId();
  return getSudokuById($conn, $id);
}


// PROVES
header("Content-type:text/plain");

// Netegem els IDs inserits després del primer
for ($id = 2; $id < 1000; $id++) deleteSudokuById($conn, $id);

// Inserim un sudoku nou amb id automàtic
insertSudoku($conn, null, 5, 
  '.4.5.6.1.6.......7..5.3.6...51.7.23..8..4..7..93.8.16...9.5.4..1.......3.3.1.2.8.', 
  '347526819628914357915837642451679238286341975793285164869753421172468593534192786');

// Provem d'obtenir tots els sudokus
$sudokus = getAllSudokus($conn);
print_r($sudokus);

// Provem d'obtenir un sudoku per id
$sudoku = getSudokuById($conn, 3);
if (!$sudoku) {
  http_response_code(404);
  exit;
}
print_r($sudoku);
