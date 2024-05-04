<?php

namespace Sendama\Engine\Interfaces;

use Sendama\Engine\Core\Interfaces\CanAwake;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Interfaces\CanResume;
use Sendama\Engine\Core\Interfaces\CanStart;
use Sendama\Engine\Core\Interfaces\CanUpdate;

interface GameStateInterface
{
  /**
   * Updates the game state.
   *
   * @return void
   */
  public function update(): void;

  /**
   * Renders the game state.
   *
   * @return void
   */
  public function render(): void;
}