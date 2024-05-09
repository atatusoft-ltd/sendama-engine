<?php

namespace Sendama\Engine\States;

/**
 * Class ModalState. Represents a modal state of the game.
 *
 * @package Sendama\Engine\States
 */
class ModalState extends GameState
{
  /**
   * @inheritDoc
   */
  public function render(): void
  {
    $this->modalManager->render();
  }

  /**
   * @inheritDoc
   */
  public function update(): void
  {
    $this->modalManager->update();
  }

  /**
   * @inheritDoc
   */
  public function suspend(): void
  {
    // TODO: Implement suspend() method.
  }

  /**
   * @inheritDoc
   */
  public function resume(): void
  {
    // TODO: Implement resume() method.
  }
}