<?php

namespace Sendama\Engine\Physics;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Transform;
use Sendama\Engine\Physics\Interfaces\CollisionInterface;

/**
 * Collision class. Represents a collision between two colliders.
 */
class Collision implements CollisionInterface
{
  /**
   * Collision constructor.
   *
   * @param Collider $collider The collider that collided.
   * @param ContactPoint[] $contacts The contacts of the collision.
   */
  public function __construct(
    protected Collider $collider,
    protected array $contacts
  )
  {
  }

  /**
   * @inheritDoc
   */
  public function getGameObject(): GameObject
  {
    return $this->collider->getGameObject();
  }

  /**
   * @inheritDoc
   */
  public function getTransform(): Transform
  {
    return $this->getGameObject()->getTransform();
  }

  /**
   * @inheritDoc
   */
  public function getContact(int $index): ?ContactPoint
  {
    return $this->contacts[$index] ?? null;
  }

  /**
   * @inheritDoc
   */
  public function getContacts(): array
  {
    return $this->contacts;
  }
}