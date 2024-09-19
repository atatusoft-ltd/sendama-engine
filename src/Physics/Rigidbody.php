<?php

namespace Sendama\Engine\Physics;

use Sendama\Engine\Core\Component;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Interfaces\CollisionDetectionStrategyInterface;
use Sendama\Engine\Physics\Strategies\AABBCollisionDetectionStrategy;
use Sendama\Engine\Physics\Traits\BoundTrait;

/**
 * The class Rigidbody.
 *
 * @package Sendama\Engine\Physics
 *
 * @template T
 * @implements ColliderInterface<T>
 */
class Rigidbody extends Component implements ColliderInterface
{
  use BoundTrait;

  /**
   * @var CollisionDetectionStrategyInterface|null The collision detection strategy.
   */
  protected ?CollisionDetectionStrategyInterface $collisionDetectionStrategy = null;

  /**
   * @inheritDoc
   */
  public function onStart(): void
  {
    $this->collisionDetectionStrategy = new AABBCollisionDetectionStrategy($this);
  }

  /**
   * @inheritDoc
   *
   * @param ColliderInterface<T> $collider The collider to check if it is touching.
   */
  public function isTouching(ColliderInterface $collider): bool
  {
    if (!$this->collisionDetectionStrategy) {
      return false;
    }

    return $this->collisionDetectionStrategy->isTouching($collider);
  }

  /**
   * @inheritDoc
   */
  public function isTrigger(): bool
  {
    return false;
  }

  /**
   * @inheritDoc
   */
  public function setTrigger(bool $isTrigger): void
  {
    // Do nothing.
  }

  /**
   * @inheritDoc
   */
  public function setCollisionDetectionStrategy(CollisionDetectionStrategyInterface $collisionDetectionStrategy): void
  {
    $this->collisionDetectionStrategy = $collisionDetectionStrategy;
  }
}