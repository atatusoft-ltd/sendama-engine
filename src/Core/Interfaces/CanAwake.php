<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * CanAwake interface. This interface is for objects that can awake and sleep.
 */
interface CanAwake
{
  /**
   * Awake the object.
   */
  public function awake(): void;
}