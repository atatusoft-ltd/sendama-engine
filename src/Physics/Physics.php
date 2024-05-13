<?php

namespace Sendama\Engine\Physics;

use Assegai\Collections\ItemList;
use Sendama\Engine\Core\Interfaces\SingletonInterface;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;

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
}