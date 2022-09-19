<?php
namespace Sudoku\View;

class PlayerDelete extends BaseView {
  private $player;

  public function __construct($player) {
    parent::__construct();
    $this->player = $player;
  }
  
  public function render() {
    echo $this->twig->render('player_delete.html', [
      'player' => $this->player,
    ]);
    exit;
  }
}

