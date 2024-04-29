<?php

namespace Sendama\Engine\Core;

/**
 * Class Sprite
 *
 * @package Sendama\Engine\Core
 */
class Sprite
{
  protected Rect $rect;
  /**
   * Sprite constructor. Creates a new sprite.
   *
   * @param Texture2D $texture The texture of the sprite.
   * @param Rect|array{x: int, y: int, width: int, height: int} $rect The rectangle of the sprite.
   * @param Vector2 $pivot The pivot of the sprite.
   */
  public function __construct(
    protected Texture2D $texture,
    Rect|array $rect,
    protected Vector2 $pivot = new Vector2(0, 0),
  )
  {
    $this->rect = is_array($rect) ? Rect::fromArray($rect) : $rect;
  }

  /**
   * Returns the texture of the sprite.
   *
   * @return Texture2D The texture of the sprite.
   */
  public function getTexture(): Texture2D
  {
    return $this->texture;
  }

  /**
   * Sets the texture of the sprite.
   *
   * @param Texture2D $texture The texture to set.
   * @return void
   */
  public function setTexture(Texture2D $texture): void
  {
    $this->texture = $texture;
  }

  /**
   * Returns the rectangle of the sprite.
   *
   * @return Rect The rectangle of the sprite.
   */
  public function getRect(): Rect
  {
    return $this->rect;
  }

  /**
   * Sets the rectangle of the sprite.
   *
   * @param Rect $rect The rectangle to set.
   * @return void
   */
  public function setRect(Rect $rect): void
  {
    $this->rect = $rect;
  }

  /**
   * Returns the pivot of the sprite.
   *
   * @return Vector2 The pivot of the sprite.
   */
  public function getPivot(): Vector2
  {
    return $this->pivot;
  }

  /**
   * Sets the pivot of the sprite.
   *
   * @param Vector2 $pivot The pivot to set.
   * @return void
   */
  public function setPivot(Vector2 $pivot): void
  {
    $this->pivot = $pivot;
  }

  /**
   * Returns the buffered image of the sprite.
   *
   * @return string[] The buffered image of the sprite.
   */
  public function getBufferedImage(): array
  {
    $buffer = [];
    $rectX = $this->rect->getX();
    $rectY = $this->rect->getY();
    $width = $this->rect->getWidth();
    $height = $this->rect->getHeight();
    $pixels = $this->texture->getPixels();

    for ($y = 0; $y < $height; $y++)
    {
      $buffer[$y] = [];
      for ($x = 0; $x < $width; $x++)
      {
        $buffer[$y][$x] = $pixels[$rectY + $y][$rectX + $x];
      }
    }
    return $buffer;
  }
}