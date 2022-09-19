<?php

namespace Sudoku\Model;

class Sudoku {
  private ?int $id;
  private int $level;
  private string $problem;
  private string $solved;

  public function __construct(?int $id, int $level, string $problem, string $solved) {
    $this->id = $id;
    $this->level = $level;
    $this->problem = $problem;
    $this->solved = $solved;
  }

  public function getId() : ?int { return $this->id; }
  public function setId(?int $id) { $this->id = $id; }
  public function getLevel() : int { return $this->level; }
  public function setLevel(int $level) { $this->level = $level; }
  public function getProblem() : string { return $this->problem; }
  public function setProblem(string $problem) { $this->problem = $problem; }
  public function getSolved() : string { return $this->solved; }
  public function setSolved(string $solved) { $this->solved = $solved; }
}