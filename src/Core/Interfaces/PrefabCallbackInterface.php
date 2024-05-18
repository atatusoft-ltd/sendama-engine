<?php

namespace Sendama\Engine\Core\Interfaces;

/**
 * Interface PrefabCallbackInterface
 * @package Sendama\Engine\Core\Interfaces
 */
interface PrefabCallbackInterface
{
  /**
   * Invokes the prefab callback.
   *
   * @param mixed ...$args The arguments to pass to the callback.
   * @return GameObjectInterface The game object.
   */
  public function __invoke(mixed ...$args): GameObjectInterface;
}