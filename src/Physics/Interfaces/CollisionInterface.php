<?php

namespace Sendama\Engine\Physics\Interfaces;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Transform;
use Sendama\Engine\Physics\ContactPoint;

/**
 * Interface CollisionInterface. Represents a collision between two colliders.
 */
interface CollisionInterface
{
  /**
   * Get the game object of the collider.
   *
   * @return GameObject The game object of the collider.
   */
  public function getGameObject(): GameObject;

  /**
   * Get the transform of the collider.
   *
   * @return Transform The transform of the collider.
   */
  public function getTransform(): Transform;

  /**
   * Get the contact point of the collision.
   *
   * @param int $index The index of the contact point.
   * @return ContactPoint|null The contact point of the collision.
   */
  public function getContact(int $index): ?ContactPoint;

  /**
   * Get all the contact points of the collision.
   *
   * @return ContactPoint[] The contact points of the collision.
   */
  public function getContacts(): array;
}