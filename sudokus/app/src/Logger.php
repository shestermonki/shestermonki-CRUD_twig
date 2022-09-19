<?php
namespace Sudoku;

class Logger {
    private static ?\Monolog\Logger $logger = null;

    public static function getInstance() {
        if (static::$logger == null) {
            static::$logger = new \Monolog\Logger('Sudoku app');
            static::$logger->pushHandler(new \Monolog\Handler\StreamHandler(LOG_FOLDER . '/sudoku.log', \Monolog\Logger::INFO));
        }
        return static::$logger;
    }
}