<?php

namespace Sendama\Engine\Core\Behaviours;

use Sendama\Engine\Core\Behaviours\Attributes\SerializeField;
use Sendama\Engine\Core\Sprite;
use Sendama\Engine\Core\Vector2;
use Sendama\Engine\Debug\Debug;
use Sendama\Engine\IO\Enumerations\AxisName;
use Sendama\Engine\IO\Input;
use Sendama\Engine\Physics\CharacterController;

class CharacterMovement extends Behaviour
{
  #[SerializeField]
  private int $speed = 1;

  #[SerializeField]
  private ?Sprite $rightMovementSprite = null;

  #[SerializeField]
  private ?Sprite $leftMovementSprite = null;

  #[SerializeField]
  private ?Sprite $upMovementSprite = null;

  #[SerializeField]
  private ?Sprite $downMovementSprite = null;

  private ?CharacterController $characterController = null;

  /**
   * Gets the speed of the character.
   *
   * @return int The speed of the character.
   */
  public function getSpeed(): int
  {
    return $this->speed;
  }

  /**
   * Sets the speed of the character.
   *
   * @param int $speed The speed of the character.
   * @return void
   */
  public function setSpeed(int $speed): void
  {
    $this->speed = $speed;
  }
  /**
   * Sets the sprites for the character movement.
   *
   * @param Sprite $right The sprite for right movement.
   * @param Sprite $left The sprite for left movement.
   * @param Sprite $up The sprite for up movement.
   * @param Sprite $down The sprite for down movement.
   * @return void
   */
  public function setSprites(
    Sprite $right,
    Sprite $left,
    Sprite $up,
    Sprite $down
  ): void
  {
    $this->rightMovementSprite = $right;
    $this->leftMovementSprite = $left;
    $this->upMovementSprite = $up;
    $this->downMovementSprite = $down;
  }

  public function onStart(): void
  {
    $this->characterController = $this->getComponent(CharacterController::class);
  }

  public function onUpdate(): void
  {
    $h = Input::getAxis(AxisName::HORIZONTAL);
    $v = Input::getAxis(AxisName::VERTICAL);

    if  (abs($h) > 0 || abs($v) > 0)
    {
      if ($h > 0 && $this->rightMovementSprite)
      {
        $this->getRenderer()->setSprite($this->rightMovementSprite);
      }
      else if ($h < 0 && $this->leftMovementSprite)
      {
        $this->getRenderer()->setSprite($this->leftMovementSprite);
      }
      else if ($v > 0 && $this->upMovementSprite)
      {
        $this->getRenderer()->setSprite($this->upMovementSprite);
      }
      else if ($v < 0 && $this->downMovementSprite)
      {
        $this->getRenderer()->setSprite($this->downMovementSprite);
      }

      $velocity = new Vector2($h, $v);
      $velocity->scale($this->speed);

      if ($this->characterController)
      {
        $this->characterController->move($velocity);
      }
      else
      {
        $this->getTransform()->translate($velocity);
      }
    }
  }
}