<?php

namespace Sendama\Engine\Physics\Interfaces;

/**
 * Interface ColliderInterface. Interface for colliders.
 *
 * @package Sendama\Engine\Physics\Interfaces
 */
interface ColliderInterface
{
  /**
   * Check if this collider is touching another collider.
   *
   * @param ColliderInterface $collider The collider to check if this collider is touching.
   * @return bool True if this collider is touching the other collider, false otherwise.
   */
  public function isTouching(ColliderInterface $collider): bool;

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
}