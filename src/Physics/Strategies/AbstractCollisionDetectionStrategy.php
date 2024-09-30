<?php

namespace Sendama\Engine\Physics\Strategies;

use Override;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Interfaces\CollisionDetectionStrategyInterface;
use Sendama\Engine\Physics\Physics;

/**
 * The class AbstractCollisionDetectionStrategy.
 *
 * @package Sendama\Engine\Physics\Strategies
 */
abstract class AbstractCollisionDetectionStrategy implements CollisionDetectionStrategyInterface
{
  protected Physics $physics;

  /**
   * AbstractCollisionDetectionStrategy constructor.
   *
   * @template T
   * @param ColliderInterface<T> $collider The collider to check if it is touching.
   */
  public final function __construct(protected ColliderInterface $collider)
  {
    // Constructor logic here
    $this->physics = Physics::getInstance();
    $this->configure();
  }

  /**
   * @inheritDoc
   */
  #[Override]
  public function configure(array $options = []): void
  {
    // Do nothing
  }
}