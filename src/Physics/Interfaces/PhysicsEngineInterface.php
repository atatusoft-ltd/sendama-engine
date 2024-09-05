<?php

namespace Sendama\Engine\Physics\Interfaces;

use Sendama\Engine\Core\Vector2;

/**
 * Interface PhysicsEngineInterface. Interface for physics engines.
 *
 * @package Sendama\Engine\Physics\Interfaces
 * @template T
 */
interface PhysicsEngineInterface
{
  /**
   * Checks for collisions between the given collider and all other colliders in the physics engine.
   *
   * @param ColliderInterface<T> $collider The collider to check for collisions.
   * @param Vector2 $motion The motion of the collider.
   * @return array<CollisionInterface<T>> The collisions found.
   */
  public function checkCollisions(ColliderInterface $collider, Vector2 $motion): array;
}