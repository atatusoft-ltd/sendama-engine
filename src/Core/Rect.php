<?php

namespace Sendama\Engine\Core;

use Sendama\Engine\Core\Traits\DimensionTrait;
use Sendama\Engine\Core\Traits\PositionTrait;

/**
 * The rect class.
 */
class Rect
{
  use PositionTrait;
  use DimensionTrait;

  /**
   * Create a new instance of the rect.
   *
   * @param int $x The x position.
   * @param int $y The y position.
   * @param int $width The width.
   * @param int $height The height.
   * @return void
   */
  public function __construct(int $x = 0, int $y = 0, int $width = 0, int $height = 0)
  {
    $this->setX($x);
    $this->setY($y);
    $this->setWidth($width);
    $this->setHeight($height);
  }

  /**
   * Set the values of the rect.
   *
   * @param int|null $x The x position.
   * @param int|null $y The y position.
   * @param int|null $width The width.
   * @param int|null $height The height.
   * @return void
   */
  public function set(?int $x = null, ?int $y = null, ?int $width = null, ?int $height = null): void
  {
    $this->setX($x ?? $this->x);
    $this->setY($y ?? $this->y);
    $this->setWidth($width ?? $this->width);
    $this->setHeight($height ?? $this->height);
  }

  /**
   * Check if the rect contains the specified point.
   *
   * @param Vector2 $point The point to check.
   * @return bool True if the rect contains the point, false otherwise.
   */
  public function contains(Vector2 $point): bool
  {
    return $point->getX() >= $this->getX() && $point->getX() <= $this->getX() + $this->getWidth() &&
           $point->getY() >= $this->getY() && $point->getY() <= $this->getY() + $this->getHeight();
  }

  /**
   * Check if the rect overlaps with the specified rect.
   *
   * @param Rect $other The other rect.
   * @return bool True if the rect overlaps with the other rect, false otherwise.
   */
  public function overlaps(Rect $other): bool
  {
    return $this->contains(new Vector2($other->getX(), $other->getY())) ||
           $this->contains(new Vector2($other->getX() + $other->getWidth(), $other->getY())) ||
           $this->contains(new Vector2($other->getX(), $other->getY() + $other->getHeight())) ||
           $this->contains(new Vector2($other->getX() + $other->getWidth(), $other->getY() + $other->getHeight()));
  }
}