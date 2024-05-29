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

    $box1 = $this->collider->getBoundingBox();
    $box2 = $collider->getBoundingBox();

    if (
      $box1->getX() < $box2->getX() + $box2->getWidth() &&
      $box1->getX() + $box1->getWidth() > $box2->getX() &&
      $box1->getY() < $box2->getY() + $box2->getHeight() &&
      $box1->getY() + $box1->getHeight() > $box2->getY()
    )
    {
      Debug::log(__CLASS__ . ' detected a collision between ' . $this->collider->getGameObject()->getName() . ' and ' . $collider->getGameObject()->getName() . '.');
      Debug::log($this->collider->getGameObject()->getName() . ' is at ' . $this->collider->getTransform()->getPosition());
      Debug::log($collider->getGameObject()->getName() . ' is at ' . $collider->getTransform()->getPosition());
      Debug::log(sprintf("box1.x < box2.x + box2.width: %s < %s + %s", $box1->getX(), $box2->getX(), $box2->getWidth()));
      Debug::log(sprintf("box1.x + box1.width > box2.x: %s + %s > %s", $box1->getX(), $box1->getWidth(), $box2->getX()));
      Debug::log(sprintf("box1.y < box2.y + box2.height: %s < %s + %s", $box1->getY(), $box2->getY(), $box2->getHeight()));
      Debug::log(sprintf("box1.y + box1.height > box2.y: %s + %s > %s", $box1->getY(), $box1->getHeight(), $box2->getY()));
      return true;
    }

    return false;
  }
}