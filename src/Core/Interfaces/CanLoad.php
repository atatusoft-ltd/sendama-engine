<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * Defines an object that can be loaded and unloaded.
 *
 * @package Sendama\Engine\Core\Interfaces
 */
interface CanLoad
{
  /**
   * Loads the object.
   *
   * @return void
   */
  public function load(): void;

  /**
   * Unloads the object.
   *
   * @return void
   */
  public function unload(): void;
}