<?php

namespace Sendama\Engine\Physics;

use Sendama\Engine\Core\Component;
use Sendama\Engine\Physics\Interfaces\ColliderInterface;

class Collider extends Component implements ColliderInterface
{
  protected bool $isTrigger = false;

  /**
   * @inheritDoc
   */
  public function isTouching(ColliderInterface $collider): bool
  {
    $spriteRect = $this->getGameObject()->getSprite()->getRect();
    $colliderRect = $collider->getGameObject()->getSprite()->getRect();

    return $spriteRect->overlaps($colliderRect);
  }

  /**
   * @inheritDoc
   */
  public function isTrigger(): bool
  {
    return $this->isTrigger;
  }

  /**
   * @inheritDoc
   */
  public function setTrigger(bool $isTrigger): void
  {
    $this->isTrigger = $isTrigger;
  }
}