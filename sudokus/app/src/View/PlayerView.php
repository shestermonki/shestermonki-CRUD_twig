<?php
namespace Sudoku\View;

class PlayerView extends BaseView {
  private $player;

  public function __construct($player) {
    parent::__construct();
    $this->player = $player;
  }
  
  public function render() {
    echo $this->twig->render('player_view.html', [
      'player' => $this->player,
    ]);
    exit;
  }
}

