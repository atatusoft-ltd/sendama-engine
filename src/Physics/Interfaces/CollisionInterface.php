<?php

namespace Sendama\Engine\Physics\Interfaces;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Transform;
use Sendama\Engine\Core\Vector2;

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

  public function getContact(int $index): Vector2;
}