<?php
namespace Sudoku\View;

abstract class BaseView {
  protected $twig;

  public function __construct() {
    // Load Twig infrastructure
    $loader = new \Twig\Loader\FilesystemLoader(TEMPLATE_FOLDER);
    $this->twig = new \Twig\Environment($loader, [
        // 'cache' => '/path/to/compilation_cache',
    ]);
  }

  public abstract function render();

}