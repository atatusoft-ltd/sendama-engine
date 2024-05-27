<?php

namespace Sendama\Engine\Physics;

use Assegai\Collections\ItemList;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Events\Interfaces\EventInterface;
use Sendama\Engine\Events\Interfaces\ObservableInterface;
use Sendama\Engine\Events\Interfaces\ObserverInterface;
use Sendama\Engine\Events\Interfaces\StaticObserverInterface;
use Sendama\Engine\Physics\Interfaces\CollisionInterface;

/**
 * The class CharacterController. It allows you to do movement constrained by collisions without having to deal with a
 * rigidbody. It is not affected by forces and will only move when call the move method. It then carries out the
 * movement and will be constrained by collisions.
 *
 * @package Sendama\Engine\Physics
 */
class CharacterController extends Collider implements ObservableInterface
{
  /**
   * The observers.
   *
   * @var ItemList
   */
  protected ItemList $observers;

  /**
   * @var array<CollisionInterface> The previous collisions.
   */
  private array $previousCollisions = [];

  public function onStart(): void
  {
    $this->observers = new ItemList(ObserverInterface::class);
  }

  /**
   * Moves the character.
   *
   * @param Vector2 $motion The motion.
   * @return void
   */
  public function move(Vector2 $motion): void
  {
    $collisions = $this->physics->checkCollisions($this, $motion);
    $canMove = true;

    // If there are collisions, resolve them.
    foreach ($collisions as $collision)
    {
      if ($collision->getContact(0)->getSeparation())
      $this->resolveCollision($collision);
    }

    // If there are no collisions, move the character.
    $this->getTransform()->translate($motion);
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
    $methodName = match (true) {
      $this->previousCollisionsIncludes($collision) => "onCollisionStay",
      default => "onCollisionEnter"
    };

    $collision
      ->getContact(0)
      ->getThisCollider()
      ->getGameObject()
      ->broadcast($methodName, ['collision' => $collision]);
    $collision
      ->getContact(0)
      ->getOtherCollider()
      ->getGameObject()
      ->broadcast($methodName, ['collision' => $collision]);

    Debug::log("Collision for {$collision->getGameObject()->getName()} at " . $collision->getContact(0)?->getPoint());
  }

  /**
   * @inheritDoc
   */
  public function addObservers(string|StaticObserverInterface|ObserverInterface ...$observers): void
  {
    foreach ($observers as $observer)
    {
      $this->observers->add($observer);
    }
  }

  /**
   * @inheritDoc
   */
  public function removeObservers(string|StaticObserverInterface|ObserverInterface|null ...$observers): void
  {
    foreach ($observers as $observer)
    {
      $this->observers->remove($observer);
    }
  }

  /**
   * @inheritDoc
   */
  public function notify(EventInterface $event): void
  {
    foreach ($this->observers as $observer)
    {
      $observer->onNotify($event);
    }
  }

  /**
   * Checks if the previous collisions includes the collision.
   *
   * @param mixed $collision The collision.
   * @return bool
   */
  private function previousCollisionsIncludes(CollisionInterface $collision): bool
  {
    foreach ($this->previousCollisions as $previousCollision)
    {
      if ($previousCollision->getContact(0)?->getOtherCollider() === $collision->getContact(0)?->getOtherCollider())
      {
        return true;
      }
    }

    return false;
  }
}