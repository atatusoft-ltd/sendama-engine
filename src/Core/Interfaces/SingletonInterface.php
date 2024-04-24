<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * Interface SingletonInterface
 * @package Sendama\Engine\Core\Interfaces
 */
interface SingletonInterface
{
  /**
   * Returns the singleton instance.
   *
   * @return static The singleton instance.
   */
  public static function getInstance(): static;
}