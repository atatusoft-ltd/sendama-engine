<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * Interface ActivatableInterface. Represents an object that can be activated and deactivated.
 *
 * @package Sendama\Engine\Core\Interfaces
 * @deprecated Use CanActivate instead. Will be removed in 0.2.0.
 * @since 0.1.0
 */
interface ActivatableInterface
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