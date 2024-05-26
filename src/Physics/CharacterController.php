<?php

namespace Sendama\Engine\Physics;

use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Physics\Interfaces\CollisionInterface;

/**
 * The class CharacterController. It allows you to do movement constrained by collisions without having to deal with a
 * rigidbody. It is not affected by forces and will only move when call the move method. It then carries out the
 * movement and will be constrained by collisions.
 *
 * @package Sendama\Engine\Physics
 */
class CharacterController extends Collider
{
  /**
   * Moves the character.
   *
   * @param Vector2 $motion The motion.
   * @return void
   */
  public function move(Vector2 $motion): void
  {
    $collisions = $this->physics->checkCollisions($this, $motion);

    // If there are no collisions, move the character.
    $this->getTransform()->translate($motion);

    // If there are collisions, resolve them.
    foreach ($collisions as $collision)
    {
      $this->resolveCollision($collision);
    }
  }

  /**
   * Resolves the collision.
   *
   * @param mixed $collision The collision.
   * @return void
   */
  private function resolveCollision(CollisionInterface $collision): void
  {
    // TODO: Implement collision resolution.
    $collision->getContact(0)->getThisCollider()->getGameObject()->broadcast("onCollisionEnter", ['collision' => $collision]);
    $collision->getContact(0)->getOtherCollider()->getGameObject()->broadcast("onCollisionEnter", ['collision' => $collision]);

    Debug::log("Collision for {$collision->getGameObject()->getName()} at " . $collision->getContact(0)?->getPoint());
  }
}