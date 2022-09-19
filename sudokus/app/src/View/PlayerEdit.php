<?php
namespace Sudoku\View;

class PlayerEdit extends BaseView {
  private $player;
  private $validated = false;
  private $hasErrors = false;
  private $usernameClass = '';
  private $usernameError = '';
  private $emailClass = '';
  private $emailError = '';

  public function __construct($player) {
    parent::__construct();
    $this->player = $player;
  }

  public function setValidated($validated) {
    $this->validated = $validated;
  }

  public function isInvalid() { return $this->hasErrors; }

  public function clearErrors() {
    $this->hasErrors = false;
    $this->usernameClass = 'is-valid';
    $this->usernameError = '';
    $this->emailClass = 'is-valid';
    $this->emailError = '';
  }

  public function setUsernameError($error) {
    $this->hasErrors = true;
    $this->usernameClass = 'is-invalid';
    $this->usernameError = $error;
  }

  public function setEmailError($error) {
    $this->hasErrors = true;
    $this->emailClass = 'is-invalid';
    $this->emailError = $error;
  }

  public function render() {
    $data = ['player' => $this->player ];
    if ($this->validated) {
      $data = array_merge($data, [
        'usernameClass' => $this->usernameClass,
        'usernameError' => $this->usernameError,
        'emailClass' => $this->emailClass,
        'emailError' => $this->emailError,
      ]);
    }
    echo $this->twig->render('player_edit.html', $data);
  }
}