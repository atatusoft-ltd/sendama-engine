<?php

namespace Sendama\Engine\Physics;

use Override;
use Sendama\Engine\Core\Component;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Interfaces\CollisionDetectionStrategyInterface;
use Sendama\Engine\Physics\Strategies\AABBCollisionDetectionStrategy;
use Sendama\Engine\Physics\Strategies\BasicCollisionDetectionStrategy;

/**
 * The class Collider.
 *
 * @package Sendama\Engine\Physics
 */
class Collider extends Component implements ColliderInterface
{
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
    $this->collisionDetectionStrategy = new BasicCollisionDetectionStrategy($this);
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

  /**
   * @inheritDoc
   */
  public function getBoundingBox(): Rect
  {
    $x =
      $this->getTransform()
        ->getPosition()
        ->getX() +
      $this->getGameObject()
        ->getSprite()
        ->getPivot()
        ->getX() -
      $this->getGameObject()
        ->getSprite()
        ->getRect()
        ->getX();
    $y =
      $this->getTransform()
        ->getPosition()
        ->getY() +
      $this->getGameObject()
        ->getSprite()
        ->getPivot()
        ->getY() -
      $this->getGameObject()
        ->getSprite()
        ->getRect()
        ->getY();
    return new Rect(
      new Vector2($x,$y),
      new Vector2(
        $this->getGameObject()->getSprite()->getRect()->getWidth(),
        $this->getGameObject()->getSprite()->getRect()->getHeight()
      )
    );
  }
}