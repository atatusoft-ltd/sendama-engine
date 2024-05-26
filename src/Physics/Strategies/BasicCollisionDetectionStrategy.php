<?php

namespace Sendama\Engine\Physics\Strategies;

use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Strategies\AbstractCollisionDetectionStrategy;

class BasicCollisionDetectionStrategy extends AbstractCollisionDetectionStrategy
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

    if ($this->collider->getTransform()->getPosition()->getX() !== $collider->getTransform()->getPosition()->getX())
    {
      return false;
    }

    if ($this->collider->getTransform()->getPosition()->getY() !== $collider->getTransform()->getPosition()->getY())
    {
      return false;
    }

    return true;
  }
}