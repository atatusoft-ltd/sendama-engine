<?php

namespace Sendama\Engine\Core\Rendering;

use Sendama\Engine\Core\Component;
use Sendama\Engine\Core\GameObject;
use Sendama\Engine\Core\Interfaces\CanRender;
use Sendama\Engine\Core\Sprite;
use Sendama\Engine\IO\Console\Console;

class Renderer extends Component implements CanRender
{
  /**
   * Renderer constructor.
   *
   * @param GameObject $gameObject
   * @param Sprite|null $sprite
   */
  public function __construct(
    GameObject $gameObject,
    protected ?Sprite $sprite = null
  )
  {
    parent::__construct($gameObject);
  }

  /**
   * Returns the sprite of the renderer.
   *
   * @return Sprite|null The sprite of the renderer.
   */
  public final function getSprite(): ?Sprite
  {
    return $this->sprite;
  }

  public final function setSprite(?Sprite $sprite): void
  {
    $this->sprite = $sprite;
  }

  /**
   * @inheritDoc
   */
  public final function onUpdate(): void
  {
    // TODO: Remove this code
//    $this->sprite?->setRect(
//      new Rect(
//        $this->gameObject->getTransform()->getPosition(),
//        $this->sprite->getRect()->getSize()
//      )
//    );
  }

  /**
   * @inheritDoc
   */
  public final function render(): void
  {
    if (!$this->sprite)
    {
      return;
    }

    $xOffset = $this->getGameObject()->getTransform()->getPosition()->getX();
    $yOffset = $this->getGameObject()->getTransform()->getPosition()->getY();
    $spriteBufferedImage = $this->sprite->getBufferedImage();

    for ($y = 0; $y < $this->sprite->getRect()->getHeight(); $y++)
    {
      for ($x = 0; $x < $this->sprite->getRect()->getWidth(); $x++)
      {
        $targetX = $xOffset + $x;
        $targetY = $yOffset + $y;

        if ($targetX < 0 || $targetY < 0)
        {
          continue;
        }

        // Move the console cursor to the position of the sprite.
        Console::cursor()->moveTo($targetX, $targetY);

        // Render the sprite.
        echo $spriteBufferedImage[$y][$x];
      }
    }
  }

  /**
   * @inheritDoc
   */
  public final function renderAt(?int $x = null, ?int $y = null): void
  {
    // Do nothing.
  }

  /**
   * @inheritDoc
   */
  public final function erase(): void
  {
    if (!$this->sprite)
    {
      return;
    }

    $xOffset = $this->getGameObject()->getTransform()->getPosition()->getX();
    $yOffset = $this->getGameObject()->getTransform()->getPosition()->getY();

    for ($y = 0; $y < $this->sprite->getRect()->getHeight(); $y++)
    {
      for ($x = 0; $x < $this->sprite->getRect()->getWidth(); $x++)
      {
        $targetX = $xOffset + $x;
        $targetY = $yOffset + $y;

        if ($targetX < 0 || $targetY < 0)
        {
          continue;
        }

        // Move the console cursor to the position of the sprite.
        Console::cursor()->moveTo($targetX, $targetY);

        // Erase the sprite.
        echo ' ';
      }
    }
  }

  /**
   * @inheritDoc
   */
  public final function eraseAt(?int $x = null, ?int $y = null): void
  {
    // Do nothing.
  }
}