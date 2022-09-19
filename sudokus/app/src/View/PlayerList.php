<?php
namespace Sudoku\View;

class PlayerList extends BaseView {
  private $players;

  public function __construct($players) {
    parent::__construct();
    $this->players = $players;
  }
  
  public function render() {
    echo $this->twig->render('player_list.html', [
      'players' => $this->players,
    ]);
    exit;
  }
}