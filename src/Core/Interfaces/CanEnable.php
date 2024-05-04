<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * Interface CanEnable
 * @package Sendama\Engine\Core\Interfaces
 */
interface CanEnable
{
  /**
   * Enable the object.
   *
   * @return void
   */
  public function enable(): void;

  /**
   * Disable the object.
   *
   * @return void
   */
  public function disable(): void;

  /**
   * Check if the object is enabled.
   *
   * @return bool
   */
  public function isEnabled(): bool;
}