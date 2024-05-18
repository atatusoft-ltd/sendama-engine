<?php

namespace Sendama\Engine\Core\Interfaces;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Exceptions\FileNotFoundException;
use Serializable;

/**
 * Interface PrefabInterface is the interface for all prefabs in the engine. Prefabs are serializable objects that can
 * be instantiated into game objects. Prefabs are used to create reusable objects in the game.
 *
 * @package Sendama\Engine\Core\Interfaces
 */
interface PrefabInterface extends Serializable
{
  /**
   * Gets the name of the prefab.
   *
   * @return string The name of the prefab.
   */
  public function getName(): string;

  /**
   * Sets the name of the prefab.
   *
   * @param string $name The name of the prefab.
   * @return void
   */
  public function setName(string $name): void;

  /**
   * Fabricates the prefab.
   *
   * @param PrefabCallbackInterface $callback GameObject $callback The callback to call when fabricating the prefab.
   * @return void
   */
  public function fabricate(PrefabCallbackInterface $callback): void;

  /**
   * Instantiates the prefab.
   *
   * @return GameObject The instantiated game object.
   */
  public function instantiate(): GameObject;

  /**
   * Pools the prefab.
   *
   * @param int $size The size of the pool.
   * @return void
   */
  public function pool(int $size): array;

  /**
   * Loads the prefab from the given path.
   *
   * @param string $path The path to the prefab.
   * @return void
   * @throws FileNotFoundException If the prefab file is not found.
   */
  public function load(string $path): void;
}