<?php

namespace Sendama\Engine\Physics;

use Sendama\Engine\Core\Component;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;

class Rigidbody extends Component implements ColliderInterface
{

  /**
   * @inheritDoc
   */
  public function isTouching(ColliderInterface $collider): bool
  {
    // TODO: Implement isTouching() method.

    return false;
  }

  /**
   * @inheritDoc
   */
  public function isTrigger(): bool
  {
    return false;
  }

  /**
   * @inheritDoc
   */
  public function setTrigger(bool $isTrigger): void
  {
    // Do nothing.
  }
}