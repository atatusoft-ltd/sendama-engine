<?php

namespace Sendama\Examples\Collector\Scripts\Collectable;

use Override;
use Sendama\Engine\Core\Behaviours\Behaviour;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Physics\Interfaces\CollisionInterface;
use Sendama\Examples\Collector\Scripts\Game\LevelManager;

/**
 * Class AppleController is responsible for controlling the apple.
 *
 * @package Sendama\Examples\Collector\Scripts\Collectable
 */
class AppleController extends Behaviour
{
  public ?LevelManager $levelManager = null;

  #[Override]
  public function onStart(): void
  {
    $this->randomizePosition();
  }

  /**
   * @inheritDoc
   */
  public function onCollisionEnter(CollisionInterface $collision): void
  {
    if ($collision->getGameObject()->getName() === 'Player')
    {
      // Increase the score
      $this->levelManager->incrementScore();
    }

    $this->randomizePosition();
  }

  protected function randomizePosition(): void
  {
    $this->getTransform()->setPosition(new Vector2(rand(0, 80), rand(0, 26)));
  }
}