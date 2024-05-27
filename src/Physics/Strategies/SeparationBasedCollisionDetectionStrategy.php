<?php

namespace Sendama\Engine\Physics\Strategies;

use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Strategies\AbstractCollisionDetectionStrategy;

/**
 * The class SeparationBasedCollisionDetectionStrategy.
 *
 * @package Sendama\Engine\Physics\Strategies
 */
class SeparationBasedCollisionDetectionStrategy extends AbstractCollisionDetectionStrategy
{
  /**
   * @inheritDoc
   */
  public function isTouching(ColliderInterface $collider): bool
  {
    return Vector2::distance(
      $this->collider->getTransform()->getPosition(),
      $collider->getTransform()->getPosition()
    ) < 1;
  }
}