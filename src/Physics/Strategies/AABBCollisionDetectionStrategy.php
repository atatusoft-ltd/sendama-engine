<?php

namespace Sendama\Engine\Physics\Strategies;

use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;

/**
 * Class AABBCollisionDetectionStrategy implements the AABB collision detection strategy.
 *
 * @package Sendama\Engine\Physics\Strategies
 */
class AABBCollisionDetectionStrategy extends AbstractCollisionDetectionStrategy
{

  /**
   * @inheritDoc
   */
  public function isTouching(ColliderInterface $collider): bool
  {
    if ($this->collider->getGameObject()->getName() === $collider->getGameObject()->getName())
    {
      return false;
    }

    $thisColliderBoundingBox = $this->collider->getBoundingBox();
    $otherColliderBoundingBox = $collider->getBoundingBox();

    if (
      $thisColliderBoundingBox->getX() < $otherColliderBoundingBox->getX() + $otherColliderBoundingBox->getWidth() + 1 &&
      $thisColliderBoundingBox->getX() + $thisColliderBoundingBox->getWidth() + 1> $otherColliderBoundingBox->getX() &&
      $thisColliderBoundingBox->getY() < $otherColliderBoundingBox->getY() + $otherColliderBoundingBox->getHeight() + 1 &&
      $thisColliderBoundingBox->getY() + $thisColliderBoundingBox->getHeight() + 1 > $otherColliderBoundingBox->getY()
    )
    {
      Debug::log(__CLASS__ . ' detected a collision between ' . $this->collider->getGameObject()->getName() . ' and ' . $collider->getGameObject()->getName() . '.');
      Debug::log(sprintf("box1.x < box2.x + box2.width: %s < %s + %s", $thisColliderBoundingBox->getX(), $otherColliderBoundingBox->getX(), $otherColliderBoundingBox->getWidth()));
      Debug::log(sprintf("box1.x + box1.width > box2.x: %s + %s > %s", $thisColliderBoundingBox->getX(), $thisColliderBoundingBox->getWidth(), $otherColliderBoundingBox->getX()));
      Debug::log(sprintf("box1.y < box2.y + box2.height: %s < %s + %s", $thisColliderBoundingBox->getY(), $otherColliderBoundingBox->getY(), $otherColliderBoundingBox->getHeight()));
      Debug::log(sprintf("box1.y + box1.height > box2.y: %s + %s > %s", $thisColliderBoundingBox->getY(), $thisColliderBoundingBox->getHeight(), $otherColliderBoundingBox->getY()));
      return true;
    }

    return false;
  }
}