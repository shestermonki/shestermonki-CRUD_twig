<?php
require_once '../src/config.php';
header("Content-type:text/plain");

$db = \Sudoku\Model\SudokuDB::getInstance();

$sudoku = $db->getSudokuById(1);
print_r($sudoku);

$sudokus = $db->getAllSudokus();
print_r($sudokus);

// $sudoku = new \Sudoku\Model\Sudoku(null, 5, '3.7...5.2.1.5.3.6.8.......4..86.97...7.....5...67.12..7.......6.3.8.7.9.5.2...4.8', '347968512219543867865172934128659743973284651456731289781495326634827195592316478');
// $sudoku = $db->insertSudoku($sudoku);
// print_r($sudoku);