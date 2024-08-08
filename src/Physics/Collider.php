<?php

namespace Sendama\Engine\Physics;

use Override;
use Sendama\Engine\Core\Component;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Interfaces\CollisionDetectionStrategyInterface;
use Sendama\Engine\Physics\Strategies\AABBCollisionDetectionStrategy;
use Sendama\Engine\Physics\Strategies\SeparationBasedCollisionDetectionStrategy;
use Sendama\Engine\Physics\Traits\BoundTrait;

/**
 * The class Collider.
 *
 * @package Sendama\Engine\Physics
 */
class Collider extends Component implements ColliderInterface
{
  use BoundTrait;

  /**
   * The physics.
   *
   * @var Physics|null
   */
  protected ?Physics $physics = null;

  /**
   * Whether the collider is a trigger.
   *
   * @var bool
   */
  protected bool $isTrigger = false;
  /**
   * The collision detection strategy.
   *
   * @var CollisionDetectionStrategyInterface
   */
  protected CollisionDetectionStrategyInterface $collisionDetectionStrategy;

  /**
   * @inheritDoc
   */
  #[Override]
  public final function awake(): void
  {
    $this->physics = Physics::getInstance();
    $this->collisionDetectionStrategy = new AABBCollisionDetectionStrategy($this);
  }

  /**
   * @inheritDoc
   */
  public function isTouching(ColliderInterface $collider): bool
  {
    return $this->collisionDetectionStrategy->isTouching($collider);
  }

  /**
   * @inheritDoc
   */
  public function isTrigger(): bool
  {
    return $this->isTrigger;
  }

  /**
   * @inheritDoc
   */
  public function setTrigger(bool $isTrigger): void
  {
    $this->isTrigger = $isTrigger;
  }

  /**
   * @inheritDoc
   */
  public function setCollisionDetectionStrategy(CollisionDetectionStrategyInterface $collisionDetectionStrategy): void
  {
    $this->collisionDetectionStrategy = $collisionDetectionStrategy;
  }
}