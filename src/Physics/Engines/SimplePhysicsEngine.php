<?php

namespace Sendama\Engine\Physics\Engines;

use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Physics\Collision;
use Sendama\Engine\Physics\ContactPoint;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Interfaces\PhysicsEngineInterface;

/**
 * Class SimplePhysicsEngine. A simple physics engine that checks for collisions by checking if colliders are touching.
 *
 * @package Sendama\Engine\Physics\Engines
 * @template T
 * @extends AbstractPhysicsEngine<T>
 */
class SimplePhysicsEngine extends AbstractPhysicsEngine
{
  /**
   * @inheritDoc
   */
  public function checkCollisions(ColliderInterface $collider, Vector2 $motion): array
  {
    $collisions = [];

    foreach ($this->colliders as $otherCollider)
    {
      if ($collider->isTouching($otherCollider))
      {
        $collisions[] = new Collision($otherCollider, [
          new ContactPoint(
            $motion,
            $collider,
            $otherCollider
          )
        ]);
      }
    }

    return $collisions;
  }
}