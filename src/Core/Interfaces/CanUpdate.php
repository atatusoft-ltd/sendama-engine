<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * Interface CanUpdate
 * @package Sendama\Engine\Core\Interfaces
 */
interface CanUpdate
{
  /**
   * Update the object
   *
   * @return void
   */
  public function update(): void;
}