<?php

namespace Sendama\Engine\Core\Behaviours;

use Sendama\Engine\Core\Behaviours\Attributes\SerializeField;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\IO\Input;

/**
 * Class SimpleQuitListener is responsible for quitting the game when the quit keys are pressed.
 *
 * @package Sendama\Engine\Core\Behaviours
 */
class SimpleQuitListener extends Behaviour
{
  #[SerializeField]
  /**
   * The keys that will quit the game.
   *
   * @var array<KeyCode> $quitKeys The keys that will quit the game.
   */
  protected array $quitKeys = [KeyCode::Q, KeyCode::q];

  /**
   * @inheritDoc
   */
  public function onUpdate(): void
  {
    if (Input::isAnyKeyPressed($this->quitKeys)) {
      quitGame();
    }
  }

  /**
   * Sets the keys that will quit the game.
   *
   * @param array<KeyCode> $keys
   * @return void
   */
  public function setQuitKeys(array $keys): void
  {
    $this->quitKeys = $keys;
  }
}