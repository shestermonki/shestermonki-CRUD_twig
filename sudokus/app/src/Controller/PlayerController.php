<?php
namespace Sudoku\Controller;

class PlayerController extends BaseController {
  private static $ACTIONS = [
    'playerlist', 
    'view',
    'add', 'edit', 'editsave', 
    'delete', 'deleteconfirmed',
  ];
  
  public function processRequest() {
    // Get the action from URL
    $action = $this->get('action', '');
    $action = trim($action);
    $action = strtolower($action);

    // Valid methods only
    if (!in_array($action, static::$ACTIONS)) {
      $action="playerlist";
    }
    if (!method_exists($this, $action)) $action ="playerlist";

    $log = \Sudoku\Logger::getInstance();
    $log->info($action);

    $this->$action();
  }

  public function playerlist() {
    // Build the player list page
    $players = $this->db->getAllPlayers();
    (new \Sudoku\View\PlayerList($players))->render();
  }

  public function view() { 
    $id = $this->get('id');
    if (is_null($id)) $this->die(400, "Bad request");
    $player = $this->db->getPlayerById($id);
    (new \Sudoku\View\PlayerView($player))->render();
  }

  public function add() {
    $player = new \Sudoku\Model\Player(0, '', '', '');
    (new \Sudoku\View\PlayerEdit($player))->render();
  }

  public function edit() { 
    $id = $this->getOrDie('id', 400, "Bad request");
    $player = $this->db->getPlayerById($id);
    if (is_null($player)) $this->die(404, "Not found");
    (new \Sudoku\View\PlayerEdit($player))->render();
  }

  public function editsave() {
    // Get the data or die with 400
    $id = $this->getOrDie('id', 400, "Bad request");
    $username= $this->getOrDie('username', 400, "Bad request");
    $email = $this->getOrDie('email', 400, "Bad request");

    if ($id == 0) {
      // New user, generate random password...
      $password = \Sudoku\Model\Player::randomPassword(10);
      $player = new \Sudoku\Model\Player($id, $username, $password, $email);
      // TODO send new password by email to this new user
    }
    else {
      // Editing existing user!
      // Check user or die with 404
      $player = $this->db->getPlayerById($id);
      if (is_null($player)) $this->die(404, "Not found");
      // Save temporary data to in-memory object
      $player->setUsername($username);
      $player->setEmail($email);
    }
    
    // Validate all the received data and prepare the view if errors are found
    $editor = new \Sudoku\View\PlayerEdit($player);
    $editor->clearErrors();

    // Check username
    $username = trim($username);
    if (empty($username)) {
      $editor->setUsernameError('Username cannot be empty!');
    }
    // Check DB for already existing usernames
    if ($id == 0) {
      $playerWithSameUsername = $this->db->getPlayerByUsername($username);
      if (!is_null($playerWithSameUsername)) {
        $editor->setUsernameError('This username already exists!');
      }
    }

    // Check email
    $email = trim($email);
    if (empty($email)) {
      $editor->setEmailError('Email cannot be empty!');
    }
    // Check valid email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $editor->setEmailError('Invalid email format'); 
    }

    // If there were errors, return to the edit page showing the same data!
    if ($editor->isInvalid()) {
      $editor->setValidated(true);
      $editor->render();
      exit;
    }

    // All went well and the $player object is ready to be persisted
    if ($id == 0) {
      $this->db->insertPlayer($player);
    }
    else {
      $this->db->savePlayer($player);
    }
    $this->redirect("player.php?action=playerlist");
  }
  
  public function delete() {
    $id = $this->getOrDie('id', 400, "Bad request");
    $player = $this->db->getPlayerById($id);
    if (is_null($player)) $this->die(404, "Not found");
    (new \Sudoku\View\PlayerDelete($player))->render();
  }

  public function deleteconfirmed() { 
    $id = $this->getOrDie('id', 400, "Bad request");
    $player = $this->db->getPlayerById($id);
    if (is_null($player)) $this->die(404, "Not found");
    $this->db->deletePlayer($player);
    $this->redirect("player.php?action=playerlist");
  }
}
