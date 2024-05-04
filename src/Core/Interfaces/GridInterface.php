<?php

namespace Sendama\Engine\Core\Interfaces;

use Stringable;

/**
 * The interface for all grid classes.
 *
 * @template T
 * @template-implements CanCompare<T>
 */
interface GridInterface extends CanCompare, Stringable
{
  /**
   * Returns the width of the grid.
   *
   * @return int The width of the grid.
   */
  public function getWidth(): int;

  /**
   * Returns the height of the grid.
   *
   * @return int The height of the grid.
   */
  public function getHeight(): int;

  /**
   * Returns the value at the specified position.
   *
   * @param int $x The x-coordinate.
   * @param int $y The y-coordinate.
   * @return T The value at the specified position.
   */
  public function get(int $x, int $y): mixed;

  /**
   * Sets the value at the specified position.
   *
   * @param int $x The x-coordinate.
   * @param int $y The y-coordinate.
   * @param T $value The value to set.
   * @return void
   */
  public function set(int $x, int $y, mixed $value): void;

  /**
   * Fills the grid with the specified value.
   *
   * @param int $x The x-coordinate.
   * @param int $y The y-coordinate.
   * @param int $width The width of the fill.
   * @param int $height The height of the fill.
   * @param T $value The value to fill with.
   * @return void
   */
  public function fill(int $x, int $y, int $width, int $height, mixed $value): void;

  /**
   * Returns the grid as an array.
   *
   * @return T[][] The grid as an array.
   */
  public function toArray(): array;
}