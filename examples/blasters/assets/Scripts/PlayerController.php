<?php

namespace Sendama\Examples\Blasters\Scripts;

use Sendama\Engine\Core\Behaviour;
use Sendama\Engine\Core\Rect;
use Sendama\Engine\Core\Sprite;
use Sendama\Engine\Core\Texture2D;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\Game;
use Sendama\Engine\IO\Enumerations\AxisName;
use Sendama\Engine\IO\Enumerations\KeyCode;
use Sendama\Engine\IO\Input;

class PlayerController extends Behaviour
{
  protected ?Texture2D $playerTexture = null;
  protected ?Sprite $moveLeftSprite = null;
  protected ?Sprite $moveUpSprite = null;
  protected ?Sprite $moveDownSprite = null;
  protected ?Sprite $moveRightSprite = null;

  /**
   * @inheritDoc
   */
  public function awake(): void
  {
    // TODO: Fix awake hook
  }

  public function onStart(): void
  {
    Debug::info("PlayerController started");

    // TODO: Move these to awake() method after it is fixed
    $this->playerTexture    = new Texture2D('Textures/player.texture');
    $this->moveRightSprite  = new Sprite($this->playerTexture, ['x' => 0, 'y' => 0, 'width' => 1, 'height' => 1]);
    $this->moveLeftSprite   = new Sprite($this->playerTexture, ['x' => 1, 'y' => 0, 'width' => 1, 'height' => 1]);
    $this->moveUpSprite     = new Sprite($this->playerTexture, ['x' => 2, 'y' => 0, 'width' => 1, 'height' => 1]);
    $this->moveDownSprite   = new Sprite($this->playerTexture, ['x' => 3, 'y' => 0, 'width' => 1, 'height' => 1]);
  }

  public function onUpdate(): void
  {
    $this->move(Input::getAxis(AxisName::HORIZONTAL), Input::getAxis(AxisName::VERTICAL));

    if (Input::isAnyKeyPressed([KeyCode::Q, KeyCode::q, KeyCode::ESCAPE]))
    {
      Game::quit();
    }

    if (Input::GetButtonDown('Fire'))
    {
      $this->fire();
    }
  }

  private function move(float $horizontal, float $vertical): void
  {
    if (abs($horizontal) > 0 || abs($vertical) > 0)
    {
      if ($horizontal > 0)
      {
        $this->getGameObject()->getRenderer()->setSprite($this->moveRightSprite);
      }
      else if ($horizontal < 0)
      {
        $this->getGameObject()->getRenderer()->setSprite($this->moveLeftSprite);
      }
      else if ($vertical > 0)
      {
        $this->getGameObject()->getRenderer()->setSprite($this->moveUpSprite);
      }
      else if ($vertical < 0)
      {
        $this->getGameObject()->getRenderer()->setSprite($this->moveDownSprite);
      }

//      Debug::log(sprintf("Moving player with direction x(%s) y(%s)", $horizontal, $vertical));
//      Debug::log("Old Position: " . $this->gameObject->getTransform()->getPosition());
      $this->gameObject->getTransform()->translate(new Vector2($horizontal, $vertical));
//      Debug::log("New Position: " . $this->gameObject->getTransform()->getPosition());
    }
  }

  private function fire(): void
  {
    Debug::log("Player fired");
  }
}