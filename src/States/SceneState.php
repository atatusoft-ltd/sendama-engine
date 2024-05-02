<?php

namespace Sendama\Engine\States;

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
    $this->sceneManager->update();
    $this->notificationsManager->update();
  }
}