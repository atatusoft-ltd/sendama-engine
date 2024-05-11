<?php

namespace Sendama\Engine\States;

use Sendama\Engine\IO\Input;

/**
 * Class SceneState. Represents a scene state of the game.
 *
 * @package Sendama\Engine\States
 */
class SceneState extends GameState
{
  /**
   * @inheritDoc
   */
  public function render(): void
  {
    $this->sceneManager->render();
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    if (Input::isKeyDown($this->context->getSettings('pause_key')))
    {
      $this->suspend();
    }

    $this->sceneManager->update();
    $this->notificationsManager->update();
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    $this->context->setState($this->context->getState('paused'));
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    // Do nothing
  }
}