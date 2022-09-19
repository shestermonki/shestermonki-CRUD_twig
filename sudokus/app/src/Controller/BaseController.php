<?php
namespace Sudoku\Controller;

abstract class BaseController {
  protected $db;
  protected $twig;

  public function __construct() {
    // Load Twig infrastructure
    $loader = new \Twig\Loader\FilesystemLoader(TEMPLATE_FOLDER);
    $this->twig = new \Twig\Environment($loader, [
        // 'cache' => '/path/to/compilation_cache',
    ]);

    // Prepare DB access
    $this->db = \Sudoku\Model\SudokuDB::getInstance(); 
  }

  protected function die($status, $message) {
    http_response_code($status);
    echo $message;
    exit;
  }

  protected function get($key, $default = null) {
    return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
  }

  protected function getOrDie($key, $status, $message) {
    if (isset($_REQUEST[$key])) return $_REQUEST[$key];
    $this->die($status, $message);
  }

  protected function redirect($url) {
    header("Location: $url");
    exit;
  }

  abstract public function processRequest();
}