<?php

namespace Sendama\Engine\Core\Scenes;

use Sendama\Engine\Core\Behaviours\CharacterMovement;
use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Sprite;
use Sendama\Engine\Core\Texture2D;
use Sendama\Engine\Core\Vector2;

/**
 * Class ExampleScene is an example scene.
 *
 * @package Sendama\Engine\Core\Scenes
 */
class ExampleScene extends AbstractScene
{
  /**
   * @inheritDoc
   */
  public function awake(): void
  {
    $this->environmentTileMapPath = 'Maps/example';

    # Create the actors in the scene (i.e. game objects and ui elements)
    $player = new GameObject('Player', position: new Vector2(2, 2));

    # Set up the player
    $playerTexture = new Texture2D('Textures/player.texture');
    $player->setSprite($playerTexture, Vector2::zero(), Vector2::one());
    /**
     * @var CharacterMovement $characterMovement
     */
    $characterMovement = $player->addComponent(CharacterMovement::class);
    $characterMovement->setSpeed(1);
    $characterMovement->setSprites(
      new Sprite($playerTexture, ['x' => 0, 'y' => 0, 'width' => 1, 'height' => 1]),
      new Sprite($playerTexture, ['x' => 1, 'y' => 0, 'width' => 1, 'height' => 1]),
      new Sprite($playerTexture, ['x' => 2, 'y' => 0, 'width' => 1, 'height' => 1]),
      new Sprite($playerTexture, ['x' => 3, 'y' => 0, 'width' => 1, 'height' => 1]),
    );

    # Add the player to the scene
    $this->add($player);
  }
}