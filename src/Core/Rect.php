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
   * @param Vector2 $position The position.
   * @param Vector2 $size The size.
   */
  public function __construct(
    Vector2 $position = new Vector2(0, 0),
    Vector2 $size = new Vector2(0, 0),
  )
  {
    $this->setX($position->getX());
    $this->setY($position->getY());
    $this->setWidth($size->getX());
    $this->setHeight($size->getY());
  }

  /**
   * Set the values of the rect.
   *
   * @param Vector2|null $position The position.
   * @param Vector2|null $size The size.
   * @return void
   */
  public function set(
    ?Vector2 $position = null,
    ?Vector2 $size = null,
  ): void
  {
    $this->setX($position->getX() ?? $this->x);
    $this->setY($position->getY() ?? $this->y);
    $this->setWidth($size->getX() ?? $this->width);
    $this->setHeight($size->getY() ?? $this->height);
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