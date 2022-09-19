<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('APP_FOLDER',  dirname(__DIR__));
define('LOG_FOLDER', APP_FOLDER . '/logs');
define('DATA_FOLDER', APP_FOLDER  . '/data');
define('SUDOKU_FILE', DATA_FOLDER . '/sudokus.txt');
define('PLAYER_FILE', DATA_FOLDER . '/players.json');
define('GAME_FILE',   DATA_FOLDER . '/games.csv');
define('TEMPLATE_FOLDER', APP_FOLDER . '/templates');
