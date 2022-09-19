<?php
require_once '../src/config.php';

$controller = new \Sudoku\Controller\PlayerController();
$controller->processRequest();
