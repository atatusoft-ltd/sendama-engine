<?php

namespace Sendama\Engine\Core\Scenes;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Vector2;
use Sendama\Examples\Blasters\Scripts\PlayerController;

class ExampleScene extends AbstractScene
{
  public function __construct(string $name = 'Example Scene')
  {
    parent::__construct($name);

    $player = new GameObject('Player', position: new Vector2(2, 2));
    $player->addComponent(PlayerController::class);
    $player->setSprite('Textures/player.texture', Vector2::zero(), Vector2::one());
    $this->add($player);

  }
}