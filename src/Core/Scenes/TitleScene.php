<?php

namespace Sendama\Engine\Core\Scenes;

use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Sprite;
use Sendama\Engine\Core\Texture2D;
use Sendama\Engine\Core\Vector2;
use Sendama\Examples\Blasters\Scripts\PlayerController;

class TitleScene extends AbstractScene
{
  public function __construct(?string $name = null)
  {
    parent::__construct($name ?? 'Title Scene');

    $player = new GameObject('Player', position: new Vector2(2, 2));
    $player->addComponent(PlayerController::class);
    $player->setSprite('Textures/player.texture', Vector2::zero(), Vector2::one());
    $this->add($player);
  }
}