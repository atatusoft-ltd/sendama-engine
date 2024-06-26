<?php

namespace Sendama\Engine\Physics;

use Assegai\Collections\ItemList;
use Sendama\Engine\Core\Interfaces\SingletonInterface;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Interfaces\CollisionInterface;

/**
 * Class Physics. Defines the global physics engine and its helper methods and properties.
 *
 * @package Sendama\Engine\Physics
 */
final class Physics implements SingletonInterface
{
  /**
   * @var self|null
   */
  protected static ?self $instance = null;
  /**
   * @var float The gravity applied to all rigid bodies in the scene.
   */
  protected float $gravity = 9.81;
  /**
   * @var ItemList<ColliderInterface> The colliders in the physics engine.
   */
  protected ItemList $colliders;

  /**
   * Physics constructor.
   */
  private function __construct()
  {
    // This is a private constructor to prevent users from creating a new instance of the Physics class.
    $this->colliders = new ItemList(ColliderInterface::class);
  }

  /**
   * @inheritDoc
   *
   * @return self
   */
  public static function getInstance(): self
  {
    if (self::$instance === null)
    {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * Simulates the physics in the Scene.
   */
  public static function simulate(): void
  {

  }

  /**
   * Adds a collider to the physics engine.
   *
   * @param ColliderInterface $collider The collider to add.
   */
  public function addCollider(ColliderInterface $collider): void
  {
    $this->colliders->add($collider);
  }

  /**
   * Removes a collider from the physics engine.
   *
   * @param ColliderInterface $collider The collider to remove.
   * @return void
   */
  public function removeCollider(ColliderInterface $collider): void
  {
    if (! $this->colliders->remove($collider) )
    {
      Debug::warn("Failed to remove collider from physics engine.");
    }
  }

  /**
   * Checks for collisions between the given collider and all other colliders in the physics engine.
   *
   * @param ColliderInterface $collider The collider to check for collisions.
   * @param Vector2 $motion The motion of the collider.
   * @return array<CollisionInterface> The collisions found.
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
            Vector2::sum($collider->getTransform()->getPosition(), $motion),
            $collider,
            $otherCollider
          )
        ]);
      }
    }

    return $collisions;
  }
}