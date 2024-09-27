<?php

namespace Sendama\Engine\Physics\Interfaces;

use Sendama\Engine\Core\Interfaces\ComponentInterface;
use Sendama\Engine\Core\Rect;

/**
 * Interface ColliderInterface. Interface for colliders.
 *
 * @package Sendama\Engine\Physics\Interfaces
 * @template T
 * @extends ComponentInterface<T>
 */
interface ColliderInterface extends ComponentInterface, CollisionDetectionStrategyInterface, SimulatorInterface
{
  /**
   * Check if this collider is a trigger.
   *
   * @return bool True if this collider is a trigger, false otherwise.
   */
  public function isTrigger(): bool;

  /**
   * Set if this collider is a trigger. A trigger collider does not collide with other colliders, but still
   * triggers events.
   *
   * @param bool $isTrigger True if this collider is a trigger, false otherwise.
   * @return void
   */
  public function setTrigger(bool $isTrigger): void;

  /**
   * Set the collision detection strategy for this collider.
   *
   * @param CollisionDetectionStrategyInterface $collisionDetectionStrategy The collision detection strategy.
   * @return void
   */
  public function setCollisionDetectionStrategy(CollisionDetectionStrategyInterface $collisionDetectionStrategy): void;

  /**
   * Get the bounding box of this collider.
   *
   * @return Rect The bounding box of this collider.
   */
  public function getBoundingBox(): Rect;
}