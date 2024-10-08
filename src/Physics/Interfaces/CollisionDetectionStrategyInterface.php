<?php

namespace Sendama\Engine\Physics\Interfaces;

use Sendama\Engine\Interfaces\ConfigurableInterface;

/**
 * Interface CollisionDetectionStrategyInterface
 *
 * This interface defines the methods that a collision detection strategy must implement.
 */
interface CollisionDetectionStrategyInterface extends ConfigurableInterface
{
  /**
   * Checks if the collider is touching the given collider.
   *
   * @template T
   * @param ColliderInterface<T> $collider The collider to check if it is touching.
   * @return bool True if the collider is touching the given collider, false otherwise.
   */
  public function isTouching(ColliderInterface $collider): bool;
}