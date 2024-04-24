<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * Interface CanStart. The interface for objects that can start and stop.
 *
 * @package Sendama\Engine\Core\Interfaces
 */
interface CanStart
{
  /**
   * Starts the object.
   *
   * @return void
   */
  public function start(): void;

  /**
   * Stops the object.
   *
   * @return void
   */
  public function stop(): void;
}