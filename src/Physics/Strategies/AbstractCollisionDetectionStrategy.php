<?php

namespace Sendama\Engine\Physics\Strategies;

use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Interfaces\CollisionDetectionStrategyInterface;

abstract class AbstractCollisionDetectionStrategy implements CollisionDetectionStrategyInterface
{
  public final function __construct(protected ColliderInterface $collider)
  {
    // Constructor logic here
  }
}