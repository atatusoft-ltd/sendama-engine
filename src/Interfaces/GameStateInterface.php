<?php

namespace Sendama\Engine\Interfaces;

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

  /**
   * Suspends the game state.
   *
   * @return void
   */
  public function suspend(): void;

  /**
   * Resumes the game state.
   *
   * @return void
   */
  public function resume(): void;
}