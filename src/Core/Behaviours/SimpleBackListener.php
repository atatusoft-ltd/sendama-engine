<?php

namespace Sendama\Engine\Core\Behaviours;

use Sendama\Engine\Core\Behaviours\Behaviour;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\IO\Input;

/**
 * Class SimpleBackListener is responsible for going back when the back keys are pressed.
 *
 * @package Sendama\Engine\Core\Behaviours
 */
class SimpleBackListener extends Behaviour
{
  /**
   * The keys that will go back.
   *
   * @var array<KeyCode> $backKeys The keys that will go back.
   */
  protected array $backKeys = [KeyCode::ESCAPE, KeyCode::BACKSPACE];

  public function onUpdate(): void
  {
    if (Input::isAnyKeyPressed($this->backKeys))
    {
      loadPreviousScene();
    }
  }

  /**
   * Sets the keys that will go back.
   *
   * @param array<KeyCode> $backKeys The keys that will go back.
   * @return void
   */
  public function setBackKeys(array $backKeys): void
  {
    $this->backKeys = $backKeys;
  }
}