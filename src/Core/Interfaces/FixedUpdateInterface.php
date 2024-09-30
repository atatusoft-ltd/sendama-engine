<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * Interface FixedUpdateInterface
 *
 * @package Sendama\Engine\Core\Interfaces
 */
interface FixedUpdateInterface
{
  /**
   * Fixed update is called once per frame.
   *
   * @return void
   */
  public function fixedUpdate(): void;
}