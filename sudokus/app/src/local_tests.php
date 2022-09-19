<?php
require_once "./config.php";

$db = \Sudoku\Model\SudokuDB::getInstance();
$db->loadDB();

/* ENS AGRADARIA:

 - $db->loadSudokus();
 - $db->createPlayer();
 - $db->createRandomGame($player);
 - $db->getRanking();
 - ...
*/

$player = new \Sudoku\Model\Player(1, 'gertrudis', 'password1234', 'gertrudis@stucom.com');
$db->addPlayer($player);
$gertrudis = $db->getPlayerById(1);
// print_r($gertrudis ?? "NULL\n");

// MONOLOG
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$log = new Logger('Sudoku app');
$log->pushHandler(new StreamHandler(APP_FOLDER . '/logs/my.log', Logger::INFO));
$log->info('Sudoku Database loaded');
