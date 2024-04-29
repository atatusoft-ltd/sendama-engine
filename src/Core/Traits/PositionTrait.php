<?php

namespace Sendama\Engine\Core\Traits;

/**
 * Trait PositionTrait. This trait is used to add position properties to a class.
 *
 * @package Sendama\Engine\Core\Traits
 */
trait PositionTrait
{
  /**
   * @var int The x position.
   */
  protected int $x = 0;
  /**
   * @var int The y position.
   */
  protected int $y = 0;

  /**
   * Get the x position.
   *
   * @return int The x position.
   */
  public function getX(): int
  {
    return $this->x;
  }

  /**
   * Set the x position.
   *
   * @param int $x The x position.
   * @return void
   */
  public function setX(int $x): void
  {
    $this->x = $x;
  }

  /**
   * Get the y position.
   *
   * @return int The y position.
   */
  public function getY(): int
  {
    return $this->y;
  }

  /**
   * Set the y position.
   *
   * @param int $y The y position.
   */
  public function setY(int $y): void
  {
    $this->y = $y;
  }
}