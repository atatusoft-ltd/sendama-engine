<?php

namespace Sendama\Engine\Physics\Strategies;

use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Strategies\AbstractCollisionDetectionStrategy;

/**
 * Class SimpleCollisionDetectionStrategy. A simple collision detection strategy.
 *
 * @package Sendama\Engine\Physics\Strategies
 */
class SimpleCollisionDetectionStrategy extends AbstractCollisionDetectionStrategy
{
  /**
   * @inheritDoc
   */
  public function isTouching(ColliderInterface $collider): bool
  {
    $position = $collider->getTransform()->getPosition();

    if ($this->physics->isTouchingStaticObject($position)) {
      return true;
    }

    if ($this->physics->isTouchingDynamicObject($position)) {
      return true;
    }

    return false;
  }
}