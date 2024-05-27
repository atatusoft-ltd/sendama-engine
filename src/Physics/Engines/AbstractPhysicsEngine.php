<?php

namespace Sendama\Engine\Physics\Engines;

use Assegai\Collections\ItemList;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;
use Sendama\Engine\Physics\Interfaces\PhysicsEngineInterface;

/**
 * Class AbstractPhysicsEngine. Abstract class for physics engines.
 *
 * @package Sendama\Engine\Physics\Engines
 */
abstract class AbstractPhysicsEngine implements PhysicsEngineInterface
{
  /**
   * AbstractPhysicsEngine constructor.
   *
   * @param ItemList<ColliderInterface> $colliders The colliders in the physics engine.
   */
  public function __construct(
    protected ItemList $colliders
  )
  {
  }
}