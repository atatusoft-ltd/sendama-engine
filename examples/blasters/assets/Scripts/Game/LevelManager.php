<?php

namespace Sendama\Examples\Blasters\Scripts\Game;

use Sendama\Engine\Core\Behaviours\Behaviour;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\IO\Input;

class LevelManager extends Behaviour
{
  /**
   * @inheritDoc
   */
  public function onUpdate(): void
  {
    if (Input::isKeyDown(KeyCode::ESCAPE))
    {
      pauseGame();
    }

    if (Input::isAnyKeyPressed([KeyCode::Q, KeyCode::q]))
    {
      quitGame();
    }
  }
}