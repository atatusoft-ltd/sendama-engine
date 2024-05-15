<?php

namespace Sendama\Examples\Collector\Scenes;

use Sendama\Engine\Core\Behaviours\CharacterMovement;
use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Scenes\AbstractScene;
use Sendama\Engine\Core\Sprite;
use Sendama\Engine\Core\Texture2D;
use Sendama\Engine\Core\Vector2;
use Sendama\Examples\Collector\Scripts\Game\LevelManager;

/**
 * Class Level01. This is the first level of the game.
 *
 * @package Sendama\Examples\Collector\Scenes
 */
class Level01 extends AbstractScene
{

  /**
   * @inheritDoc
   */
  public function awake(): void
  {
    $this->environmentTileMapPath = 'Maps/level01';

    // Create the actors in the scene (i.e. game objects and ui elements)
    $levelManager = new GameObject('LevelManager');
    $player = new GameObject('Player');

    // Set up the level manager
    $levelManager->addComponent(LevelManager::class);

    // Set up the player
    $screenHeight = $this->getSettings('screen_height');

    if (! is_int($screenHeight) )
    {
      $screenHeight = DEFAULT_SCREEN_HEIGHT;
    }

    $playerStartingX = 4;
    $playerStartingY = $screenHeight / 2;
    $playerTexture = new Texture2D('Textures/player.texture');
    $player->getTransform()->setPosition(new Vector2($playerStartingX, $playerStartingY));
    /**
     * @var CharacterMovement $playerMovement
     */
    $playerMovement = $player->addComponent(CharacterMovement::class);
    $playerMovement->setSprites(
      new Sprite($playerTexture, ['x' => 0, 'y' => 0, 'width' => 1, 'height' => 1]),
      new Sprite($playerTexture, ['x' => 1, 'y' => 0, 'width' => 1, 'height' => 1]),
      new Sprite($playerTexture, ['x' => 2, 'y' => 0, 'width' => 1, 'height' => 1]),
      new Sprite($playerTexture, ['x' => 3, 'y' => 0, 'width' => 1, 'height' => 1])
    );
    $playerMovement->setSpeed(2);
    $player->setSprite($playerTexture, Vector2::zero(), Vector2::one());

    // Add the game objects to the scene
    $this->add($levelManager);
    $this->add($player);
  }
}