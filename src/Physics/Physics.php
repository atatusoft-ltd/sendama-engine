<?php

namespace Sendama\Engine\Physics;

use Assegai\Collections\ItemList;
use Sendama\Engine\Core\Grid;
use Sendama\Engine\Core\Interfaces\SingletonInterface;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Interfaces\CollisionInterface;
use Sendama\Engine\Physics\Interfaces\SimulatorInterface;

/**
 * Class Physics. Defines the global physics engine and its helper methods and properties.
 *
 * @package Sendama\Engine\Physics
 * @template T
 */
final class Physics implements SingletonInterface, SimulatorInterface
{
  /**
   * @var self<T>|null
   */
  protected static ?self $instance = null;
  /**
   * @var float The gravity applied to all rigid bodies in the scene.
   */
  protected float $gravity = 9.81;
  /**
   * @var ItemList<ColliderInterface<T>> The colliders in the physics engine.
   */
  protected ItemList $colliders;
  /**
   * @var Grid The static collision map. This is used for detecting collisions with static objects in the scene.
   */
  protected Grid $staticCollisionMap;

  /**
   * Physics constructor.
   */
  private function __construct()
  {
    // This is a private constructor to prevent users from creating a new instance of the Physics class.
    /** @var ItemList<ColliderInterface<T>> $colliders */
    $colliders = new ItemList(ColliderInterface::class);

    $this->colliders = $colliders;

    $this->staticCollisionMap = new Grid(100, 100);
  }

  /**
   * @inheritDoc
   *
   * @return self<T>
   */
  public static function getInstance(): self
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * Simulates the physics in the Scene.
   */
  public function simulate(): void
  {
    // This method will be called once per frame to simulate the physics in the scene.
    # Get clean slate of physics world

    # Update the physics world

    # Record the collisions

    # Dispatch the collisions
  }

  /**
   * Adds a collider to the physics engine.
   *
   * @param ColliderInterface<T> $collider The collider to add.
   */
  public function addCollider(ColliderInterface $collider): void
  {
    $this->colliders->add($collider);
  }

  /**
   * Removes a collider from the physics engine.
   *
   * @param ColliderInterface<T> $collider The collider to remove.
   * @return void
   */
  public function removeCollider(ColliderInterface $collider): void
  {
    if (! $this->colliders->remove($collider) ) {
      Debug::warn("Failed to remove collider from physics engine.");
    }
  }

  /**
   * Checks for collisions between the given collider and all other colliders in the physics engine.
   *
   * @param ColliderInterface<T> $collider The collider to check for collisions.
   * @param Vector2 $motion The motion of the collider.
   * @return array<CollisionInterface<T>> The collisions found.
   */
  public function checkCollisions(ColliderInterface $collider, Vector2 $motion): array
  {
    $collisions = [];

    foreach ($this->colliders as $otherCollider) {
      if ($collider->isTouching($otherCollider)) {
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

  /**
   * Loads the static collision map.
   *
   * @param Grid $grid The grid to load.
   * @return void
   */
  public function loadStaticCollisionMap(Grid $grid): void
  {
    $this->staticCollisionMap = $grid;
  }

  /**
   * Checks if the given position is touching a static object.
   *
   * @param Vector2 $position The position to check.
   * @return bool Whether the given position is touching a static object or not.
   */
  public function isTouchingStaticObject(Vector2 $position): bool
  {
    [$x, $y] = [$position->getX(), $position->getY()];

    return $this->staticCollisionMap->get($x, $y) === 1;
  }

  /**
   * Checks if the given position is touching a dynamic object.
   *
   * @param Vector2 $position The position to check.
   * @return bool Whether the given position is touching a dynamic object or not.
   */
  public function isTouchingDynamicObject(Vector2 $position): bool
  {
    foreach ($this->colliders as $collider) {
      if ($collider->getTransform()->getPosition() === $position) {
        return true;
      }
    }

    return false;
  }
}