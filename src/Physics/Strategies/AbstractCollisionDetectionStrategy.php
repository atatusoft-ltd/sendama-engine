<?php

namespace Sendama\Engine\Physics\Strategies;

use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Interfaces\CollisionDetectionStrategyInterface;

/**
 * The class AbstractCollisionDetectionStrategy.
 *
 * @package Sendama\Engine\Physics\Strategies
 */
abstract class AbstractCollisionDetectionStrategy implements CollisionDetectionStrategyInterface
{
  /**
   * AbstractCollisionDetectionStrategy constructor.
   *
   * @template T
   * @param ColliderInterface<T> $collider The collider to check if it is touching.
   */
  public final function __construct(protected ColliderInterface $collider)
  {
    // Constructor logic here
  }
}