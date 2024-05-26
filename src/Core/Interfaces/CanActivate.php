<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * Interface CanActivate. Represents an object that can be activated or deactivated.
 *
 * @package Sendama\Engine\Core\Interfaces
 */
interface CanActivate
{
  /**
   * Activate the object.
   *
   * @return void
   */
  public function activate(): void;

  /**
   * Deactivate the object.
   *
   * @return void
   */
  public function deactivate(): void;

  /**
   * Determine if the object is active.
   *
   * @return bool True if the object is active, false otherwise.
   */
  public function isActive(): bool;
}