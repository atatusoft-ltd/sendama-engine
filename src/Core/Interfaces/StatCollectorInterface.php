<?php

namespace Sendama\Engine\Core\Interfaces;

use Sendama\Engine\Events\Interfaces\ObserverInterface;

/**
 * Defines the interface for a stat collector.
 */
interface StatCollectorInterface extends SingletonInterface, ObserverInterface
{
  /**
   * Collects a value for the given key.
   *
   * @param string $key The key to collect the value for.
   * @param int|float $value The value to collect.
   * @return void
   */
  public function collect(string $key, int|float $value): void;

  /**
   * Persists the collected values.
   *
   * @return void
   */
  public function persist(): void;

  /**
   * Reads the value for the given key.
   *
   * @param string $key The key to read the value for.
   * @return int|float|null The value for the given key.
   */
  public function read(string $key): int|float|null;
}