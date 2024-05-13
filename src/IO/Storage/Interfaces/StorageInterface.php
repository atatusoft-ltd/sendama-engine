<?php

namespace Sendama\Engine\IO\Storage\Interfaces;

use Sendama\Engine\Core\Interfaces\SingletonInterface;

/**
 * The interface StorageInterface.
 *
 * @package Sendama\Engine\IO\Storage\Intefaces
 */
interface StorageInterface extends SingletonInterface
{
  /**
   * Loads the data from the storage.
   *
   * @param string $path The path to the storage.
   */
  public function load(string $path): void;

  /**
   * Saves the data to the storage.
   *
   * @return void
   */
  public function save(): void;

  /**
   * Delete the file of the given path.
   *
   * @param string $path
   * @return void
   */
  public function delete(string $path): void;

  /**
   * Returns the data from the storage.
   *
   * @param string $key The key.
   * @return mixed The data.
   */
  public function get(string $key): mixed;

  /**
   * Sets the data to the storage.
   *
   * @param string $key The key.
   * @param mixed $data The data.
   * @return void
   */
  public function set(string $key, mixed $data): void;
}