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
  private GameObject $player;
  public function __construct(?string $name = null)
  {
    parent::__construct($name ?? 'Title Scene');

    $this->player = new GameObject('Player', position: new Vector2(2, 2));
    $this->player->addComponent(PlayerController::class);
    $playerTexture = new Texture2D('Textures/player.texture', width: 4);
    $this->player
      ->getRenderer()
      ->setSprite(new Sprite($playerTexture, new Rect(Vector2::zero(), Vector2::one())));

    $this->rootGameObjects[] = $this->player;
  }
}