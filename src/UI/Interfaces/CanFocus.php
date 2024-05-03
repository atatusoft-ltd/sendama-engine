<?php

namespace Sendama\Engine\UI\Interfaces;

/**
 * Interface CanFocus
 *
 * This interface is used to define an element that can be focused.
 *
 * @package Sendama\Engine\UI\Interfaces
 */
interface CanFocus
{
  /**
   * Focuses the element.
   *
   * @return void
   */
  public function focus(): void;

  /**
   * Blur's the element. The opposite of focus.
   *
   * @return void
   */
  public function blur(): void;
}