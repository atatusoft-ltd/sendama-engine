<?php

namespace Sendama\Examples\Blasters\Scenes;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Scenes\AbstractScene;
use Sendama\Engine\Core\Vector2;
use Sendama\Examples\Blasters\Scripts\PlayerController;

class Level01 extends AbstractScene
{
  public function __construct()
  {
    parent::__construct('Level 01', 'Maps/level01.tmap');
  }

  /**
   * @inheritDoc
   */
  public function awake(): void
  {
    $screenHeight = $this->getSettings('screen_height');

    if (! is_int($screenHeight) )
    {
      $screenHeight = DEFAULT_SCREEN_HEIGHT;
    }

    $playerStartingX = 4;
    $playerStartingY = $screenHeight / 2;
    $player = new GameObject('Player', position: new Vector2($playerStartingX, $playerStartingY) );
    $player->addComponent(PlayerController::class);
    $player->setSprite('Textures/player.texture', Vector2::zero(), Vector2::one());
    $this->add($player);
  }
}