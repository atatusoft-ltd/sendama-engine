<?php

namespace Sendama\Engine\Interfaces;

/**
 * The interface ConfigurableInterface. This interface defines the methods that a configurable object must implement.
 *
 * @package Sendama\Engine\Interfaces
 */
interface ConfigurableInterface
{
  /**
   * Configures the object with the given options.
   *
   * @param array<string, mixed> $options The options to configure the object with.
   * @return void
   */
  public function configure(array $options = []): void;
}